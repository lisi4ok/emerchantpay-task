<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum RoleEnum: int
{
    use ArrayableEnumeration;

    case USER = 0;
    case MERCHANT = 1;
    case ADMINISTRATOR = 2;
}
