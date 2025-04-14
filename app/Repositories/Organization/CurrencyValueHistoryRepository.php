<?php

namespace App\Repositories\Organization;

use App\Models\Currencies;
use App\Models\CurrencyValueHistory;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CurrencyValueHistoryRepository extends BaseRepository
{
    public $model = CurrencyValueHistory::class;

    public function __construct(
        protected CurrenciesRepository $currencies_repository
    ) {}


    public function getHistoryByCurrency(int $currency_id, string $date): CurrencyValueHistory
    {
        $history = $this->model::query()
            ->where('currency_id', $currency_id)
            ->whereDate('created_at', Carbon::parse($date)->format('Y-m-d'))
            ->first();
        if (!isset($history)) {
            /** @var Currencies $currency */
            $currency = $this->currencies_repository->findById($currency_id);
            $prev_history = $currency->valueHistories()
                ->whereDate('created_at', '<', Carbon::parse($date)->format('Y-m-d'))
                ->latest()
                ->first();
            $history = $this->model::query()
                ->create([
                    'currency_id' => $currency_id,
                    'organization_id' => $currency->organization_id,
                    'initial_value' => $prev_history->value,
                    'input' => 0,
                    'output' => 0,
                    'value' => $prev_history->value,
                    'created_at' => Carbon::parse($date)->format('Y-m-d'). '00:00:00'
                ]);
        }

        return $history;
    }

    public function updateHistoryCalculation(CurrencyValueHistory $history, int $input, int $output): CurrencyValueHistory
    {
        $history->input += $input;
        $history->output += $output;
        $history->value = $history->initial_value + $history->input - $history->output;

        $history->save();

        $this->readjustCalculationByHistory($history);

        return $history;
    }

    public function getByDate(string $from, string $to = null): Collection
    {
        return $this->model::query()
            ->whereDate('created_at', '>=', Carbon::parse($from)->format('Y-m-d'))
            ->when($to, function ($query, $to) {
                $query->whereDate('created_at', '<=', Carbon::parse($to)->format('Y-m-d'));
            })->get();
    }
    public function readjustCalculationByHistory(CurrencyValueHistory $history): Collection
    {
        $histories = $this->getByDate($history->created_at);
        $initial_value = $history->value;
        foreach ($histories as $h) {
            $h->initial_value = $initial_value;
            $h->value = $h->initial_value + $h->input - $h->output;

            $h->save();

            $initial_value = $h->value;
        }

        return $histories->fresh();
    }
    public function getByCurrency(int $currency_id, string $from_date, string $to_date): LengthAwarePaginator
    {
        return $this->model::query()
            ->whereDate('created_at', '>=', Carbon::parse($from_date)->format('Y-m-d'))
            ->whereDate('created_at', '<=', Carbon::parse($to_date)->format('Y-m-d'))
            ->where('currency_id', $currency_id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }
}
