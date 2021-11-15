<?php

namespace App\Http\Services;

use App\Http\Resources\Client\ClientCollection;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;
use Spatie\QueryBuilder\QueryBuilder;
use  Illuminate\Http\Request;

final class ClientService
{

    public function index(int $page = 1, int $items = 100, $filters = [], bool $collection = true)
    {
        unset($filters['page']);
        unset($filters['items']);

        $clients = Client::latest()->paginate($items, ['*'], 'page', $page);

        if ($filters) {
            $request = new Request(['filter' => $filters]);

            $clients = QueryBuilder::for(Client::class, $request)
                ->defaultSort('created_at')
                ->allowedFilters([
                    'name',
                    'email',
                    'nif',
                    'details',
                    'phone',
                    'mobile_phone',
                    'company_id'
                ])
                ->paginate($items, ['*'], 'page', $page);
        }

        return $collection ? new ClientCollection($clients) : $clients;
    }

    public function find(int $id): ClientResource
    {
        return new ClientResource(Client::find($id));
    }

    public function delete(int $id): void
    {
        $client = Client::find($id);
        $client->delete();
    }

    public function destroy(int $id): void
    {
        $client = Client::find($id);
        $client->destroy();
    }

    public function restore(int $id): void
    {
        Client::withTrashed()->where('id', $id)->restore();
    }

    public function update(int $id, array $data): void
    {
        Client::where("id", $id)->update($data);
    }

    public function save(array $data): void
    {
        Client::create($data);
    }

}
