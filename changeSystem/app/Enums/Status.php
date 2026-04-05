<?php

namespace App\Enums;

enum Status: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'green',
            self::INACTIVE => 'red',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn(self $status) => $status->value, self::cases());
    }
}
