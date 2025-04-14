<?php

namespace App\Repositories\Forms;

use App\Models\FormMT1;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class FormMT1Repository extends BaseRepository
{
    public $model = FormMT1::class;

    public function getFormsByOrganization(int $organization_id, string $date): LengthAwarePaginator
    {
        return $this->model::where('organization_id', $organization_id)
            ->whereDate('date_time', $date)
            ->with('organization')->paginate(15);
    }

}
