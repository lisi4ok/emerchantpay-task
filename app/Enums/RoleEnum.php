<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum RoleEnum: int
{
    use ArrayableEnumeration;

    case USER = 1;
    case MERCHANT = 2;
    case ADMINISTRATOR = 3;
}
