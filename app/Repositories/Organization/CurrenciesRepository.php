<?php

namespace App\Repositories\Organization;

use App\Models\Currencies;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepository;

class CurrenciesRepository extends BaseRepository
{
    public $model = Currencies::class;

    public function __construct(
        protected UserRepository $user_repository
    ) {}

    public function findByType(string $type, int $org_id): Currencies
    {
        return $this->model::query()->where('currency', $type)->where('organization_id', $org_id)->first();
    }

    public function getAllCurrencies(int $org_id)
    {
        return $this->model::where('organization_id', $org_id)
            ->orderBy('isDefault', 'desc')
            ->orderBy('order')
            ->with('value')
            ->get();
    }
    /**
     * @param  $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data): mixed
    {
        $item = $this->findById($id);
        if ($item->valueHistories()->exists() && isset($data['current_value']))
        {
            unset($data['current_value']);
        } else if (isset($data['current_value']))
        {
            // Used only to add initial value to the currency, can be moved to a service or class as it is used in two places (organization repo).
            $item->valueHistories()->create([
                'organization_id' => $item->organization_id,
                'initial_value' => $data['current_value'],
                'input' => 0,
                'output' => 0,
                'value' => $data['current_value'],
                'created_at' => null, // Intentional setup to have it as the first ever entry if the user decides to put past dates in the forms.
            ]);
        }

        $item->fill($data);
        $item->save();

        return $item->fresh()->load('value');
    }

    public function getMainCurrency(int $org_id): Currencies
    {
        return $this->model::query()
            ->where('organization_id', $org_id)
            ->where('isDefault', true)
            ->first();
    }
}
