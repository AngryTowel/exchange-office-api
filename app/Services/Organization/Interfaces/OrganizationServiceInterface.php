<?php

namespace App\Services\Organization\Interfaces;

use App\Models\Organization;

interface OrganizationServiceInterface
{
    /**
     * Call the online service that provides the currencies and initialize them per organization.
     *
     * @param int $org_id
     * @return mixed
     */
    public function retrieveCurrenciesRates(int $org_id): bool;
    public function setCurrencies(array $currencies): mixed;

    /**
     * Accepts data in the form of the update organization request and updates organization data.
     *
     * @param array $data
     * @return Organization
     */
    public function updateOrganization(array $data): Organization;
}
