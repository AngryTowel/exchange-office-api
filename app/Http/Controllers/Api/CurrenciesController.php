<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currencies\GetCurrenciesRequest;
use App\Http\Requests\Currencies\GetCurrencyValueHistoryRequest;
use App\Http\Requests\Currencies\UpdateCurrenciesRequest;
use App\Http\Resources\Currency\CurrenciesResource;
use App\Http\Resources\Currency\CurrencyValueHistoryResource;
use App\Services\Organization\Interfaces\CurrencyServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    public function __construct(
        protected CurrencyServiceInterface $currency_service
    ) {}
    public function index(GetCurrenciesRequest $request): JsonResponse
    {
        return $this->respond(CurrenciesResource::collection($this->currency_service->getAllCurrencies($request->get('org_id'))));
    }
    public function update(UpdateCurrenciesRequest $request): JsonResponse
    {
        return $this->respond(CurrenciesResource::collection($this->currency_service->updateCurrencies($request->validated())));
    }

    public function getHistory(GetCurrencyValueHistoryRequest $request): JsonResponse
    {
        return $this->respond(CurrencyValueHistoryResource::collection($this->currency_service->getHistories($request->validated()))->response()->getData());
    }
}
