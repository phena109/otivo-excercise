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
        $output->setState($state);
        foreach ($properties as $property => $value) {
            $propertyName = static::NAME_MAP[$property];
            if (property_exists(static::class, $propertyName)) {
                $output->{$propertyName} = $value ?? '';
            }
        }
        return $output;
    }

    public function getSuburbId(): string
    {
        return $this->suburbId;
    }

    public function setSuburbId(string $suburbId): void
    {
        $this->suburbId = $suburbId;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function setState(State $state): void
    {
        $this->state = $state;
    }
}
