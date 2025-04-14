<?php

namespace App\Repositories\Organization;

use App\Models\Organization;
use App\Repositories\BaseRepository;

class OrganizationRepository extends BaseRepository
{
    public $model = Organization::class;

    /**
     * @param  $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data): mixed
    {
        $item = $this->findById($id);
        if ($item->mainCurrency->valueHistories()->exists() && isset($data['current_value'])){
            unset($data['current_value']);
        }
        else if (isset($data['current_value'])){
            // Used only to add initial value to the main currency, can be moved to a service or class as it is used in two places (currencies repo).
            $item->mainCurrency->valueHistories()->create([
                'organization_id' => $item->id,
                'initial_value' => $data['current_value'],
                'input' => 0,
                'output' => 0,
                'value' => $data['current_value'],
                'created_at' => '1970-01-01 00:00:01', // Intentional setup to have it as the first ever entry if the user decides to put past dates in the forms.
            ]);
        }

        $item->fill($data);
        $item->save();

        return $item->fresh();
    }
}
