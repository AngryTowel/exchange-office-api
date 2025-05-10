<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\Create1KTRequest;
use App\Http\Requests\Forms\CreateMT1Request;
use App\Http\Requests\Forms\GetFormsRequest;
use App\Http\Requests\Forms\UpdateMT1Request;
use App\Http\Resources\Forms\KT1Resource;
use App\Http\Resources\Forms\MT1Resource;
use App\Services\Forms\Interfaces\FormsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function __construct(protected FormsServiceInterface $forms_service) {}

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
    public function index1KT(GetFormsRequest $request): JsonResponse
    {
        return $this->respond(KT1Resource::collection($this->forms_service->get1KTForms($request->validated()))->response()->getData());
    }

    public function create1KT(Create1KTRequest $request): JsonResponse
    {
        return $this->respond(new KT1Resource($this->forms_service->create1KTForm($request->validated())));
    }
}
