<?php

namespace App\Repositories\Forms;

use App\Enums\Forms\TypesEnum;
use App\Models\Currencies;
use App\Models\FormMT1;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Pagination\LengthAwarePaginator;

class FormMT1Repository extends BaseRepository
{
    public $model = FormMT1::class;

    public function getFormsByOrganization(int $organization_id, string $date): LengthAwarePaginator
    {
        return $this->model::where('organization_id', $organization_id)
            ->whereDate('date_time', $date)
            ->with(['organization'])->paginate(15);
    }

    public function createRandomMT1Form(array $data): bool
    {
        $fromDate = Carbon::parse($data['date_from']);
        $toDate = Carbon::parse($data['date_to']);
        $remaining = $data['exchange_total'];

        $period = CarbonPeriod::create($fromDate, $toDate);
        $datePlans = collect($period)->mapWithKeys(fn($d) => [$d->format('Y-m-d') => rand(5, 20)])->toArray();
        $data['currency_id'] = Currencies::query()->where('currency', $data['currency_type'])->where('organization_id', $data['organization_id'])->first()->id;

        while ($remaining > 0) {
            foreach ($datePlans as $date => $maxEntries) {
                $currentTime = Carbon::parse($date)->setTime(9, 0); // Start of working hours
                for ($i = 0; $i < $maxEntries && $remaining > 0; $i++) {
                    $rate = $data['rate'];
                    $maxAllowedByRate = floor(30000 / $rate);
                    // Also respect the remaining budget and global max-per-entry limit
                    $entryMax = min(2000, $maxAllowedByRate, $remaining);

                    if ($currentTime->hour == 9 || $currentTime->hour >= 18) {
                        $currentTime->addMinutes(rand(25, 50));
                    } else {
                        $currentTime->addMinutes(rand(5, 20));
                    }

                    if ($currentTime->hour >= 22) {
                        break;
                    }
                    // Avoid trying to generate with max 0
                    if ($entryMax <= 0) {
                        break;
                    }

                    $amount = rand(1, $entryMax);

                    $this->model::query()->create([
                        'user_id' => $data['user_id'],
                        'organization_id' => $data['organization_id'],
                        'authorized_bank' => $data['authorized_bank'],
                        'date_time' => $currentTime->copy(), // Use $currentTime->copy() to prevent Carbon reference mutation
                        'type' => $data['type'],
                        'currency_id' => $data['currency_id'],
                        'currency_type' => $data['currency_type'],
                        'exchange_amount' => $amount,
                        'rate' => $rate,
                        'value' => round($amount * $rate, 2),
                        'residency' => $data['residency'],
                        'authorized_person' => $data['authorized_person'],
                    ]);

                    $remaining -= $amount;
                }

                if ($remaining <= 0) break;
            }
        }
        return true;
    }

}
