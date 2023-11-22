<?php

namespace App\ATDW\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class ApiCall
{
    protected const BASE_URL = 'https://atlas.atdw-online.com.au/api/atlas';
    private string $apiKey;

    public function __construct(protected string $path, ?string $overrideApiKey = null)
    {
        $this->apiKey = $overrideApiKey ?? config('params.ATDW_API_KEY');
    }

    public function getGetUrl(array $query = []): string
    {
        $queryString = http_build_query(['key' => $this->apiKey, ...$query]);
        return static::BASE_URL . '/' . ltrim("$this->path?$queryString", '/');
    }

    /**
     * @throws GuzzleException
     */
    public function get(array $query = [], array $options = []): Response
    {
        $client = new Client();
        $url = $this->getGetUrl($query);
        return $client->get($url, $options);
    }
}
