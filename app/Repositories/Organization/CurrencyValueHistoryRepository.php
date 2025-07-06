<?php

namespace App\Repositories\Organization;

use App\Enums\Forms\ResidencyEnum;
use App\Enums\Forms\TypesEnum;
use App\Models\Currencies;
use App\Models\CurrencyValueHistory;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
            $prev_history = $this->model::query()
                ->where('currency_id', $currency_id)
                ->whereDate('created_at', '<', Carbon::parse($date)->format('Y-m-d'))
                ->latest()
                ->first();
            if (!isset($prev_history)) {
                $prev_history = $this->model::query()
                    ->where('currency_id', $currency_id)
                    ->whereNull('created_at')
                    ->first();
            }
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

        return $history->load('currency');
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
    public function getByDate(int $currency_id, string $from, string $to = null): Collection
    {
        return $this->model::query()
            ->where('currency_id', $currency_id)
            ->whereDate('created_at', '>', Carbon::parse($from)->format('Y-m-d'))
            ->when($to, function ($query, $to) {
                $query->whereDate('created_at', '<=', Carbon::parse($to)->format('Y-m-d'));
            })->get();
    }
    public function readjustCalculationByHistory(CurrencyValueHistory $history): Collection
    {
        $histories = $this->getByDate($history->currency_id, $history->created_at);
        $initial_value = $history->value;
        foreach ($histories as $h) {
            $h->initial_value = $initial_value;
            $h->value = $h->initial_value + $h->input - $h->output;

            $h->save();

            $initial_value = $h->value;
        }

        return $histories->fresh();
    }
    public function getByCurrency(array $currency_id, string $from_date): Collection
    {
        $histories = new Collection();
        foreach ($currency_id as $id) {
            $history = $this->getHistoryByCurrency($id, $from_date);

            $histories->push($history);
        }

        return $histories;
    }
    public function getHistoriesOfDate(int $organization_id, string $date): Collection
    {
        $ids = $this->currencies_repository->getActiveCurrenciesQuery($organization_id)->pluck('id')->toArray();
        return $this->getByCurrency($ids, $date);
    }
    public function prepareForIMR1(int $organization_id, string $date_from, string $date_to): Collection
    {

        $fromDate = Carbon::parse($date_from);
        $toDate = Carbon::parse($date_to);

        $dates = CarbonPeriod::create($fromDate, $toDate);
        // Foreach is used to ensure value histories are created for these dates even if no transactions happened in between
        foreach ($dates as $date) {
            $this->getHistoriesOfDate($organization_id, $date->format('Y-m-d'));
        }
        return $this->currencies_repository
            ->getActiveCurrenciesQuery($organization_id)
            ->with(['valueHistories' => function ($query) use ($date_from, $date_to) {
                    $query->whereDate('created_at', '>=', $date_from)
                        ->whereDate('created_at', '<=', $date_to)
                    ->orderBy('created_at');
                },
                'kt1Forms' => function ($query) use ($date_from, $date_to) {
                    $query
                        ->whereDate('date_time', '>=', $date_from)
                        ->whereDate('date_time', '<=', $date_to);
            }])
            ->withSum(['kt1Forms as total_input_residents' => function ($query) use ($date_from, $date_to) {
                $query
                    ->whereHas('formMT1', function ($q) {
                        $q->where('residency', ResidencyEnum::resident->value);
                    })
                    ->whereDate('date_time', '>=', $date_from)
                    ->whereDate('date_time', '<=', $date_to);
            }], 'exchange_amount_input')
            ->withSum(['kt1Forms as total_input_non_residents' => function ($query) use ($date_from, $date_to) {
                $query
                    ->whereHas('formMT1', function ($q) {
                        $q->where('residency', ResidencyEnum::non_resident->value);
                    })
                    ->whereDate('date_time', '>=', $date_from)
                    ->whereDate('date_time', '<=', $date_to);
            }], 'exchange_amount_input')
            ->withSum(['kt1Forms as total_output_residents' => function ($query) use ($date_from, $date_to) {
                $query
                    ->whereHas('formMT1', function ($q) {
                        $q->where('residency', ResidencyEnum::resident->value);
                    })
                    ->whereDate('date_time', '>=', $date_from)
                    ->whereDate('date_time', '<=', $date_to);
            }], 'exchange_amount_output')
            ->withSum(['kt1Forms as total_output_non_residents' => function ($query) use ($date_from, $date_to) {
                $query
                    ->whereHas('formMT1', function ($q) {
                        $q->where('residency', ResidencyEnum::non_resident->value);
                    })
                    ->whereDate('date_time', '>=', $date_from)
                    ->whereDate('date_time', '<=', $date_to);
            }], 'exchange_amount_output')
            ->withSum(['kt1Forms as total_output_banks' => function ($query) use ($date_from, $date_to) {
                $query
                    ->where('description', '19') // KT1 for outputing value to the banks
                    ->whereDate('date_time', '>=', $date_from)
                    ->whereDate('date_time', '<=', $date_to);
            }], 'exchange_amount_output')
            ->withSum(['kt1Forms as total_input_amount' => function ($query) use ($date_from, $date_to) {
                $query
                    ->whereDate('date_time', '>=', $date_from)
                    ->whereDate('date_time', '<=', $date_to);
            }], 'value_input')
            ->withSum(['kt1Forms as total_output_amount' => function ($query) use ($date_from, $date_to) {
                $query
                    ->whereDate('date_time', '>=', $date_from)
                    ->whereDate('date_time', '<=', $date_to);
            }], 'value_output')
            ->withAvg(['kt1Forms as average_buy_rate' => function ($query) use ($date_from, $date_to) {
                $query
                    ->where('description', TypesEnum::toKT1(TypesEnum::buying))
                    ->whereDate('date_time', '>=', $date_from)
                    ->whereDate('date_time', '<=', $date_to);
            }], 'rate')
            ->withAvg(['kt1Forms as average_sell_rate' => function ($query) use ($date_from, $date_to) {
                $query
                    ->where('description', TypesEnum::toKT1(TypesEnum::selling))
                    ->whereDate('date_time', '>=', $date_from)
                    ->whereDate('date_time', '<=', $date_to);
            }], 'rate')
            ->get();
    }
}
