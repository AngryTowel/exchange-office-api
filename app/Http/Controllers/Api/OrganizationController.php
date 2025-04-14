<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\UpdateRequest;
use App\Http\Resources\Organization\OrganizationResource;
use App\Services\Organization\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $organization_service
    ) {}
    public function update(UpdateRequest $request): JsonResponse
    {
        return $this->respond(new OrganizationResource($this->organization_service->updateOrganization($request->validated())));
    }
}
