<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckForAnyAbility
{
    public function handle($request, $next, ...$abilities)
    {
        if (! $request->user() || ! $request->user()->currentAccessToken()) {
            return new JsonResponse([],Response::HTTP_UNAUTHORIZED);
        }

        foreach ($abilities as $ability) {
            if ($request->user()->tokenCan($ability)) {
                return $next($request);
            }
        }

        return new JsonResponse([],Response::HTTP_UNAUTHORIZED);
    }
}
