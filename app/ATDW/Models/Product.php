<?php

namespace App\ATDW\Models;

use Illuminate\Contracts\Support\Arrayable;

class Product implements Arrayable
{
    protected string $productName;
    protected string $productImage;

    /**
     * @var array|Address[]
     */
    protected array $addresses;

    public static function fromArray(array $data): static
    {
        $product = new static();
        $product->productName = $data['productName'] ?? '';
        $product->productImage = $data['productImage'] ?? '';
        $product->addresses = Address::fromArray($data['addresses']) ?? [];
        return $product;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductImage(): string
    {
        return $this->productImage;
    }

    /**
     * @return array|Address[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function toArray(): array
    {
        return [
            'productName' => $this->productName,
            'productImage' => $this->productImage,
            'addresses' => $this->addresses,
        ];
    }
}
