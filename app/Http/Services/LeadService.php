<?php

namespace App\Http\Services;

use App\Http\Resources\Lead\LeadCollection;
use App\Http\Resources\Lead\LeadResource;
use App\Models\Lead;
use Spatie\QueryBuilder\QueryBuilder;
use  Illuminate\Http\Request;

final class LeadService
{

    public function index(int $page = 1, int $items = 100, $filters = [], bool $collection = true)
    {
        unset($filters['page']);
        unset($filters['items']);

        $leads = Lead::latest()->paginate($items, ['*'], 'page', $page);

        if ($filters) {
            $request = new Request(['filter' => $filters]);

            $leads = QueryBuilder::for(Lead::class, $request)
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

        return $collection ? new LeadCollection($leads) : $leads;
    }

    public function find(int $id): LeadResource
    {
        return new LeadResource(Lead::find($id));
    }

    public function delete(int $id): void
    {
        $lead = Lead::find($id);
        $lead->delete();
    }

    public function destroy(int $id): void
    {
        $lead = Lead::find($id);
        $lead->destroy();
    }

    public function restore(int $id): void
    {
        Lead::withTrashed()->where('id', $id)->restore();
    }

    public function update(int $id, array $data): void
    {
        Lead::where("id", $id)->update($data);
    }

    public function save(array $data): void
    {
        Lead::create($data);
    }

}
