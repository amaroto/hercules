<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Services\ClientService;

use PDF;

use Exception;

final class ClientController extends Controller
{
    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(Request $request): JsonResponse
    {
        return new JsonResponse (
            $this->clientService->index((int) $request->page, (int) $request->items, $request->query()),
            Response::HTTP_OK
        );
    }

    public function exportPdf(Request $request)
    {
        $leads = $this->clientService->index((int) $request->page, (int) $request->items, $request->query(), false);
        return (PDF::loadView('pdf/pdf_client_view', ['data' => $leads->items()]))->download('clientList_'.uniqid().'.pdf');
    }

    public function find(int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->clientService->find($id), Response::HTTP_OK);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->clientService->update($id, $request->all()), Response::HTTP_NO_CONTENT);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            return new JsonResponse($this->clientService->save($request->all()), Response::HTTP_CREATED);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->clientService->delete($id), Response::HTTP_OK);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
