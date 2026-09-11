<?php

namespace App\Services;

use App\Models\User;
use App\Stores\UserStore;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function __construct(protected UserStore $userStore)
    {
    }

    public function getUsers(?string $search = null, int $perPage = 20): LengthAwarePaginator
    {
        return $this->userStore->getPaginatedUsers($search, $perPage);
    }

    public function getUser(User $user): User
    {
        return $this->userStore->findWithCounts($user);
    }

    public function getAllUsers(): Collection
    {
        return $this->userStore->getAllUsers();
    }

    public function suspendUser(User $user): User
    {
        return $this->userStore->suspend($user);
    }

    public function activateUser(User $user): User
    {
        return $this->userStore->activate($user);
    }

    public function deleteUser(User $user): bool
    {
        return $this->userStore->delete($user);
    }
}