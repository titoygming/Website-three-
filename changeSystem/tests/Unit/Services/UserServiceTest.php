<?php

use App\Enums\UserStatus;
use App\Models\User;
use App\Services\UserService;

describe('UserService', function () {
    describe('active', function () {
        test('marks user as active', function () {
            $user = User::factory()->create(['status' => UserStatus::INACTIVE->value]);

            $service = new UserService();
            $service->active($user);

            $user->refresh();
            expect($user->status)->toBe(UserStatus::ACTIVE);
        });

        test('persists active status in database', function () {
            $user = User::factory()->create(['status' => UserStatus::INACTIVE->value]);

            $service = new UserService();
            $service->active($user);

            $freshUser = User::find($user->id);
            expect($freshUser->status)->toBe(UserStatus::ACTIVE);
        });

        test('marks banned user as active', function () {
            $user = User::factory()->create(['status' => UserStatus::BANNED->value]);

            $service = new UserService();
            $service->active($user);

            $user->refresh();
            expect($user->status)->toBe(UserStatus::ACTIVE);
        });

        test('idempotent operation', function () {
            $user = User::factory()->create(['status' => UserStatus::ACTIVE->value]);

            $service = new UserService();
            $service->active($user);

            $user->refresh();
            expect($user->status)->toBe(UserStatus::ACTIVE);
        });

        test('returns void', function () {
            $user = User::factory()->create(['status' => UserStatus::INACTIVE->value]);

            $service = new UserService();
            $result = $service->active($user);

            expect($result)->toBeNull();
        });
    });

    describe('incative', function () {
        test('marks user as inactive', function () {
            $user = User::factory()->create(['status' => UserStatus::ACTIVE->value]);

            $service = new UserService();
            $service->incative($user);

            $user->refresh();
            expect($user->status)->toBe(UserStatus::INACTIVE);
        });

        test('persists inactive status in database', function () {
            $user = User::factory()->create(['status' => UserStatus::ACTIVE->value]);

            $service = new UserService();
            $service->incative($user);

            $freshUser = User::find($user->id);
            expect($freshUser->status)->toBe(UserStatus::INACTIVE);
        });

        test('marks banned user as inactive', function () {
            $user = User::factory()->create(['status' => UserStatus::BANNED->value]);

            $service = new UserService();
            $service->incative($user);

            $user->refresh();
            expect($user->status)->toBe(UserStatus::INACTIVE);
        });

        test('idempotent operation', function () {
            $user = User::factory()->create(['status' => UserStatus::INACTIVE->value]);

            $service = new UserService();
            $service->incative($user);

            $user->refresh();
            expect($user->status)->toBe(UserStatus::INACTIVE);
        });

        test('returns void', function () {
            $user = User::factory()->create(['status' => UserStatus::ACTIVE->value]);

            $service = new UserService();
            $result = $service->incative($user);

            expect($result)->toBeNull();
        });
    });

    describe('ban', function () {
        test('marks user as banned', function () {
            $user = User::factory()->create(['status' => UserStatus::ACTIVE->value]);

            $service = new UserService();
            $service->ban($user);

            $user->refresh();
            expect($user->status)->toBe(UserStatus::BANNED);
        });

        test('persists banned status in database', function () {
            $user = User::factory()->create(['status' => UserStatus::ACTIVE->value]);

            $service = new UserService();
            $service->ban($user);

            $freshUser = User::find($user->id);
            expect($freshUser->status)->toBe(UserStatus::BANNED);
        });

        test('can ban inactive user', function () {
            $user = User::factory()->create(['status' => UserStatus::INACTIVE->value]);

            $service = new UserService();
            $service->ban($user);

            $user->refresh();
            expect($user->status)->toBe(UserStatus::BANNED);
        });

        test('idempotent operation', function () {
            $user = User::factory()->create(['status' => UserStatus::BANNED->value]);

            $service = new UserService();
            $service->ban($user);

            $user->refresh();
            expect($user->status)->toBe(UserStatus::BANNED);
        });

        test('returns void', function () {
            $user = User::factory()->create(['status' => UserStatus::ACTIVE->value]);

            $service = new UserService();
            $result = $service->ban($user);

            expect($result)->toBeNull();
        });
    });

    describe('status transitions', function () {
        test('can transition between all statuses', function () {
            $user = User::factory()->create(['status' => UserStatus::ACTIVE->value]);
            $service = new UserService();

            $service->incative($user);
            $user->refresh();
            expect($user->status)->toBe(UserStatus::INACTIVE);

            $service->ban($user);
            $user->refresh();
            expect($user->status)->toBe(UserStatus::BANNED);

            $service->active($user);
            $user->refresh();
            expect($user->status)->toBe(UserStatus::ACTIVE);
        });
    });
});
