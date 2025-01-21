<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum TransactionTypeEnum: int
{
    use ArrayableEnumeration;

    case DEBIT = 0;
    case CREDIT = 1;
}
