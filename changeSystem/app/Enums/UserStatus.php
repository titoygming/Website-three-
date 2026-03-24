<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BANNED = 'banned';

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'green',
            self::INACTIVE => 'yellow',
            self::BANNED => 'red',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn(self $status) => $status->value, self::cases());
    }
}
