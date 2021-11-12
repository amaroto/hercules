<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Services\UserServices;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends Controller
{

    private UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function index(Request $request): JsonResponse
    {
        return new JsonResponse($this->userServices->index((int) $request->page, (int) $request->items), Response::HTTP_OK);
    }

    public function profile(Request $request): JsonResponse
    {
      return new JsonResponse($request->user(), Response::HTTP_OK);
    }

}
