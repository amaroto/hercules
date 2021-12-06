<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
      $this->validateLogin($request);

      if (!Auth::attempt($request->only('email', 'password'))) {
        return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
      }

      $permissions = $request->user()->getPermissionsFromRoles();

      return new JsonResponse([
          'token' => $request->user()
          ->createToken(
              $request->device,
              $permissions
            )
          ->plainTextToken],
          Response::HTTP_OK
    );
    }

    private function validateLogin(Request $request): void
    {
      $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device' => 'required'
      ]);
    }

}
