<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Actions\AddToRole;
use Domain\Work2\Actions\DeleteListing;
use Domain\Work2\Actions\Hire;
use Domain\Work2\Actions\Invite;
use Domain\Work2\Actions\Reject;
use Domain\Work2\Actions\Shortlist;
use Domain\Work2\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListingApiController extends Controller
{
    public function addToRole(Role $role, Model $model, AddToRole $action): JsonResponse
    {
        $action->execute($role, $model);

        return response()->json(['message' => 'Added to role']);
    }

    public function invite(Role $role, Model $model, Invite $action): JsonResponse
    {
        $action->execute($role, $model);

        return response()->json(['message' => 'Invited']);
    }

    public function shortlist(Listing $listing, Shortlist $action): JsonResponse
    {
        $action->execute($listing);

        return response()->json(['message' => 'Shortlisted']);
    }

    public function hire(Listing $listing, Hire $action): JsonResponse
    {
        $action->execute($listing);

        return response()->json(['message' => 'Hired']);
    }

    public function reject(Listing $listing, Request $request, Reject $action): JsonResponse
    {
        $action->execute(
            $listing,
            $request->input('subject', 'Update on your casting application'),
            $request->input('message', 'Unfortunately, we have decided not to proceed with your application at this time.'),
        );

        return response()->json(['message' => 'Rejected']);
    }

    public function reinvite(Listing $listing, Invite $action): JsonResponse
    {
        $action->execute($listing->role, $listing->model);

        return response()->json(['message' => 'Reinvited']);
    }

    public function destroy(Listing $listing): JsonResponse
    {
        if ($listing->applied_at || $listing->hired_at) {
            return response()->json(['message' => 'Cannot delete listing that has been applied to or hired'], 422);
        }

        $listing->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function toggleFavorited(Listing $listing): JsonResponse
    {
        $listing->favorited_at = $listing->favorited_at ? null : now();
        $listing->save();

        return response()->json([
            'message' => 'Toggled',
            'favorited_at' => $listing->favorited_at,
        ]);
    }

    public function reorder(Role $role, Request $request): JsonResponse
    {
        $orderedIds = $request->input('ordered_listing_ids', []);

        foreach ($orderedIds as $index => $listingId) {
            Listing::query()
                ->where('id', $listingId)
                ->where('role_id', $role->id)
                ->update(['order_column' => $index]);
        }

        return response()->json(['message' => 'Reordered']);
    }

    public function bulkInvite(Role $role, Request $request, Invite $action): JsonResponse
    {
        $modelIds = $request->input('model_ids', []);
        $results = [];

        foreach ($modelIds as $modelId) {
            try {
                $model = Model::findOrFail($modelId);
                $action->execute($role, $model);
                $results[] = ['model_id' => $modelId, 'success' => true];
            } catch (\Throwable $e) {
                $results[] = ['model_id' => $modelId, 'success' => false, 'error' => $e->getMessage()];
            }
        }

        return response()->json(['results' => $results]);
    }

    public function bulkShortlist(Role $role, Request $request, Shortlist $action): JsonResponse
    {
        $listingIds = $request->input('listing_ids', []);
        $results = [];

        foreach ($listingIds as $listingId) {
            try {
                $listing = Listing::findOrFail($listingId);
                $action->execute($listing);
                $results[] = ['listing_id' => $listingId, 'success' => true];
            } catch (\Throwable $e) {
                $results[] = ['listing_id' => $listingId, 'success' => false, 'error' => $e->getMessage()];
            }
        }

        return response()->json(['results' => $results]);
    }

    public function bulkHire(Role $role, Request $request, Hire $action): JsonResponse
    {
        $listingIds = $request->input('listing_ids', []);
        $results = [];

        foreach ($listingIds as $listingId) {
            try {
                $listing = Listing::findOrFail($listingId);
                $action->execute($listing);
                $results[] = ['listing_id' => $listingId, 'success' => true];
            } catch (\Throwable $e) {
                $results[] = ['listing_id' => $listingId, 'success' => false, 'error' => $e->getMessage()];
            }
        }

        return response()->json(['results' => $results]);
    }

    public function bulkReject(Role $role, Request $request, Reject $action): JsonResponse
    {
        $listingIds = $request->input('listing_ids', []);
        $subject = $request->input('subject', 'Update on your casting application');
        $message = $request->input('message', 'Unfortunately, we have decided not to proceed with your application at this time.');
        $results = [];

        foreach ($listingIds as $listingId) {
            try {
                $listing = Listing::findOrFail($listingId);
                $action->execute($listing, $subject, $message);
                $results[] = ['listing_id' => $listingId, 'success' => true];
            } catch (\Throwable $e) {
                $results[] = ['listing_id' => $listingId, 'success' => false, 'error' => $e->getMessage()];
            }
        }

        return response()->json(['results' => $results]);
    }

    public function bulkDelete(Role $role, Request $request, DeleteListing $action): JsonResponse
    {
        $listingIds = $request->input('listing_ids', []);
        $results = [];

        foreach ($listingIds as $listingId) {
            try {
                $listing = Listing::findOrFail($listingId);

                if ($listing->applied_at || $listing->hired_at) {
                    $results[] = ['listing_id' => $listingId, 'success' => false, 'error' => 'Cannot delete listing that has been applied to or hired'];

                    continue;
                }

                $listing->delete();
                $results[] = ['listing_id' => $listingId, 'success' => true];
            } catch (\Throwable $e) {
                $results[] = ['listing_id' => $listingId, 'success' => false, 'error' => $e->getMessage()];
            }
        }

        return response()->json(['results' => $results]);
    }
}
