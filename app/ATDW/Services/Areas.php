<?php

namespace App\ATDW\Services;

use App\ATDW\Models\Area;
use App\ATDW\State;
use App\ATDW\Utf16LeParser;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class Areas extends \ArrayObject
{
    protected State $state;
    protected const API_PATH = '/areas';

    public function __construct()
    {
        parent::__construct();
    }

    public function offsetGet(mixed $key): Area
    {
        return parent::offsetGet($key);
    }

    /**
     * @throws GuzzleException
     */
    protected function callApi(?State $state = null, array $options = []): \GuzzleHttp\Psr7\Response
    {
        $query = ['out' => 'json'];
        if (!is_null($state)) {
            $query['st'] = $state;
        }
        return (new ApiCall(static::API_PATH))->get($query, $options);
    }

    /**
     * @param State|null $state
     * @param array $options
     * @param bool $forceRefresh
     * @return Area[]|array
     */
    public function get(?State $state = null, array $options = [], bool $forceRefresh = false): array
    {
        try {

            $key = static::class . $state?->toString() ?? '' . json_encode($options, JSON_THROW_ON_ERROR);
            if ($forceRefresh) {
                Cache::forget($key);
            }
            return Cache::remember($key, 86400, function () use ($state, $options) {
                $result = $this->callApi($state, $options);
                $body = new Utf16LeParser($result->getBody());
                $array = $body->getArray();
                $output = [];
                foreach ($array as $item) {
                    $output[] = Area::fromArray($item);
                }
                return $output;
            });
        } catch (\JsonException) {
        }
        return [];
    }
}
