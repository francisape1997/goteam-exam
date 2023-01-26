<?php

namespace App\Enums;

use App\Traits\BaseEnumTrait;

enum MarkTypeEnum : int
{
    use BaseEnumTrait;

    case FAVORITE = 1;
    case LIKED = 2;
    case HATED = 3;
}
