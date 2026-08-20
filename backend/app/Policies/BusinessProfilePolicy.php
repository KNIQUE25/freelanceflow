<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BusinessProfile;

class BusinessProfilePolicy
{
    public function view(User $user, BusinessProfile $profile)
    {
        return $user->id === $profile->user_id;
    }

    public function update(User $user, BusinessProfile $profile)
    {
        return $user->id === $profile->user_id;
    }

    public function delete(User $user, BusinessProfile $profile)
    {
        return $user->id === $profile->user_id;
    }
}