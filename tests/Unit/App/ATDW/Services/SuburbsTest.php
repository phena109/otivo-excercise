<?php

namespace Tests\Unit\App\ATDW\Services;

use App\ATDW\Services\Suburbs;
use Tests\TestCase;

class SuburbsTest extends TestCase
{
    public function testGet(): void
    {
        $this->markTestSkipped('Manually enable if needed');
        $suburbsService = new Suburbs();
        $areas = $suburbsService->get(null, [], true);
        static::assertIsArray($areas);
        static::assertGreaterThan(0, count($areas));
    }
}
