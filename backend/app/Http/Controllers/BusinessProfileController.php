<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBusinessProfileRequest;
use App\Http\Requests\UpdateBusinessProfileRequest;
use App\Http\Resources\BusinessProfileResource;
use App\Models\BusinessProfile;
use App\Services\BusinessProfileService;
use Illuminate\Http\JsonResponse;

class BusinessProfileController extends Controller
{
    public function __construct(private BusinessProfileService $service) {}

    public function index()
    {
        $profile = $this->service->get();
        return $profile ? new BusinessProfileResource($profile) : response()->json(['data' => null]);
    }

    public function store(StoreBusinessProfileRequest $request): BusinessProfileResource|JsonResponse
    {
        if (auth()->user()->businessProfile) {
            return response()->json(['message' => 'Business profile already exists.'], 409);
        }
        return new BusinessProfileResource($this->service->create($request->validated()));
    }

    public function update(UpdateBusinessProfileRequest $request, BusinessProfile $profile): BusinessProfileResource
    {
        $this->authorize('update', $profile);
        return new BusinessProfileResource($this->service->update($profile, $request->validated()));
    }

    public function destroy(BusinessProfile $profile): JsonResponse
    {
        $this->authorize('delete', $profile);
        $this->service->delete($profile);
        return response()->json(['message' => 'Business profile deleted.']);
    }
}
