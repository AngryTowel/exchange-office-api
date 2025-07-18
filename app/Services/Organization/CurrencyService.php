<?php

namespace App\Services\Organization;

use App\Models\CurrencyValueHistory;
use App\Models\Form1KT;
use App\Repositories\Organization\CurrenciesRepository;
use App\Repositories\Organization\CurrencyValueHistoryRepository;
use App\Services\Organization\Interfaces\CurrencyServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CurrencyService implements CurrencyServiceInterface
{
    public function __construct(
        protected CurrenciesRepository $currencies_repository,
        protected CurrencyValueHistoryRepository $currency_value_history_repository,
    ){}
    public function getAllCurrencies(int $org_id): mixed
    {
        return $this->currencies_repository->getAllCurrencies($org_id);
    }

    public function updateCurrencies(array $data): mixed
    {
        $currencies = [];
        foreach ($data as $currency) {
            $currencies[] = $this->currencies_repository->update($currency['id'], $currency);
        }

        return $currencies;
    }

    public function calculateHistoryFrom1KT(Form1KT $form1KT, bool $reverse = false): mixed
    {
        $currency = $this->currencies_repository->findByType($form1KT->currency_type, $form1KT->organization_id);
        $main_currency = $this->currencies_repository->getMainCurrency($form1KT->organization_id);
        // Get history of the currency based on the date from the 1KT form and the main currency.
        $history = $this->currency_value_history_repository->getHistoryByCurrency($currency->id, $form1KT->date_time);
        $main_history = $this->currency_value_history_repository->getHistoryByCurrency($main_currency->id, $form1KT->date_time);
        // Calculate the updated values of the currencies.
        // If reversing is needed in the events of updated values in some of the 1kt forms send negative values to perform the logic
        $history = $this->currency_value_history_repository
            ->updateHistoryCalculation($history, $reverse ? -($form1KT->exchange_amount_input) : $form1KT->exchange_amount_input, $reverse ? -($form1KT->exchange_amount_output) : $form1KT->exchange_amount_output);
        $main_history = $this->currency_value_history_repository
            ->updateHistoryCalculation($main_history, $reverse ? -($form1KT->value_input) : $form1KT->value_input, $reverse ? -($form1KT->value_output) : $form1KT->value_output);

        return [$history, $main_history];
    }

    public function getHistories(array $data): Collection
    {
        if (isset($data['id']) && count($data['id'])) {
            return $this->currency_value_history_repository->getByCurrency($data['id'], $data['from_date']);
        } else {
            return $this->currency_value_history_repository->getHistoriesOfDate($data['organization_id'], $data['from_date']);
        }
    }

    public function updateOrder(array $data): mixed
    {
        foreach ($data['currencies'] as $index => $currency) {
            $this->currencies_repository->update($currency, ['order' => $index]);
        }

        return $this->currencies_repository->getAllCurrencies($data['organization_id']);
    }
}
