<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\Create1KTRequest;
use App\Http\Requests\Forms\CreateMT1Request;
use App\Http\Requests\Forms\Delete1KTRequest;
use App\Http\Requests\Forms\DeleteMT1Request;
use App\Http\Requests\Forms\GetFormsRequest;
use App\Http\Requests\Forms\PdfKT1Request;
use App\Http\Requests\Forms\PdfMT1Request;
use App\Http\Requests\Forms\RandomizeMT1Request;
use App\Http\Requests\Forms\UpdateMT1Request;
use App\Http\Resources\Forms\KT1Resource;
use App\Http\Resources\Forms\MT1Resource;
use App\Services\Forms\Interfaces\FormsServiceInterface;
use App\Services\PDF\Interfaces\PDFServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormsController extends Controller
{
    public function __construct(protected FormsServiceInterface $forms_service, protected PDFServiceInterface $pdf_service) {}

    public function indexMT1(GetFormsRequest $request): JsonResponse
    {
        return $this->respond(MT1Resource::collection($this->forms_service->getMT1Forms($request->validated()))->response()->getData());
    }
    public function createMT1(CreateMT1Request $request): JsonResponse
    {
        return $this->respond(new MT1Resource($this->forms_service->createMT1Form($request->validated())));
    }
    public function updateMT1(UpdateMT1Request $request): JsonResponse
    {
        return $this->respond(new MT1Resource($this->forms_service->updateMT1Form($request->validated())));
    }
    public function deleteMT1(DeleteMT1Request $request): JsonResponse
    {
        return $this->respond($this->forms_service->deleteMT1Form($request->validated()));
    }
    public function pdfMT1(PdfMT1Request $request): Response
    {
        return $this->pdf_service->getMT1PDF($request->get('id'));
    }
    public function randomizeMT1(RandomizeMT1Request $request): JsonResponse
    {
        return $this->respond($this->forms_service->randomizeMT1($request->validated()));
    }
    public function index1KT(GetFormsRequest $request): JsonResponse
    {
        return $this->respond(KT1Resource::collection($this->forms_service->get1KTForms($request->validated()))->response()->getData());
    }
    public function create1KT(Create1KTRequest $request): JsonResponse
    {
        return $this->respond(new KT1Resource($this->forms_service->create1KTForm($request->validated())));
    }
    public function delete1KT(Delete1KTRequest $request): JsonResponse
    {
        return $this->respond($this->forms_service->delete1KTForm($request->validated()));
    }
    public function pdfKT1(PdfKT1Request $request): Response
    {
        return $this->pdf_service->get1KTPDF($request->validated());
    }
}
