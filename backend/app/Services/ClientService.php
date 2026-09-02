<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClientService
{
    /**
     * Get all clients for a user with optional search.
     */
    public function getAllForUser(int $userId, ?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Client::where('user_id', $userId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('company', 'LIKE', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        return Client::create($data);
    }

    public function update(Client $client, array $data)
    {
        $client->update($data);
        return $client;
    }

    public function delete(Client $client)
    {
        $client->delete();
    }
}