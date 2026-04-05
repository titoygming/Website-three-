<?php

namespace App\Models;

use App\Enums\RechargeRequestStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RechargeRequest extends Model
{
    /** @use HasFactory<\Database\Factories\RechargeRequestFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'number',
        'amount',
        'sender_name',
        'screenshot_path',
        'transcode',
        'approved_by',
        'approved_at',
        'status',
        'payment_method',
        'payment_method_id',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'status' => RechargeRequestStatus::class,
        ];
    }

    public function markAsApproved(): void
    {
        $this->update([
            'status' => RechargeRequestStatus::Approved->value,
            'approved_by' => user()->id,
            'approved_at' => now(),
        ]);
    }

    public function markAsRejected(): void
    {
        $this->update([
            'status' => RechargeRequestStatus::Rejected->value,
        ]);
    }

    public function markAsDone(): void
    {
        $this->update([
            'status' => RechargeRequestStatus::Done->value,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'approved_by');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
