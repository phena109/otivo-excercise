<?php

namespace App\ATDW\Models;

use App\ATDW\State;

class Region
{
    protected const NAME_MAP = [
        'RegionId' => 'regionId',
        'Code' => 'code',
        'Name' => 'name',
        'Type' => 'type',
    ];

    protected string $regionId;
    protected string $code;
    protected string $name;
    protected string $type;
    protected State $state;

    public static function fromStateAndArray(State $state, array $data): static
    {
        $properties = array_intersect_key($data, static::NAME_MAP);
        $output = new static();
        $output->state = $state;
        foreach ($properties as $property => $value) {
            $propertyName = static::NAME_MAP[$property];
            if (property_exists(static::class, $propertyName)) {
                $output->{$propertyName} = $value ?? '';
            }
        }
        return $output;
    }

    public function getRegionId(): string
    {
        return $this->regionId;
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

    public function getState(): State
    {
        return $this->state;
    }
}
