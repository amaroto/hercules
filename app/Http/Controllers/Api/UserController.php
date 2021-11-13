<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Resources\UserResource;
use App\Http\Services\UserService;

final class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        return new JsonResponse ($this->userService->index((int) $request->page, (int) $request->items, $request->all()), Response::HTTP_OK);
    }

    public function profile(Request $request): JsonResponse
    {
      return new JsonResponse(new UserResource($request->user()), Response::HTTP_OK);
    }

    public function find(int $id): JsonResponse
    {
      return new JsonResponse($this->userService->find($id), Response::HTTP_OK);
    }

    public function update(Request $request): JsonResponse
    {
      return new JsonResponse($request->user(), Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
      return new JsonResponse($request->user(), Response::HTTP_OK);
    }

    public function delete(int $id): JsonResponse
    {
      return new JsonResponse($this->userService->delete($id), Response::HTTP_OK);
    }

}
