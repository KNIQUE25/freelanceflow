<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function __construct(private AuditService $audit) {}

    public function getAllForUser(int $userId): LengthAwarePaginator
    {
        return Client::query()
            ->where('user_id', $userId)
            ->withCount('invoices')
            ->latest()
            ->paginate(15);
    }

    public function create(int $userId, array $data): Client
    {
        $client = Client::create([...$data, 'user_id' => $userId]);
        $this->audit->log('client.created', $client, null, $client->toArray(), $userId);
        return $client;
    }

    public function update(Client $client, array $data): Client
    {
        $old = $client->toArray();
        $client->update($data);
        $this->audit->log('client.updated', $client, $old, $client->fresh()->toArray());
        return $client->refresh();
    }

    public function delete(Client $client): void
    {
        DB::transaction(function () use ($client) {
            $old = $client->toArray();
            $this->audit->log('client.deleted', $client, $old, null);
            $client->delete();
        });
    }
}
