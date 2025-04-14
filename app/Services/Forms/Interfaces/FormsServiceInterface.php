<?php

namespace App\Services\Forms\Interfaces;

use App\Models\Form1KT;
use App\Models\FormMT1;
use Illuminate\Pagination\LengthAwarePaginator;

interface FormsServiceInterface
{
    /**
     * Accepts data for creating MT1 form, and returns the form after creating it.
     *
     * @param array $data
     * @return FormMT1
     */
    public function createMT1Form(array $data): FormMT1;

    /**
     * Gets the organization id for the MT1 forms that need to be returned.
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getMT1Forms(array $data): LengthAwarePaginator;


    /**
     * Gets the organization id for the 1KT forms that need to be returned.
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function get1KTForms(array $data): LengthAwarePaginator;

    /**
     * Create 1KT form from the data sent as array and return the model of it.
     * @param array $data
     * @return Form1KT
     */
    public function create1KTForm(array $data): Form1KT;
}
