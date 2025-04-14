<?php

namespace App\Services\Http;

use App\Services\Http\Interfaces\HttpServiceInterface;
use Illuminate\Support\Facades\Http;

class HttpService implements HttpServiceInterface
{
    public function get(string $url, array $params = [], array $headers = []): string
    {
        return Http::when(count($headers), function ($response) use ($headers) {
            $response->withHeaders($headers);
        })->get($url, $params)->body();
    }
    public function post(string $url, array $params = [], array $headers = []): object
    {
        return Http::when(count($headers), function ($response) use ($headers) {
            $response->withHeaders($headers);
        })->post($url, $params);
    }
}
