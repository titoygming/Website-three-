<?php

use App\Models\Manager;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notifications.{userId}', function (User $user, $userId) {
    return (string) $user->id === (string) $userId;
}, ['guards' => ['web']]);

Broadcast::channel('manager.notifications', function (Manager $manager) {
    return $manager instanceof Manager ? true : false;
}, ['guards' => ['manager']]);
