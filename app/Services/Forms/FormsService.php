<?php

namespace App\Services\Forms;

use App\Models\Form1KT;
use App\Models\FormMT1;
use App\Repositories\Forms\Form1KTRepository;
use App\Repositories\Forms\FormMT1Repository;
use App\Repositories\User\UserRepository;
use App\Services\Forms\Interfaces\FormsServiceInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class FormsService implements FormsServiceInterface
{
    public function __construct(
        protected FormMT1Repository $mt1_repository,
        protected Form1KTRepository $kt1_repository,
        protected UserRepository $user_repository
    ) {}
    public function createMT1Form(array $data): FormMT1
    {
        $user = $this->user_repository->getAuthenticatedUser();
        $data['user_id'] = $user->id;
        $data['value'] = $data['rate'] * $data['exchange_amount'];

        return $this->mt1_repository->create($data);
    }

    public function getMT1Forms(array $data): LengthAwarePaginator
    {
        return $this->mt1_repository->getFormsByOrganization($data['id'], $data['date']);
    }

    public function updateMT1Form(array $data): FormMT1
    {
        $mt1 = $this->mt1_repository->findById($data['id']);
        if (isset($data['custom_id'])) {
            $exists = $this->mt1_repository
                ->findBy('custom_id', $data['custom_id'])
                ->whereYear('date_time',  Carbon::createFromDate($mt1->date_time)->year)
                ->exists();
            if ($exists) abort(403, 'errors.forms.custom_id.exists');
            $kt1 = $this->kt1_repository
                ->findBy('document_no', $mt1->custom_id)
                ->whereYear('date_time', Carbon::createFromDate($mt1->date_time)->year)
                ->first();

            $kt1->document_no = $data['custom_id'];

            $kt1->save();
        }
        $mt1->fill($data);
        $mt1->save();

        return $mt1->fresh();
    }
    public function get1KTForms(array $data): LengthAwarePaginator
    {
        return $this->kt1_repository->getFormsByOrganization($data['id'], $data['date']);
    }

    public function create1KTForm(array $data): Form1KT
    {
        $user = $this->user_repository->getAuthenticatedUser();
        $data['user_id'] = $user->id;

        return $this->kt1_repository->create($data);
    }

}
