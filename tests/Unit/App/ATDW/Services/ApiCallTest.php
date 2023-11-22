<?php

namespace Unit\App\ATDW\Services;

use App\ATDW\Services\ApiCall;
use PHPUnit\Framework\TestCase;

class ApiCallTest extends TestCase
{
    /**
     * @covers \App\ATDW\Services\ApiCall
     */
    public function test__construct(): void
    {
        $apiCall = new ApiCall('foo', 'bar');
        $reflectionClass = new \ReflectionClass(ApiCall::class);
        $apiKey = $reflectionClass->getProperty('apiKey');
        $path = $reflectionClass->getProperty('path');
        static::assertEquals('foo', $path->getValue($apiCall));
        static::assertEquals('bar', $apiKey->getValue($apiCall));
    }

    /**
     * @covers \App\ATDW\Services\ApiCall::getGetUrl
     */
    public function test_getGetUrl(): void
    {
        $apiCall = new ApiCall('foo', 'bar');
        $url = $apiCall->getGetUrl(['foobar' => '2023']);
        static::assertSame('https://atlas.atdw-online.com.au/api/atlas/foo?key=bar&foobar=2023', $url);
    }
}
