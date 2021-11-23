<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Resources\User\UserResource;
use App\Http\Services\UserService;
use Exception;
use PDF;

final class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        return new JsonResponse (
            $this->userService->index((int) $request->page, (int) $request->items, $request->query()),
            Response::HTTP_OK
        );
    }

    public function exportPdf(Request $request)
    {
        $users = $this->userService->index((int) $request->page, (int) $request->items, $request->query(), false);
        return (PDF::loadView('pdf/pdf_user_view', ['data' => $users->items()]))->download('userList_'.uniqid().'.pdf');
    }

    public function profile(Request $request): JsonResponse
    {
      return new JsonResponse(new UserResource($request->user()), Response::HTTP_OK);
    }

    public function find(int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->userService->find($id), Response::HTTP_OK);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->userService->update($id, $request->all()), Response::HTTP_OK);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            return new JsonResponse($this->userService->save($request->all()), Response::HTTP_CREATED);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->userService->delete($id), Response::HTTP_NO_CONTENT);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
