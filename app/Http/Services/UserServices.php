<?php

namespace App\Http\Services;

use App\Models\User;
use App\Http\Resources\UserCollection;

final class UserServices
{
    public function index(int $page = 1, int $items = 100)
    {
        return new UserCollection(
            User::latest()->paginate($items, ['*'], 'page', $page)
        );
    }
}
