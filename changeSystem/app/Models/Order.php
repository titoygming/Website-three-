<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'device_id',
        'service_id',
        'transaction_id',
        'status',
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class
        ];
    }

    public function markAsAccepted(): void
    {
        $this->update(['status' => OrderStatus::ACCEPTED->value]);
    }

    public function markAsDone(): void
    {
        $this->update(['status' => OrderStatus::DONE->value]);
    }

    public function markAsRejected(): void
    {
        $this->update(['status' => OrderStatus::REJECTED->value]);
    }

    public function markAsCancelled(): void
    {
        $this->update(['status' => OrderStatus::CANCELED->value]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
