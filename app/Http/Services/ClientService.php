<?php

namespace App\Http\Services;

use App\Http\Resources\Client\ClientCollection;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;
use Spatie\QueryBuilder\QueryBuilder;
use  Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

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
        $client = Client::find($id);

        if (!$client) throw new Exception('Client not found');

        return new ClientResource($client);
    }

    public function delete(int $id): void
    {
        $client = Client::find($id);

        if (!$client) throw new Exception('Client not found');

        $client->delete();
    }

    public function destroy(int $id): void
    {
        $client = Client::find($id);

        if (!$client) throw new Exception('Client not found');

        $client->destroy();
    }

    public function restore(int $id): void
    {
        $client = Client::withTrashed()->where('id', $id);

        if (!$client) throw new Exception('Client not restored');

        $client->restore();
    }

    public function update(int $id, array $data): void
    {
        $this->find($id);

        $valid = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'nif' => 'required|max:255',
            'details' => 'required|max:255',
            'phone' => 'required|max:255',
            'mobile_phone' => 'required|max:255',
            'company_id' => 'required|max:255'
        ]);

        if ($valid->fails()) throw new Exception('Client not updated');

        Client::where("id", $id)->update($data);
    }

    public function save(array $data): void
    {
        $valid = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'nif' => 'required|max:255',
            'details' => 'required|max:255',
            'phone' => 'required|max:255',
            'mobile_phone' => 'required|max:255',
            'company_id' => 'required|max:255'
        ]);

        if ($valid->fails()) throw new Exception('Client not created');

        Client::create($data);
    }

}
