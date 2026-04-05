<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasUlids;


    protected $fillable = [
        'name',
        'email',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class
        ];
    }


    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function active(): bool
    {
        return $this->status == UserStatus::ACTIVE;
    }

    public function banned(): bool
    {
        return $this->status == UserStatus::BANNED;
    }

    public function markAsActive(): void
    {
        $this->update(['status' => UserStatus::ACTIVE]);
    }

    public function markAsInactive(): void
    {
        $this->update(['status' => UserStatus::INACTIVE]);
    }

    public function markAsBanned(): void
    {
        $this->update(['status' => UserStatus::BANNED]);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function rechargeRequests(): HasMany
    {
        return $this->hasMany(RechargeRequest::class);
    }
}
