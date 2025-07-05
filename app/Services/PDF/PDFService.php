<?php

namespace App\Services\PDF;

use App\Repositories\Forms\Form1KTRepository;
use App\Repositories\Forms\FormMT1Repository;
use App\Repositories\Organization\CurrencyValueHistoryRepository;
use App\Repositories\Organization\OrganizationRepository;
use App\Services\PDF\Interfaces\PDFServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PDFService implements PDFServiceInterface
{
    public function __construct(
        protected CurrencyValueHistoryRepository $history_repo,
        protected OrganizationRepository $organization_repo,
        protected FormMT1Repository $form_mt1_repo,
        protected Form1KTRepository $form_1kt_repo,
    ) {}
    public function getHistoryPDF(array $data): Response
    {
        $organization = $this->organization_repo->findById($data['organization_id']);
        $histories = $this->history_repo->getHistoriesOfDate($data['organization_id'], $data['date']);

        if (!count($histories)) abort(404, 'No histories found');

        $pdf = Pdf::loadView('pdfs.forms.form_db1', [
            'organization' => $organization,
            'histories' => $histories,
            'date' => $data['date'],
        ]);

        return $pdf->download($data['date'].'_1db.pdf');
    }

    public function getMT1PDF(int $id): Response
    {
        $form = $this->form_mt1_repo->findBy('id',$id)->with('organization.owner')->first();

        $pdf = Pdf::loadView('pdfs.forms.form_mt1', [
            'form_data' => $form,
        ])
            ->setPaper('A5', 'landscape');
//            ->setPaper([0, 0, 535.24, 304.33]);

        return $pdf->download('mt1_'.$form->custom_id.'_'.$form->date_time.'.pdf');
    }
    public function get1KTPDF(array $data): Response
    {
        $organization = $this->organization_repo->findById($data['organization_id']);
        $forms = $this->form_1kt_repo->model::query()
            ->whereDate('date_time', $data['date_time'])
            ->where('organization_id', $data['organization_id'])
            ->get();

        $pdf = Pdf::loadView('pdfs.forms.form_1kt', [
            'forms' => $forms,
            'organization' => $organization,
            'date' => $data['date_time'],
        ]);

        return $pdf->download('kt1_'.$data['date_time'].'_'.$organization->name.'.pdf');
    }
}
