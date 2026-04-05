<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentMethodFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'number',
        'holder_name',
        'provider',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class
        ];
    }

    public function requests(): HasMany
    {
        return $this->hasMany(RechargeRequest::class);
    }
}
