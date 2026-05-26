<?php

namespace App\Models;

use App\Enums\ServiceType;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, HasUlids;

    protected $fillable = ['name', 'type', 'price', 'description', 'image_url', 'image'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ServiceType::class,
        ];
    }

    /**
     * Scope to filter only repair services.
     */
    public function scopeRepair(Builder $query): Builder
    {
        return $query->where('type', ServiceType::Repair);
    }

    /**
     * Scope to filter only gift card services.
     */
    public function scopeGiftcard(Builder $query): Builder
    {
        return $query->where('type', ServiceType::Giftcard);
    }

    /**
     * Get the full URL for the service image.
     */
    public function getImageFullUrlAttribute(): ?string
    {
        if ($this->image_url) {
            /** @var FilesystemAdapter $disk */
            $disk = Storage::disk('public');

            return $disk->url($this->image_url);
        }

        return null;
    }
}
