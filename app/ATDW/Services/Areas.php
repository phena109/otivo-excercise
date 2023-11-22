<?php

namespace App\ATDW\Services;

use App\ATDW\Models\Area;
use App\ATDW\State;
use GuzzleHttp\Exception\GuzzleException;

class Areas extends \ArrayObject
{
    protected State $state;
    protected const API_PATH = '/areas';

    public function offsetGet(mixed $key): Area
    {
        return parent::offsetGet($key);
    }

    /**
     * @throws GuzzleException
     */
    public function pull(?State $state = null, array $options = []): void
    {
        $query = [];
        if (!is_null($state)) {
            $query['st'] = $state;
        }
        $apiCall = new ApiCall(static::API_PATH);
        $apiCall->get($query, $options);
    }
}
