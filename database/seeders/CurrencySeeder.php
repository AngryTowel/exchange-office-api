<?php

namespace Database\Seeders;

use App\Services\Organization\Interfaces\OrganizationServiceInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function __construct(protected OrganizationServiceInterface $organizationService) {

    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->organizationService->retrieveCurrenciesRates(1);
        $this->organizationService->retrieveCurrenciesRates(2);
        $this->organizationService->retrieveCurrenciesRates(3);
    }
}
