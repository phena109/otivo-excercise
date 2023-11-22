<?php

namespace App\ATDW;

enum State: string
{
    case ACT = 'ACT';
    case NSW = 'NSW';
    case NT = 'NT';
    case TAS = 'TAS';
    case SA = 'SA';
    case QLD = 'QLD';
    case WA = 'WA';
    case VIC = 'VIC';

    public function toString(): string {
        return $this->value;
    }
}
