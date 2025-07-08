<?php

namespace App\Services\Forms;

use App\Models\Form1KT;
use App\Models\FormMT1;
use App\Repositories\Forms\Form1KTRepository;
use App\Repositories\Forms\FormMT1Repository;
use App\Repositories\Organization\CurrenciesRepository;
use App\Repositories\User\UserRepository;
use App\Services\Forms\Interfaces\FormsServiceInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Pagination\LengthAwarePaginator;

class FormsService implements FormsServiceInterface
{
    public function __construct(
        protected FormMT1Repository $mt1_repository,
        protected Form1KTRepository $kt1_repository,
        protected UserRepository $user_repository,
        protected CurrenciesRepository $currency_repository
    ) {}
    public function createMT1Form(array $data): FormMT1
    {
        $user = $this->user_repository->getAuthenticatedUser();
        $data['user_id'] = $user->id;
        $data['value'] = $data['rate'] * $data['exchange_amount'];
        $data['currency_id'] = $this->currency_repository->findByType($data['currency_type'], $data['organization_id'])->id;

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
                ->where('id', '!=', $mt1->id)
                ->whereYear('date_time',  Carbon::createFromDate($mt1->date_time)->year)
                ->exists();
            if ($exists) abort(403, 'errors.forms.custom_id.exists');
        }

        $mt1->fill($data);

        if (isset($data['exchange_amount']) || isset($data['rate'])) {
            $data['value'] = $mt1->rate * $mt1->exchange_amount;
            $mt1->fill($data);
        }
        if (isset($data['currency_type'])) {
            $data['currency_type'] = $this->currency_repository->findByType($data['type'], $mt1->organization_id)->id;
            $mt1->fill($data);
        }
        $mt1->save();

        return $mt1->fresh();
    }
    public function deleteMT1Form(array $data): bool
    {
        $mt1 = $this->mt1_repository->findById($data['id']);

        return $mt1->delete();
    }
    public function randomizeMT1(array $data): bool
    {
        $data['user_id'] = $this->user_repository->getAuthenticatedUser()->id;
        return $this->mt1_repository->createRandomMT1Form($data);
    }

    public function get1KTForms(array $data): LengthAwarePaginator
    {
        return $this->kt1_repository->getFormsByOrganization($data['id'], $data['date']);
    }

    public function create1KTForm(array $data): Form1KT
    {
        $user = $this->user_repository->getAuthenticatedUser();
        $data['user_id'] = $user->id;
        $data['currency_id'] = $this->currency_repository->findByType($data['currency_type'], $data['organization_id'])->id;

        return $this->kt1_repository->create($data);
    }
    public function update1KTForm(array $data): Form1KT
    {
        return $this->kt1_repository->update($data['id'], $data);
    }

    public function delete1KTForm(array $data): bool
    {
        $kt1 = $this->kt1_repository->findById($data['id']);
        if ($kt1->formMT1()->exists()) abort('403', 'errors.forms.kt1.mt_exists');

        return $kt1->delete();
    }
}
