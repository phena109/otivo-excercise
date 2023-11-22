<?php

namespace Tests\Unit\App\ATDW\Services;

use App\ATDW\Services\Areas;
use Tests\TestCase;

class AreasTest extends TestCase
{

    public function testGet()
    {
        $this->markTestSkipped('Manually enable if needed');
        $areasService = new Areas();
        $areas = $areasService->get(null, [], true);
        static::assertIsArray($areas);
        static::assertGreaterThan(0, count($areas));
    }
}
