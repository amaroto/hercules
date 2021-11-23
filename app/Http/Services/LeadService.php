<?php

namespace App\Http\Services;

use App\Http\Resources\Lead\LeadCollection;
use App\Http\Resources\Lead\LeadResource;
use App\Models\Lead;
use Spatie\QueryBuilder\QueryBuilder;
use  Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

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
        $lead = Lead::find($id);

        if (!$lead) throw new Exception('Lead not found');

        return new LeadResource($lead);
    }

    public function delete(int $id): void
    {
        $lead = Lead::find($id);

        if (!$lead) throw new Exception('Lead not found');

        $lead->delete();
    }

    public function destroy(int $id): void
    {
        $lead = Lead::find($id);

        if (!$lead) throw new Exception('Lead not found');

        $lead->destroy();
    }

    public function restore(int $id): void
    {
        $lead = Lead::withTrashed()->where('id', $id);

        if (!$lead) throw new Exception('Lead not restored');

        $lead->restore();
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

        if ($valid->fails()) throw new Exception('Lead not updated');

        Lead::where("id", $id)->update($data);
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

        if ($valid->fails()) throw new Exception('Lead not created');

        Lead::create($data);
    }

}
