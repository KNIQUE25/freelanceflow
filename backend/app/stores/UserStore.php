<?php

namespace App\Stores;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserStore
{
   
public function getPaginatedUsers(?string $search = null, int $perPage = 20)
{
    return User::query()
        ->when(filled($search), function ($q) use ($search) {
            $q->where(function ($q2) use ($search) {
                $q2->where('name', 'like', '%' . $search . '%')
                   ->orWhere('email', 'like', '%' . $search . '%');
            });
        })
        ->withCount([
            'clients',
            'clients.invoices as invoices_count',
        ])
        ->latest('id')
        ->paginate($perPage)
        ->withQueryString();
}

public function findWithCounts(User $user): User
{
    return $user->loadCount([
        'clients',
        'clients.invoices as invoices_count',
    ]);
}

public function getAllUsers(): \Illuminate\Database\Eloquent\Collection
{
    return User::query()
        ->withCount([
            'clients',
            'clients.invoices as invoices_count',
        ])
        ->latest('id')
        ->get();
}

    public function suspend(User $user): User
    {
        $user->update(['suspended_at' => now()]);
        return $user->fresh();
    }

    public function activate(User $user): User
    {
        $user->update(['suspended_at' => null]);
        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
