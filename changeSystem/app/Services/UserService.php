<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function create(): void
    {
        return;
    }
    public function active(User $user): void
    {
        try {
            $user->markAsActive();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function incative(User $user): void
    {
        try {
            $user->markAsInactive();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function ban(User $user): void
    {
        try {
            $user->markAsBanned();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
