<?php

namespace App\ATDW\Models;

class Address
{
    protected string $area;
    protected string $city;

    /**
     * @return array|Address[]
     */
    public static function fromArray(array $data): array
    {
        $addresses = [];
        foreach ($data as $datum) {
            $areas = is_array($datum['area']) ? $datum['area'] : [$datum['area']];
            foreach ($areas as $area) {
                $address = new static();
                $address->area = $area;
                $address->city = $datum['city'];
                $addresses[] = $address;
            }
        }
        return $addresses;
    }

    public function getArea(): string
    {
        return $this->area;
    }

    public function getCity(): string
    {
        return $this->city;
    }
}
