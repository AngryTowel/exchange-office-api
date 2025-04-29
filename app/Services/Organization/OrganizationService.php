<?php

namespace App\Services\Organization;

use App\Models\Organization;
use App\Repositories\Organization\CurrenciesRepository;
use App\Repositories\Organization\OrganizationRepository;
use App\Services\Http\Interfaces\HttpServiceInterface;
use App\Services\Organization\Interfaces\OrganizationServiceInterface;

class OrganizationService implements OrganizationServiceInterface
{
    public function __construct(
        protected HttpServiceInterface $http_service,
        protected CurrenciesRepository $currencies_repository,
        protected OrganizationRepository $organization_repository
    ) {}
    public function retrieveCurrenciesRates(int $org_id): bool
    {
        // retrieve the currencies from the online service.
        $params = [
            'StartDate' => date('d.m.Y'),
            'EndDate' => date('d.m.Y'),
            'format' => 'json'
        ];

        $res = $this->http_service->get('https://www.nbrm.mk/KLServiceNOV/GetExchangeRate', $params);

        $this->setCurrencies([
            'code' => 807,
            'name' => json_encode(['mk' => 'Денар', 'en' => 'Denar', 'al' => 'Denar']),
            'currency' => 'MKD',
            'country' => json_encode(['mk' => 'Северна Македонија', 'en' => 'North Macedonia', 'al' => 'Maqedonia']),
            'buying_rate' => 1,
            'selling_rate' => 1,
            'isDefault' => true,
            'organization_id' => $org_id
        ]);

        $this->setCurrencies(collect(json_decode($res))->where('drzavaAng', '!=', 'Israel')->map(function ($item) use ($org_id) {
            return [
                'code' => $item->valuta,
                'name' => json_encode(['mk' => $item->nazivMak, 'en' => $item->nazivAng, 'al' => $item->nazivAl]),
                'currency' => $item->oznaka,
                'country' => json_encode(['mk' => $item->drzava, 'en' => $item->drzavaAng, 'al' => $item->drzavaAl]),
                'buying_rate' => $item->sreden,
                'selling_rate' => $item->sreden,
                'organization_id' => $org_id
            ];
        })->toArray());

        return true;
    }


    public function setCurrencies(array $currencies): mixed
    {
        return $this->currencies_repository->insert($currencies);
    }

    public function updateOrganization(array $data): Organization
    {
        return $this->organization_repository->update($data['organization_id'], $data)->load('owner', 'mainCurrency.value');
    }
}
