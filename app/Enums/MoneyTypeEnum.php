<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum MoneyTypeEnum: int
{
    use ArrayableEnumeration;

    case ORDER = 0;
    case CARD = 1;
    case BANK = 2;
    case CASH = 3;
}
