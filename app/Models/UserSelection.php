<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\MarkTypeEnum;

class UserSelection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pokemon',
        'type_id',
    ];

    public function scopeAuthenticatedUser($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function scopeWhereFavorite($query)
    {
        return $query->where('type_id', MarkTypeEnum::FAVORITE->value);
    }

    public function scopeWhereLiked($query)
    {
        return $query->where('type_id', MarkTypeEnum::LIKED->value);
    }

    public function scopeWhereHated($query)
    {
        return $query->where('type_id', MarkTypeEnum::HATED->value);
    }
}
