<?php

namespace App\Repositories\Forms;

use App\Models\Form1KT;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class Form1KTRepository extends BaseRepository
{
    public $model = Form1KT::class;

    public function getFormsByOrganization(int $organization_id, string $date): LengthAwarePaginator
    {
        return $this->model::where('organization_id', $organization_id)
            ->whereDate('date_time', $date)
            ->with(['organization'])->paginate(15);
    }

}
