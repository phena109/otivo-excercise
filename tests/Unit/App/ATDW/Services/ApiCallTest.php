<?php

namespace Unit\App\ATDW\Services;

use App\ATDW\Services\ApiCall;
use App\ATDW\Utf16LeParser;
use GuzzleHttp\Exception\GuzzleException;
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

    public function test_get(): void
    {
        $this->markTestSkipped('Manually enable if needed');
        $apiCall = new ApiCall('areas', '123456789101112');
        try {
            $result = $apiCall->get(['out' => 'json']);
        } catch (GuzzleException $e) {
            static::fail($e->getMessage());
        }
        $body = new Utf16LeParser($result->getBody());
        $array = $body->getArray();
        static::assertNotNull($array);
        static::assertIsArray($array);
        static::assertGreaterThan(0, count($array));
    }
}
