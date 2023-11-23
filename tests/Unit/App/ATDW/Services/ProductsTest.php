<?php

namespace Tests\Unit\App\ATDW\Services;

use App\ATDW\SearchBy;
use App\ATDW\Services\Products;
use Tests\TestCase;

class ProductsTest extends TestCase
{

    /**
     * @covers Products::getByAreaAndOrSuburb
     */
    public function testGetByAreaAndOrSuburb(): void
    {
        $this->markTestSkipped('Manually enable if needed');
        $areasService = new Products();
        ['data' => $products] = $areasService->getByAreaAndOrSuburb(
            area: 'Bathurst',
            size: 100,
            forceRefresh: true,
        );
        static::assertIsArray($products);
        static::assertGreaterThan(0, count($products));
    }

    /**
     * @covers Products::getByRegion
     */
    public function testGetByRegion(): void
    {
        $this->markTestSkipped('Manually enable if needed');
        $areasService = new Products();
        ['data' => $products] = $areasService->getByRegion('Greater Sydney', forceRefresh: true);
        static::assertIsArray($products);
        static::assertGreaterThan(0, count($products));
    }

    /**
     * @covers Products::getAllAreasSuburbsByRegion
     */
    public function testGetAllAreasSuburbsByRegion(): void
    {
        $this->markTestSkipped('Manually enable if needed');
        $areasService = new Products();
        $array = $areasService->getAllAreasSuburbsByRegion('Greater Sydney', forceRefresh: true);
        static::assertIsArray($array); // @todo write meaningful assertion
    }

    /**
     * @covers Products::getProducts
     */
    public function testGetProducts(): void
    {
        $this->markTestSkipped('Manually enable if needed');
        $areasService = new Products();
        ['data' => $products] = $areasService->getProducts(SearchBy::Region, 'Greater Sydney', forceRefresh: true);
        static::assertIsArray($products);
        static::assertGreaterThan(0, count($products));
    }
}
