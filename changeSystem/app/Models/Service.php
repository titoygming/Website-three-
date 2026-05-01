<?php

namespace App\Models;

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
     * Scope to filter only repair services.
     */
    public function scopeRepair(Builder $query): Builder
    {
        return $query->where('type', 'repair');
    }

    /**
     * Scope to filter only gift card services.
     */
    public function scopeGiftcard(Builder $query): Builder
    {
        return $query->where('type', 'giftcard');
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
