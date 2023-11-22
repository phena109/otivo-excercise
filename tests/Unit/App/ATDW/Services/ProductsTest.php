<?php

namespace Tests\Unit\App\ATDW\Services;

use App\ATDW\Services\Products;
use Tests\TestCase;

class ProductsTest extends TestCase
{

    public function testGetByAreaAndOrSuburb()
    {
    }

    public function testGetByRegion()
    {
        $this->markTestSkipped('Manually enable if needed');
        $areasService = new Products();
        ['data' => $products] = $areasService->getByRegion('Greater Sydney', forceRefresh: true);
        static::assertIsArray($products);
        static::assertGreaterThan(0, count($products));
    }

    public function testGetAllAreasSuburbsByRegion()
    {
        $this->markTestSkipped('Manually enable if needed');
        $areasService = new Products();
        $array = $areasService->getAllAreasSuburbsByRegion('Greater Sydney', forceRefresh: true);
        static::assertIsArray($array); // @todo write meaningful assertion
    }
}
