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
