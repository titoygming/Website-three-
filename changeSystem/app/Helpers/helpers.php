<?php

use App\Models\Manager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



if (!function_exists('user')) {

    /**
     * Get the currently authenticated user or null if not authenticated.
     * @return User|null
     */
    function user(): User | Manager | null
    {
        return Auth::user();
    }
}

if (!function_exists('storage_url')) {
    /**
     * Get the URL to a file in the storage directory.
     *
     * @param string $path The path to the file relative to the storage directory.
     * @return string The full URL to the file.
     */
    function storage_url(string $path): string
    {
        return asset('storage/' . $path);
    }
}
