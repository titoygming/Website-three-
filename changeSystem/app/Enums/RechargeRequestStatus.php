<?php

namespace App\Enums;

enum RechargeRequestStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Done => 'Done',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'yellow',
            self::Approved => 'green',
            self::Done => 'green',
            self::Rejected => 'red',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn(self $status) => $status->value, self::cases());
    }
}
