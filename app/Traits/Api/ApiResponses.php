<?php

namespace App\Traits\Api;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait ApiResponses
{
    /**
     * @var int
     */
    public int $responseCode = 200;

    /**
     * @var string
     */
    public string $message = 'info.success';


    /**
     * @param  int  $code
     *
     * @return $this
     */
    public function setCode(int $code = 200): static
    {
        $this->responseCode = $code;

        return $this;
    }

    /**
     * @param $message
     *
     * @return $this
     */
    public function setMessage($message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param $data
     *
     * @return JsonResponse
     */
    public function respond($data): JsonResponse
    {
        return response()
            ->json(
                [
                    'message' => $this->message,
                    'code' => $this->responseCode,
                    'data' => $data,
                ],
                $this->responseCode
            );
    }

    public function download($path): BinaryFileResponse
    {
        return response()->download($path);
    }
}
