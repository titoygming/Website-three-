<?php

namespace App\Enums;

enum OrderStatus: string
{
    case ACCEPTED = 'Accepted';
    case CANCELED = 'Canceled';
    case PENDING = 'Pending';
    case REJECTED = 'Rejected';
    case DONE = 'Done';

    public function color(): string
    {
        return match ($this) {
            self::ACCEPTED => 'emerald',
            self::CANCELED => 'red',
            self::REJECTED => 'red',
            self::PENDING => 'yellow',
            self::DONE => 'green',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn(self $status) => $status->value, self::cases());
    }
}
