<?php

namespace App\Services\Http\Interfaces;

use Illuminate\Http\Client\ConnectionException;

interface HttpServiceInterface
{
    /**
     * Accepts URL and necessary params to make a get api call and returns the response
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @throws ConnectionException
     */
    public function get(string $url, array $params = [], array $headers = []): string;

    /**
     * Accepts URL and necessary params to make a get api call and returns the response
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return object
     * @throws ConnectionException
     */
    public function post(string $url, array $params = [], array $headers = []): object;
}
