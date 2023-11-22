<?php

namespace App\ATDW\Services;

use App\ATDW\Models\Area;
use App\ATDW\Models\Product;
use App\ATDW\Models\Region;
use App\ATDW\Models\Suburb;
use GuzzleHttp\Exception\GuzzleException;

class Products
{
    protected const API_PATH = '/products';

    public function __construct()
    {
        parent::__construct();
    }

    public function offsetGet(mixed $key): Product
    {
        return parent::offsetGet($key);
    }

    /**
     * @throws GuzzleException
     */
    protected function callApi(array $query, array $options = []): \GuzzleHttp\Psr7\Response
    {
        if (!isset($query['out'])) {
            $query['out'] = 'json';
        }
        return (new ApiCall(static::API_PATH))->get($query, $options);
    }

    public function getByRegion(Region $region, array $options = [], bool $forceRefresh = false): array
    {
    }

    public function getByAreaAndOrSuburb(
        ?Area $area = null,
        ?Suburb $suburb = null,
        array $options = [],
        bool $forceRefresh = false
    ): array {
    }
}
