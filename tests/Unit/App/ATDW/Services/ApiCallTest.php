<?php

namespace Unit\App\ATDW\Services;

use App\ATDW\Services\ApiCall;
use PHPUnit\Framework\TestCase;

class ApiCallTest extends TestCase
{
    public function test__construct()
    {
        $apiCall = new ApiCall('foo', 'bar');
        $reflectionClass = new \ReflectionClass(ApiCall::class);
        $apiKey = $reflectionClass->getProperty('apiKey');
        $path = $reflectionClass->getProperty('path');
        static::assertEquals('foo', $path->getValue($apiCall));
        static::assertEquals('bar', $apiKey->getValue($apiCall));
    }
}
