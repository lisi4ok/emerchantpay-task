<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum TransactionTypeEnum: int
{
    use ArrayableEnumeration;

    case CREDIT = 0;
    case DEBIT = 1;
}
