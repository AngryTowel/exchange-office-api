<?php

namespace App\Services\Organization\Interfaces;

use App\Models\Form1KT;
use Illuminate\Pagination\LengthAwarePaginator;

interface CurrencyServiceInterface
{
    /**
     * Returns all the currencies for the organization of the authenticated user.
     * @param int $org_id
     * @return mixed
     */
    public function getAllCurrencies(int $org_id): mixed;

    /**
     * Accepts an array of data from the UpdateCurrenciesRequest format and updates the currencies based on that.
     *
     * @param array $data
     * @return mixed
     */
    public function updateCurrencies(array $data): mixed;

    /**
     * Accepts a 1KT form and calculates the condition of the currency for the exchange office.
     *
     * @param Form1KT $form1KT
     * @return mixed
     */
    public function calculateHistoryFrom1KT(Form1KT $form1KT): mixed;

    /**
     * Accepts array of data with filter from, to date and currency id to get the history for that currency.
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getHistories(array $data): LengthAwarePaginator;

    /**
     * Receives the array of ids and orders them in the exact order that the array has been received in.
     * @param array $data
     * @return mixed
     */
    public function updateOrder(array $data): mixed;
}
