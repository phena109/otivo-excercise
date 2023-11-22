<?php

namespace App\ATDW\Models;

class Product
{
    protected string $productName;
    protected string $productShortDescription;

    /**
     * @todo limit to images only now and will update as requirements get clearer
     * @var array|string[]
     */
    protected array $product_multimedia;
}
