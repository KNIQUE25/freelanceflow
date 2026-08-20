<?php

namespace App\Services;

use App\Models\BusinessProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessProfileService
{
    public function __construct(private AuditService $audit) {}

    public function get(): ?BusinessProfile
    {
        return Auth::user()->businessProfile;
    }

    public function create(array $data): BusinessProfile
    {
        $data['user_id'] = Auth::id();
        $data = $this->prepareLogo($data);
        $profile = BusinessProfile::create($data);
        $this->audit->log('business_profile.created', $profile, null, $profile->toArray());
        return $profile;
    }

    public function update(BusinessProfile $profile, array $data): BusinessProfile
    {
        $old = $profile->toArray();
        $data = $this->prepareLogo($data, $profile);
        $profile->update($data);
        $profile = $profile->refresh();
        $this->audit->log('business_profile.updated', $profile, $old, $profile->toArray());
        return $profile;
    }

    public function delete(BusinessProfile $profile): void
    {
        if ($profile->logo) Storage::disk('public')->delete($profile->logo);
        $old = $profile->toArray();
        $profile->delete();
        $this->audit->log('business_profile.deleted', null, $old, null);
    }

    private function prepareLogo(array $data, ?BusinessProfile $profile = null): array
    {
        if (($data['logo'] ?? null) instanceof UploadedFile) {
            if ($profile?->logo) Storage::disk('public')->delete($profile->logo);
            $data['logo'] = $data['logo']->store('business-logos', 'public');
        } else {
            unset($data['logo']);
        }
        return $data;
    }
}
