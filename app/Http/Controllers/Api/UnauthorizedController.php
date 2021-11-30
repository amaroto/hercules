<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UnauthorizedController extends Controller
{
    public function index(): JsonResponse
    {
        return new JsonResponse([],Response::HTTP_UNAUTHORIZED);
    }
}
