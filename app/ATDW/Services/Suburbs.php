<?php

namespace App\ATDW\Services;

use App\ATDW\Models\Suburb;
use App\ATDW\State;
use App\ATDW\Utf16LeParser;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class Suburbs extends \ArrayObject
{
    protected State $state;
    protected const API_PATH = '/suburbs';

    public function __construct()
    {
        parent::__construct();
    }

    public function offsetGet(mixed $key): Suburb
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
     * @return Suburb[]|array
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
                $foundStates = $body->getArray();
                $output = [];
                foreach ($foundStates as $foundState) {
                    if (isset($foundState['Suburbs'])) {
                        foreach ($foundState['Suburbs'] as $suburb) {
                            $stateConst = constant(State::class . "::{$foundState['StateCode']}");
                            $output[] = Suburb::fromStateAndArray($stateConst, $suburb);
                        }
                    }
                }
                return $output;
            });
        } catch (\JsonException) {
        }
        return [];
    }
}
