<?php

namespace App\ATDW\Services;

use App\ATDW\Models\Area;
use App\ATDW\Models\Product;
use App\ATDW\Models\Region;
use App\ATDW\Models\Suburb;
use App\ATDW\SearchBy;
use App\ATDW\Utf16LeParser;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;

class Products extends \ArrayObject
{
    protected const API_PATH = '/products';
    protected const ERROR_RESULT = ['page' => 1, 'size' => 10, 'total' => 0, 'data' => []];

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
        $query['out'] ??= 'json';
        return (new ApiCall(static::API_PATH))->get($query, $options);
    }

    /**
     * Get the products by the given region
     * @return array{total: int, page: int, size: int, data: Product[]}
     */
    public function getByRegion(
        Region|string $region,
        int $page = 1,
        int $size = 10,
        array $options = [],
        bool $forceRefresh = false,
        array $query = ['dsc' => false],
    ): array {
        try {
            $key = implode('|', [
                static::class,
                __FUNCTION__,
                match (true) {
                    $region instanceof Region => $region->getRegionId(),
                    is_string($region) => $region
                },
                $page,
                $size,
                json_encode($options, JSON_THROW_ON_ERROR)
            ]);
        } catch (\JsonException) {
            return static::ERROR_RESULT;
        }
        if ($forceRefresh) {
            Cache::forget($key);
        }
        return Cache::remember($key, 86400, function () use ($region, $page, $size, $options, $query) {
            $rgParam = match (true) {
                $region instanceof Region => $region->getRegionId(),
                is_string($region) => $region,
                default => null,
            };
            if ($rgParam !== null) {
                $query['rg'] = $rgParam;
            }
            $query['pge'] = $page;
            $query['size'] = $size;
            return $this->buildOutput($this->callApi($query, $options), $page, $size);
        });
    }

    /**
     * A niche function.
     * Pull in area to city map data based on the given region. This will serve as the base of the frontend filter.
     * @param Region|string $region
     * @param array $options
     * @param bool $forceRefresh
     * @param array $query
     * @return array
     * @see getAllAreasSuburbsByRegionProcess
     */
    public function getAllAreasSuburbsByRegion(
        Region|string $region,
        array $options = [],
        bool $forceRefresh = false,
        array $query = ['dsc' => false],
    ): array {
        try {
            $key = implode('|', [
                static::class,
                __FUNCTION__,
                match (true) {
                    $region instanceof Region => $region->getRegionId(),
                    is_string($region) => $region
                },
                json_encode($options, JSON_THROW_ON_ERROR)
            ]);
        } catch (\JsonException) {
            return [];
        }
        if ($forceRefresh) {
            Cache::forget($key);
        }
        return Cache::remember(
            $key,
            86400,
            fn() => $this->getAllAreasSuburbsByRegionProcess($region, $options, $forceRefresh, $query)
        );
    }

    /**
     * Doing the actual processing for {@see getAllAreasSuburbsByRegion}.
     */
    public function getAllAreasSuburbsByRegionProcess(
        Region|string $region,
        array $options,
        bool $forceRefresh,
        array $query,
    ): array {
        $output = [];
        $page = 0;
        $size = 250;
        do {
            $page++;
            [
                'data' => $partialData,
                'total' => $total,
            ] = $this->getByRegion($region, $page, $size, $options, $forceRefresh, $query);
            foreach ($partialData as $product) {
                foreach ($product->getAddresses() as $address) {
                    $output[$address->getArea()] ??= [];
                    $output[$address->getArea()][] = $address->getCity();
                }
            }
        } while ($page * $size < $total);
        foreach ($output as $areaName => $cities) {
            $output[$areaName] = array_intersect_key($cities, array_unique(array_map('strtolower', $cities)));
            usort($output[$areaName], static fn($a, $b) => strcasecmp($a, $b));
        }
        return $output;
    }

    /**
     * @return array{total: int, page: int, size: int, data: Product[]}
     */
    public function getByAreaAndOrSuburb(
        Area|string|null $area = null,
        Suburb|string|null $suburb = null,
        int $page = 1,
        int $size = 10,
        array $options = [],
        bool $forceRefresh = false,
        array $query = ['dsc' => false],
    ): array {
        try {
            $key = implode('|', [
                static::class,
                __FUNCTION__,
                match (true) {
                    $area instanceof Area => $area->getAreaId(),
                    is_string($area) => $area,
                    default => '',
                },
                match (true) {
                    $suburb instanceof Suburb => $suburb->getSuburbId(),
                    is_string($suburb) => $suburb,
                    default => '',
                },
                $page,
                $size,
                json_encode($options, JSON_THROW_ON_ERROR)
            ]);
        } catch (\JsonException) {
            return static::ERROR_RESULT;
        }
        if ($forceRefresh) {
            Cache::forget($key);
        }
        return Cache::remember($key, 86400, function () use ($area, $suburb, $page, $size, $options, $query) {
            $arParam = match (true) {
                $area instanceof Area => $area->getAreaId(),
                is_string($area) => $area,
                default => null,
            };
            if ($arParam !== null) {
                $query['ar'] = $arParam;
            }
            $ctParam = match (true) {
                $suburb instanceof Suburb => $suburb->getSuburbId(),
                is_string($suburb) => $suburb,
                default => null,
            };
            if ($ctParam !== null) {
                $query['ct'] = $ctParam;
            }
            $query['pge'] = $page;
            $query['size'] = $size;
            return $this->buildOutput($this->callApi($query, $options), $page, $size);
        });
    }

    /**
     * @return array{total: int, page: int, size: int, data: Product[]}
     */
    protected function buildOutput(Response $result, int $page, int $size): array
    {
        $output = ['page' => $page, 'size' => $size];
        $body = new Utf16LeParser($result->getBody());
        $resultBody = $body->getArray();
        $output['total'] = $resultBody['numberOfResults'] ?? 0;
        $output['data'] = [];
        foreach ($resultBody['products'] as $product) {
            $output['data'][] = Product::fromArray($product);
        }
        return $output;
    }

    public function getProducts(
        SearchBy $by,
        Region|Area|Suburb|string $value,
        int $page = 1,
        int $size = 10,
        array $options = [],
        bool $forceRefresh = false,
        array $query = ['dsc' => false],
    )
    {
        try {
            $key = implode('|', [
                static::class,
                __FUNCTION__,
                $by->toString(),
                match (true) {
                    $value instanceof Region => $value->getRegionId(),
                    $value instanceof Area => $value->getAreaId(),
                    $value instanceof Suburb => $value->getSuburbId(),
                    is_string($value) => $value
                },
                $page,
                $size,
                json_encode($options, JSON_THROW_ON_ERROR)
            ]);
        } catch (\JsonException) {
            return static::ERROR_RESULT;
        }
        if ($forceRefresh) {
            Cache::forget($key);
        }
        return Cache::remember($key, 86400, function () use ($by, $value, $page, $size, $options, $query) {
            $param = match (true) {
                $value instanceof Region => $value->getRegionId(),
                $value instanceof Area => $value->getAreaId(),
                $value instanceof Suburb => $value->getSuburbId(),
                is_string($value) => $value,
                default => null,
            };
            if ($param !== null) {
                $query[$by->toString()] = $param;
            }
            $query['pge'] = $page;
            $query['size'] = $size;
            return $this->buildOutput($this->callApi($query, $options), $page, $size);
        });
    }
}
