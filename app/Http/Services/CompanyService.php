<?php

namespace App\Http\Services;

use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;
use App\Models\Company;
use Spatie\QueryBuilder\QueryBuilder;
use  Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

final class CompanyService
{

    public function index(int $page = 1, int $items = 100, $filters = [], bool $collection = true)
    {
        unset($filters['page']);
        unset($filters['items']);

        $companies = Company::latest()->paginate($items, ['*'], 'page', $page);

        if ($filters) {
            $request = new Request(['filter' => $filters]);

            $companies = QueryBuilder::for(Company::class, $request)
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

        return $collection ? new CompanyCollection($companies) : $companies;
    }

    public function find(int $id): CompanyResource
    {
        $lead = Company::find($id);

        if (!$lead) throw new Exception('Company not found');

        return new CompanyResource($lead);
    }

    public function delete(int $id): void
    {
        $lead = Company::find($id);

        if (!$lead) throw new Exception('Company not found');

        $lead->delete();
    }

    public function destroy(int $id): void
    {
        $lead = Company::find($id);

        if (!$lead) throw new Exception('Company not found');

        $lead->destroy();
    }

    public function restore(int $id): void
    {
        $lead = Company::withTrashed()->where('id', $id);

        if (!$lead) throw new Exception('Company not restored');

        $lead->restore();
    }

    public function update(int $id, array $data): void
    {
        $this->find($id);

        $valid = Validator::make($data, [
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]);

        if ($valid->fails()) throw new Exception('Company not updated');

        Company::where("id", $id)->update($data);
    }

    public function save(array $data): void
    {
        $valid = Validator::make($data, [
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]);

        if ($valid->fails()) throw new Exception('Company not created');

        Company::create($data);
    }

}
