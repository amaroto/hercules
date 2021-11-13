<?php

namespace App\Http\Services;

use App\Models\User;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;

final class UserService
{

    public function index(int $page = 1, int $items = 100, $filters = []): UserCollection
    {
        $user = User::latest();

        if ($filters) {
            if (isset($filters['username'])) $user->orWhere('username', 'like', $filters['username']);
            if (isset($filters['firstname'])) $user->orWhere('firstname', 'like', $filters['firstname']);
            if (isset($filters['lastname'])) $user->orWhere('lastname', 'like', $filters['lastname']);
            if (isset($filters['email'])) $user->orWhere('email', 'like', $filters['email']);
            if (isset($filters['active'])) $user->orWhere('active', 'like', $filters['active']);
        }

        return new UserCollection(
            $user->paginate($items, ['*'], 'page', $page)
        );
    }

    public function find(int $id): UserResource
    {
        return new UserResource(User::find($id));
    }

    public function update(): void
    {

    }

    public function save(): void
    {

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
