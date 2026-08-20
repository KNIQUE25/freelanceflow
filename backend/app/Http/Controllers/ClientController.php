<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{
    public function __construct(private ClientService $service) {}

    public function index(): AnonymousResourceCollection
    {
        return ClientResource::collection($this->service->getAllForUser(auth()->id()));
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        return (new ClientResource($this->service->create(auth()->id(), $request->validated())))->response()->setStatusCode(201);
    }

    public function show(Client $client): ClientResource
    {
        $this->authorize('view', $client);
        return new ClientResource($client->load('invoices'));
    }

    public function update(UpdateClientRequest $request, Client $client): ClientResource
    {
        $this->authorize('update', $client);
        return new ClientResource($this->service->update($client, $request->validated()));
    }

    public function destroy(Client $client): JsonResponse
    {
        $this->authorize('delete', $client);
        $this->service->delete($client);
        return response()->json(['message' => 'Client deleted successfully.']);
    }
}
