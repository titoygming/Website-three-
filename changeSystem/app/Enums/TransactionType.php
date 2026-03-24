<?php

namespace App\Enums;

enum TransactionType: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';

    public function color(): string
    {
        return match ($this) {
            self::CREDIT => 'green',
            self::DEBIT => 'red',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
