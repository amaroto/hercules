<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Services\LeadService;

use PDF;

use Exception;

final class LeadController extends Controller
{
    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function index(Request $request): JsonResponse
    {
        return new JsonResponse (
            $this->leadService->index((int) $request->page, (int) $request->items, $request->query()),
            Response::HTTP_OK
        );
    }

    public function exportPdf(Request $request)
    {
        $leads = $this->leadService->index((int) $request->page, (int) $request->items, $request->query(), false);
        return (PDF::loadView('pdf/pdf_lead_view', ['data' => $leads->items()]))->download('leadList_'.uniqid().'.pdf');
    }

    public function find(int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->leadService->find($id), Response::HTTP_OK);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->leadService->update($id, $request->all()), Response::HTTP_OK);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            return new JsonResponse($this->leadService->save($request->all()), Response::HTTP_CREATED);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->leadService->delete($id), Response::HTTP_OK);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
