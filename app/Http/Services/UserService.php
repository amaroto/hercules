<?php

namespace App\Http\Services;

use App\Models\User;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use Exception;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $user = User::find($id);

        if (!$user) throw new Exception('User not found');

        return new UserResource(User::find($id));
    }

    public function delete(int $id): void
    {
        $user = User::find($id);

        if (!$user) throw new Exception('User not deleted');

        $user->delete();
    }

    public function destroy(int $id): void
    {
        $user = User::find($id);

        if (!$user) throw new Exception('User not destroyed');

        $user->destroy();
    }

    public function restore(int $id): void
    {
        $user = User::withTrashed()->where('id', $id);

        if (!$user) throw new Exception('User not restored');

        $user->restore();
    }

    public function update(int $id, array $data): void
    {
        $this->find($id);

        $valid = Validator::make($data, [
            'username' => 'required|max:255',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'password' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
        ]);

        if ($valid->fails()) throw new Exception('User not updated');

        User::where("id", $id)->update($data);
    }

    public function save(array $data): void
    {
        $valid = Validator::make($data, [
            'username' => 'required|max:255',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'password' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
        ]);

        if ($valid->fails()) throw new Exception('User not created');

        if (isset($data['password'])) $data['password'] = Hash::make($data['password']);

        User::create($data);
    }

}
