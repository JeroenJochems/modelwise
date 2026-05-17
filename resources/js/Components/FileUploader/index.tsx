import {useEffect, useId, useRef, useState} from "react";
import {v4 as uuidv4} from 'uuid';
import {ProgressBar} from "@/Components/FileUploader/ProgressBar";
import {ExistingFile} from "@/Components/FileUploader/ExistingFile";
import InputError from "@/Components/InputError";
import {move} from '@dnd-kit/helpers';
import axios from "axios";
import * as UpChunk from "@mux/upchunk";
import {usePage} from "@inertiajs/react";
import {PageProps} from "@/types";
import {
    DndContext,
    closestCenter,
    KeyboardSensor,
    PointerSensor,
    useSensor,
    useSensors,
    DragEndEvent
} from '@dnd-kit/core';
import {
    arrayMove,
    SortableContext,
    sortableKeyboardCoordinates,
    useSortable,
    rectSortingStrategy
} from '@dnd-kit/sortable';
import clsx from "clsx";

export type BaseFile = {
    muxId?: string
    muxUploadId?: string
    muxStatus?: 'pending' | 'processing' | 'ready' | 'errored'
    muxError?: string | null
    id: number|string
    mime: string
    path: string
    isNew?: boolean
    deleted?: boolean
}

type Props = {
    name?: string
    files: BaseFile[]
    cols?: number
    max?: number
    error?: string
    slots?: number
    colsOnMobile?: number
    onAdd: (file: BaseFile) => void
    accept?: string
    onUpdate: (videos: BaseFile[]) => void
    onToggleUploading?: (state: boolean) => void
    opaqueAfter?: number
}

export function FileUploader({ name, files: filesWithTrashed, error, max = 99, slots = 6, cols = 6, colsOnMobile = 3, accept, onAdd, onUpdate, onToggleUploading, opaqueAfter=undefined }: Props) {

    const muxDirectUploadsEnabled = usePage<PageProps>().props.features?.mux_direct_uploads ?? false;
    const id = useId();
    const ref = useRef<HTMLInputElement>(null);
    const [progress, setProgress] = useState(0)
    const [uploadingFiles, setUploadingFiles] = useState<FileData[]>([]);
    const sensors = useSensors(
        useSensor(PointerSensor, {
            activationConstraint: { distance: 8 },
        }),
        useSensor(KeyboardSensor, {
            coordinateGetter: sortableKeyboardCoordinates,
        })
    );

    if (accept==="image/*") {
        accept = "image/avif,image/gif,image/heif,image/heic,image/jpeg,image/png,image/webp"
    }

    useEffect(() => {
        let totalSize = 0;
        let totalUploadedSize = 0;

        uploadingFiles
            .forEach(file => {
                totalSize += file.size;
                totalUploadedSize += file.uploadedSize;
            });

        setProgress(totalUploadedSize / totalSize);
    }, [uploadingFiles]);

    const lastEmittedUploadingRef = useRef<boolean | null>(null);
    useEffect(() => {
        if (!onToggleUploading) return;
        const inFlight = uploadingFiles.some(f => f.success === undefined);
        if (lastEmittedUploadingRef.current !== inFlight) {
            lastEmittedUploadingRef.current = inFlight;
            onToggleUploading(inFlight);
        }
    }, [uploadingFiles, onToggleUploading]);

    const processingUploadIds = filesWithTrashed
        .filter(f => f.muxUploadId && f.muxStatus !== 'ready' && f.muxStatus !== 'errored' && !f.deleted)
        .map(f => f.muxUploadId as string);

    useEffect(() => {
        if (processingUploadIds.length === 0) return;

        let cancelled = false;
        const handle = setInterval(async () => {
            for (const uploadId of processingUploadIds) {
                if (cancelled) return;
                try {
                    const { data } = await axios.get<{ status: string; mux_id: string | null; mux_error: string | null }>(
                        `/mux/uploads/${uploadId}/sync`
                    );
                    if (data.status === 'ready' || data.status === 'errored') {
                        onUpdate(filesWithTrashed.map(f =>
                            f.muxUploadId === uploadId
                                ? { ...f, muxStatus: data.status as BaseFile['muxStatus'], muxId: data.mux_id ?? f.muxId, muxError: data.mux_error }
                                : f
                        ));
                    }
                } catch {
                    // swallow — next tick retries
                }
            }
        }, 4000);

        return () => {
            cancelled = true;
            clearInterval(handle);
        };
    }, [processingUploadIds.join('|')]);

    const files = filesWithTrashed.filter((file) => {
        if (file.deleted === undefined) return true;
        return !file.deleted;
    });

    function calcEmptySlots() {
        let empty = slots - files.length;

        while (empty <= 0) {
            empty += slots;
        }

        if (files.length >= max) {
            empty = 0;
        }

        return Array(empty).fill('');
    }

    const handleFileSelect = () => {

        if (!ref.current?.files) return;

        const newFiles = Array.from(ref.current.files).map((file) => ({
            file,
            id: `${file.name}-${file.size}-${Date.now()}`,
            abortController: new AbortController(),
            size: file.size,
            uploadedSize: 0,
        }));

        newFiles.forEach(file => uploadFile(file));

        setUploadingFiles((prev) => [...prev, ...newFiles]);
    };

    function updateUploadedFile(file: FileData, properties: Partial<FileData>) {
        setUploadingFiles(prev =>
            prev.map(f =>
                f.id === file.id
                    ? {...f, ...properties}
                    : f
            )
        );
    }

    async function uploadFile(fileData: FileData) {
        if (muxDirectUploadsEnabled && fileData.file.type.startsWith('video/')) {
            return uploadVideoToMux(fileData);
        }
        return uploadFileToR2(fileData);
    }

    async function uploadFileToR2(fileData: FileData) {

        const response: { data: ResponseType } = await axios.post('/signed-url');

        let headers = response.data.headers;

        if ('Host' in headers) {
            delete headers.Host;
        }

        try {
            await axios.put(response.data.url, fileData.file, {
                signal: fileData.abortController.signal,
                headers,
                onUploadProgress: (progressEvent) => {
                    updateUploadedFile(fileData, { uploadedSize: progressEvent.loaded})
                }
            });

            updateUploadedFile(fileData, { success: true });
            onAdd({
                id: uuidv4(),
                path: response.data.key,
                isNew: true,
                mime: fileData.file.type,
                deleted: false,
            });

        } catch (error) {
            updateUploadedFile(fileData, { success: false })
        }
    }

    async function uploadVideoToMux(fileData: FileData) {
        try {
            const { data } = await axios.post<MuxDirectUploadResponse>('/mux/direct-upload');

            const upload = UpChunk.createUpload({
                endpoint: data.url,
                file: fileData.file,
                chunkSize: 30720,
            });

            upload.on('progress', (event: any) => {
                const percent = Number(event.detail ?? 0);
                updateUploadedFile(fileData, { uploadedSize: (percent / 100) * fileData.size });
            });

            upload.on('error', (event: any) => {
                console.error('UpChunk error', event.detail);
                updateUploadedFile(fileData, { success: false });
            });

            upload.on('success', () => {
                updateUploadedFile(fileData, { success: true, uploadedSize: fileData.size });
                onAdd({
                    id: uuidv4(),
                    muxUploadId: data.upload_id,
                    muxStatus: 'processing',
                    path: '',
                    isNew: true,
                    mime: fileData.file.type,
                    deleted: false,
                });
            });
        } catch (error) {
            console.error('Mux direct upload init failed', error);
            updateUploadedFile(fileData, { success: false });
        }
    }

    function handleDelete({ id }: BaseFile) {
        console.log('delete me');
        if (!onUpdate) return;

        onUpdate(filesWithTrashed.map((file) => {
            if (file.id === id) {
                file.deleted = true;
            }
            return file;
        }));
    }

    function handleDragEnd(event: DragEndEvent) {
        const { active, over } = event;

        if (over && active.id !== over.id) {
            const oldIndex = files.findIndex(file => file.id.toString() === active.id);
            const newIndex = files.findIndex(file => file.id.toString() === over.id);

            if (oldIndex !== -1 && newIndex !== -1) {
                const newFiles = arrayMove([...files], oldIndex, newIndex);
                const updatedFilesWithTrashed = [...filesWithTrashed];

                // Remove all non-deleted files
                const nonDeletedIds = new Set(files.map(file => file.id));
                const remainingFiles = updatedFilesWithTrashed.filter(file => {
                    return file.deleted || !nonDeletedIds.has(file.id);
                });

                // Add reordered files
                updatedFilesWithTrashed.length = 0;
                updatedFilesWithTrashed.push(...remainingFiles, ...newFiles);

                onUpdate(updatedFilesWithTrashed);
            }
        }
    }

    return (
        <>
            <div className={`grid mb-4 gap-2 grid-cols-${colsOnMobile} sm:grid-cols-${cols}`}>
                <DndContext
                    sensors={sensors}
                    collisionDetection={closestCenter}
                    onDragEnd={handleDragEnd}
                >
                    <SortableContext
                        items={files.filter(file => !!file.id).map(file => file.id.toString())}
                        strategy={rectSortingStrategy}
                    >
                        {files.map((file, index) => (
                            <ExistingFile
                                key={file.id?.toString()}
                                className={clsx((opaqueAfter!==undefined && index>=opaqueAfter) ? 'opacity-25' : '') }
                                file={file}
                                onDelete={handleDelete}
                            />
                        ))}

                        {calcEmptySlots().map((slot, i) => (
                            <label key={i} htmlFor={id} className={"static flex rounded text-teal text-2xl cursor-pointer justify-center items-center aspect-[1/1] bg-teal-100 border border-gray-400"}>
                                +
                            </label>)
                        )}
                    </SortableContext>
                </DndContext>
            </div>

            { uploadingFiles.length > 0 && progress < 1 && (
                <ProgressBar progress={progress} />
            )}

            { !!error && <InputError message={error} /> }

            <input name={name} type="file" ref={ref} id={id} accept={accept} multiple className={"hidden"} onChange={handleFileSelect}/>
        </>
    );
}

type ResponseType = {
    uuid: string
    url: string
    key: string
    headers: {
        [key: string]: string
    }
}

type MuxDirectUploadResponse = {
    upload_id: string
    url: string
}

interface FileData {
    id: string;
    file: File;
    size: number;
    uploadedSize: number;
    success?: boolean;
    abortController: AbortController
}
