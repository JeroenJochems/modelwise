# Video Uploader Rewrite — Mux Direct Uploads

**Author:** Jeroen · **Date:** 2026-05-17

## TL;DR

Replace the R2 → `VideoToMux` pipeline with a direct browser-to-Mux upload using [UpChunk](https://github.com/muxinc/upchunk). Eliminates orphaned tmp files, hardcoded `modelwise.net`, the `Storage::move` race, and silent failures on flaky networks. Pair with a webhook handler so the UI knows when Mux is done processing.

**Band-aid already shipped:** wired `onToggleUploading` in `FileUploader/index.tsx` so Submit buttons disable while uploads are in flight.

## Why the current flow is buggy

| Issue | File | Impact |
|---|---|---|
| `mux_id` saved before asset is `ready` → broken player on refresh | `VideoToMux.php:42` | "Upload doesn't work" |
| Upload failures invisible (no retry, no error UI) | `FileUploader/index.tsx:154` | Silent data loss |
| No resumable upload — one packet drop on 4G kills a 200MB upload | `FileUploader/index.tsx:137` | Mobile users give up |
| Hardcoded `https://modelwise.net/` as Mux input URL | `VideoToMux.php:30` | Breaks on `.test` |
| Orphaned files in `tmp/` when user navigates away | `VideoRepository.php:42` | R2 cost + clutter |
| `master_url` caches `null` for 1 hour while Mux processes | `Video.php:89` | Master never appears |
| Drag handle overlaps the delete X button | `ExistingFile/index.tsx:63` | Can't delete on mobile |
| Raw `<video>` with no poster shows black square pre-processing | `ExistingFile/index.tsx:48` | Looks broken |

## Target architecture

**Current:**
```
browser --PUT signed URL--> R2 (tmp/)
                              |
form submit                   |
       \                      v
        +-> Storage::move tmp/ --> videos/
                  \
                   +-> VideoToMux job
                              \
                               +-> Mux fetches from modelwise.net/videos/...
                                          \
                                           +-> mux_id stored (asset NOT ready yet)
```

**New:**
```
POST /mux/direct-upload --> server creates Mux Direct Upload, returns URL + upload_id
                                                                       |
browser --UpChunk (TUS chunks, resumable)--> Mux                       |
                                                |                      |
                                                v                      |
                                     upload.asset_created (webhook) ---+--> Video: mux_asset_id, status=processing
                                                |
                                                v
                                     asset.ready (webhook) -------------+--> Video: mux_id, status=ready
                                                                       |
                                                                       v
                                                            UI poll / partial reload
```

Key insight: videos never touch R2. Mux is storage of record for video. Photo path is untouched.

## Implementation steps

### 1. Migration

Add status tracking + upload correlation key.

```php
Schema::table('videos', function (Blueprint $t) {
    $t->string('mux_upload_id')->nullable()->index();
    $t->string('mux_status')->default('pending'); // pending|uploading|processing|ready|errored
    $t->string('mux_error')->nullable();
});
```

`path` becomes nullable in a follow-up once all writes go through the new flow.

### 2. `MuxClient` abstraction

Wrap the SDK so tests can fake it. `VideoToMux` currently news up `Configuration` + `AssetsApi` inline, which is un-testable.

```php
interface MuxClient {
    public function createDirectUpload(string $corsOrigin): MuxDirectUploadResult;
    public function getAsset(string $assetId): MuxAssetResult;
}
```

Bind real impl in `AppServiceProvider`, `FakeMuxClient::class` in tests.

### 3. Endpoint `POST /mux/direct-upload`

```php
Route::post('/mux/direct-upload', CreateMuxDirectUpload::class)
    ->middleware(['auth', 'throttle:30,1']);

public function __invoke(Request $r, MuxClient $mux) {
    Gate::authorize('uploadFiles', [$r->user(), null]);

    $upload = $mux->createDirectUpload(config('app.url'));

    return response()->json([
        'upload_id' => $upload->id,
        'url' => $upload->url,
    ]);
}
```

### 4. Frontend: UpChunk in `FileUploader`

Branch on mime: images keep the R2 signed-URL flow; videos use UpChunk.

```tsx
import * as UpChunk from '@mux/upchunk';

async function uploadVideo(fileData: FileData) {
    const { data } = await axios.post('/mux/direct-upload');

    const upload = UpChunk.createUpload({
        endpoint: data.url,
        file: fileData.file,
        chunkSize: 30720, // 30 MB
    });

    upload.on('error', err => updateUploadedFile(fileData, { success: false, error: err.detail }));
    upload.on('progress', e => updateUploadedFile(fileData, { uploadedSize: (e.detail / 100) * fileData.size }));
    upload.on('success', () => {
        updateUploadedFile(fileData, { success: true });
        onAdd({
            id: uuidv4(),
            muxUploadId: data.upload_id,
            mime: fileData.file.type,
            path: '',
            isNew: true,
            status: 'processing',
        });
    });
}
```

### 5. Webhook `POST /webhooks/mux`

```php
Route::post('/webhooks/mux', MuxWebhookController::class)
    ->middleware(MuxSignatureMiddleware::class);
```

Handles:
- `video.upload.asset_created` → look up Video by `mux_upload_id`, store `mux_asset_id`
- `video.asset.ready` → store `mux_id` (playback id), flip status to `ready`
- `video.asset.errored` → status `errored`, capture error

### 6. Rewrite `VideoRepository::update`

No more `Storage::move`. Bind `mux_upload_id` to the videoable; webhooks fill the rest.

```php
public function update(EloquentModel $model, string $folder, array $videos): void {
    foreach ($videos as $v) {
        if (!empty($v['isNew']) && empty($v['deleted'])) {
            $video = Video::firstOrNew(['mux_upload_id' => $v['muxUploadId']]);
            $video->videoable()->associate($model);
            $video->folder = $folder;
            $video->mux_status ??= 'processing';
            $video->save();
        }
    }
    // ...handle deletes + reorder
}
```

### 7. Processing-state UI

```tsx
{ file.mime.includes('video') && (
    file.status === 'ready'
        ? <MuxPlayer playbackId={file.muxId} />
        : file.status === 'errored'
            ? <ErrorTile reason={file.muxError} />
            : <ProcessingTile />   // spinner + "Processing, ~30s"
)}
```

Inertia partial reload every 5s while any video has `status === 'processing'`. Echo/Reverb is overkill.

### 8. Cleanup

- Delete `VideoToMux` action
- Delete `RemuxVideos` command
- Drop video usage from `VaporSignedStorageUrl` (keep for images)
- Lower `master_url` cache TTL to 30s when result is `null`
- Replace full-area drag overlay in `ExistingFile` with a dedicated grip icon

## Testing strategy

### Vitest
- `FileUploader` emits `onToggleUploading(true)` on start, `(false)` on finish/fail
- UpChunk error event renders retry UI
- Files over max size are rejected client-side
- Image flow still uses R2 signed URL (regression guard)

### Pest
- `CreateMuxDirectUpload` calls `MuxClient` with correct asset settings (FakeMuxClient)
- Webhook `asset_created` → Video gets `mux_asset_id`
- Webhook `asset.ready` → Video gets `mux_id` + status=`ready`
- Webhook signature verification rejects unsigned payloads
- `VideoRepository::update` binds upload_id, makes no R2 calls

### Playwright (one happy + one sad)
- Route-intercept Mux upload URL; assert Submit disabled during upload, enabled after
- Force intercepted upload to 500; assert Retry button appears, retry succeeds
- Flip status via test-only endpoint → assert MuxPlayer appears

### Observability
- Sentry breadcrumb on every UpChunk error event
- Log webhook payloads on `asset.errored` with Mux reason
- Counter `video.upload.failed` tagged by mime + size bucket + page

## Rollout

1. Migration + `MuxClient` interface — no behavior change
2. Direct-upload endpoint + webhook handler behind `config('features.mux_direct_uploads')`
3. FileUploader branches on flag, image path untouched
4. Enable for staff users, then one casting, then global
5. After 2 weeks stable: delete `VideoToMux` / `RemuxVideos` / R2 video paths

### Risks to validate up front
- Mux CORS: `cors_origin` must exactly match browser origin including scheme + port
- Direct upload URLs expire after 1h; fine for normal sessions
- Webhook delivery is asynchronous; UI must tolerate the gap between upload-complete and `asset.ready`
- Existing videos keep working unchanged (different status default)

## Estimate

~3 working days end to end.
