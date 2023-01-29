<?php

namespace App\Enums;

use App\Traits\BaseEnumTrait;

enum MarkTypeEnum : int
{
    use BaseEnumTrait;

    case FAVORITED = 1;
    case LIKED = 2;
    case HATED = 3;
}
