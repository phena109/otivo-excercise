<?php

namespace App\ATDW;

enum SearchBy
{
    case Region;
    case Area;
    case CityOrSuburb;

    /**
     * For calling ATDW api
     */
    public const ATDW_QS = [
        self::Region->name => 'rg',
        self::Area->name => 'ar',
        self::CityOrSuburb->name => 'ct',
    ];

    /**
     * For APIs we exposed
     */
    public const API_QS = [
        'region' => self::Region,
        'area' => self::Area,
        'city' => self::CityOrSuburb,
        'suburb' => self::CityOrSuburb,
    ];

    public function toAtdwQs(): string {
        return self::ATDW_QS[$this->name];
    }
}
