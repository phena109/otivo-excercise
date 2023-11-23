<?php

namespace App\ATDW;

enum SearchBy: string
{
    case Region = 'rg';
    case Area = 'ar';
    case CityOrSuburb = 'ct';

    public function toString(): string {
        return $this->value;
    }
}
