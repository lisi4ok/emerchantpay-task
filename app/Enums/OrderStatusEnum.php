<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum OrderStatusEnum: int
{
    use ArrayableEnumeration;

    case PENDING_PAYMENT = 0;
    case COMPLETED = 1;
    case CANCELLED = 2;
    case REFUNDED = 3;
}
