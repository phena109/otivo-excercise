<?php

namespace App\ATDW\Models;

use App\ATDW\State;

class Suburb
{
    protected const NAME_MAP = [
        'SuburbId' => 'suburbId',
        'Name' => 'name',
        'PostCode' => 'postCode',
    ];

    protected string $suburbId;
    protected string $name;
    protected string $postCode;
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

    public function asArray(): array
    {
        return [
            'suburbId' => $this->suburbId,
            'name' => $this->name,
            'postCode' => $this->postCode,
            'state' => $this->state->name,
        ];
    }

    public function getSuburbId(): string
    {
        return $this->suburbId;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getPostCode(): string
    {
        return $this->postCode;
    }


    public function getState(): State
    {
        return $this->state;
    }

}
