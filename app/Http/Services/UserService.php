<?php

namespace App\Http\Services;

use App\Models\User;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Spatie\QueryBuilder\QueryBuilder;
use  Illuminate\Http\Request;

final class UserService
{

    public function index(int $page = 1, int $items = 100, $filters = []): UserCollection
    {
        $users = User::latest()->paginate($items, ['*'], 'page', $page);

        if ($filters) {
            unset($filters['page']);
            unset($filters['items']);

            $request = new Request(['filter' => $filters]);

            $users = QueryBuilder::for(User::class, $request)
                ->defaultSort('created_at')
                ->allowedFilters(['username', 'firstname', 'lastname', 'email', 'active'])
                ->paginate($items, ['*'], 'page', $page);
        }

        return new UserCollection($users);
    }

    public function find(int $id): UserResource
    {
        return new UserResource(User::find($id));
    }

    public function update(int $id, array $data): void
    {
        dd($id, $data);
    }

    public function save(array $data): void
    {
        dd($data);
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
}
