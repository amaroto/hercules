<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Services\CompanyService;

use PDF;

use Exception;

final class CompanyController extends Controller
{
    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(Request $request): JsonResponse
    {
        return new JsonResponse (
            $this->companyService->index((int) $request->page, (int) $request->items, $request->query()),
            Response::HTTP_OK
        );
    }

    public function exportPdf(Request $request)
    {
        $leads = $this->companyService->index((int) $request->page, (int) $request->items, $request->query(), false);
        return (PDF::loadView('pdf/pdf_company_view', ['data' => $leads->items()]))->download('companyList_'.uniqid().'.pdf');
    }

    public function find(int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->companyService->find($id), Response::HTTP_OK);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->companyService->update($id, $request->all()), Response::HTTP_NO_CONTENT);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            return new JsonResponse($this->companyService->save($request->all()), Response::HTTP_CREATED);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            return new JsonResponse($this->companyService->delete($id), Response::HTTP_OK);
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
