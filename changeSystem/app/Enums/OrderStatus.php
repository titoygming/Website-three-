<?php

namespace App\Enums;

enum OrderStatus: string
{
    case ACCEPTED = 'Accepted';
    case CANCELED = 'Canceled';
    case PENDING = 'Pending';

    public static function toArray(): array
    {
        return array_map(fn(self $status) => $status->value, self::cases());
    }
}
