<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClientService;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected ClientService $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $clients = $this->service->getAllForUser(auth()->id(), $search, $perPage);
        return ClientResource::collection($clients);
    }

    public function store(StoreClientRequest $request)
    {
        $client = $this->service->create($request->validated());
        return new ClientResource($client);
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);
        $client->load('invoices');
        return new ClientResource($client);
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);
        $client = $this->service->update($client, $request->validated());
        return new ClientResource($client);
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        $this->service->delete($client);
        return response()->json(['message' => 'Client deleted successfully.']);
    }
}