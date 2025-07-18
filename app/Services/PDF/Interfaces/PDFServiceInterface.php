<?php

namespace App\Services\PDF\Interfaces;

use Illuminate\Http\Response;

interface PDFServiceInterface
{
    /**
     * Accepts an array of data in the format of GetHistoryPDF request and returns a pdf of all the histories that have
     * input or output in the requested date.
     * @param array $data
     * @return Response
     */
    public function getHistoryPDF(array $data): Response;

    /**
     * Gets the id of the MT1 form and generates a pdf report of it.
     * @param int $id
     * @return Response
     */
    public function getMT1PDF(int $id): Response;

    /**
     * Gets the date of the 1KT forms and generates a pdf report of all of them.
     * @param array $data
     * @return Response
     */
    public function get1KTPDF(array $data): Response;
    /**
     * Gets a date range and generate IMR1 form for that period.
     * @param array $data
     * @return Response
     */
    public function getIMR1PDF(array $data): Response;

}
