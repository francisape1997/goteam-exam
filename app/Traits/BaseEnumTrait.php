<?php

namespace App\Traits;

use ReflectionEnumBackedCase;
use UnitEnum;

trait BaseEnumTrait
{
    /**
     * @param string $value
     * @return UnitEnum
     */
    public static function fromName(string $value): UnitEnum
    {
        $reflection = new ReflectionEnumBackedCase(self::class, $value);
        return $reflection->getValue();
    }

    /**
     * @return array
     */
    public static function toArrayNames(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array
     */
    public static function toArrayValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}