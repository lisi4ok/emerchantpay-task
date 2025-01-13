<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum RoleEnum: int
{
    use ArrayableEnumeration;

    case GUEST = 0;
    case USER = 1;
    case ADMINISTRATOR = 2;
    case MERCHANT = 3;
}
