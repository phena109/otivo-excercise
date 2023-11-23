<?php

namespace App\ATDW\Models;

use Illuminate\Contracts\Support\Arrayable;

class Area implements Arrayable
{
    protected const NAME_MAP = [
        'AreaId' => 'areaId',
        'Code' => 'code',
        'Name' => 'name',
        'Type' => 'type',
        'DomesticRegionId' => 'domesticRegionId',
        'StateId' => 'stateId',
        'StateCode' => 'stateCode',
    ];
    protected string $areaId;
    protected string $code;
    protected string $name;
    protected string $type;
    protected string $domesticRegionId;
    protected string $stateId;
    protected string $stateCode;


    public static function fromArray(array $data): static
    {
        $properties = array_intersect_key($data, static::NAME_MAP);
        $output = new static();
        foreach ($properties as $property => $value) {
            $propertyName = static::NAME_MAP[$property];
            if (property_exists(static::class, $propertyName)) {
                $output->{$propertyName} = $value ?? '';
            }
        }
        return $output;
    }

    public function toArray(): array
    {
        return [
            'areaId' => $this->areaId,
            'code' => $this->code,
            'name' => $this->name,
            'type' => $this->type,
            'domesticRegionId' => $this->domesticRegionId,
            'stateId' => $this->stateId,
            'stateCode' => $this->stateCode,
        ];
    }

    public function getAreaId(): int
    {
        return $this->areaId;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDomesticRegionId(): int
    {
        return $this->domesticRegionId;
    }

    public function getStateId(): int
    {
        return $this->stateId;
    }

    public function getStateCode(): string
    {
        return $this->stateCode;
    }
}
