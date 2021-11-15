<?php

namespace App\Http\Services;

use App\Models\User;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use Spatie\QueryBuilder\QueryBuilder;
use  Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

final class UserService
{

    public function index(int $page = 1, int $items = 100, $filters = [], bool $collection = true)
    {
        unset($filters['page']);
        unset($filters['items']);

        $users = User::latest()->paginate($items, ['*'], 'page', $page);

        if ($filters) {
            $request = new Request(['filter' => $filters]);

            $users = QueryBuilder::for(User::class, $request)
                ->defaultSort('created_at')
                ->allowedFilters([
                    'username',
                    'firstname',
                    'lastname',
                    'email',
                    'active'
                    ])
                ->paginate($items, ['*'], 'page', $page);
        }

        return $collection ? new UserCollection($users) : $users;
    }

    public function find(int $id): UserResource
    {
        return new UserResource(User::find($id));
    }

    public function delete(int $id): void
    {
        $user = User::find($id);
        $user->delete();
    }

    public function destroy(int $id): void
    {
        $user = User::find($id);
        $user->destroy();
    }

    public function restore(int $id): void
    {
        User::withTrashed()->where('id', $id)->restore();
    }

    public function update(int $id, array $data): void
    {
        User::where("id", $id)->update($data);
    }

    public function save(array $data): void
    {
        if(isset($data['password'])) $data['password'] = Hash::make($data['password']);

        User::create($data);
    }

}
