<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum UserStatusEnum: int
{
    use ArrayableEnumeration;

    case INACTIVE = 0;
    case ACTIVE = 1;
}
