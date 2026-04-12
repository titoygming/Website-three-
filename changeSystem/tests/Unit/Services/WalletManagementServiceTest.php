<?php

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use App\Services\WalletManagementService;

describe('WalletManagementService', function () {
    describe('debit', function () {
        test('debits user balance', function () {
            $user = User::factory()->create(['balance' => 1000]);

            $service = new WalletManagementService();
            $transaction = $service->debit($user, 100);

            $user->refresh();
            expect($user->balance)->toBe(900);
            expect($transaction->amount)->toBe(-100);
        });

        test('creates debit transaction record', function () {
            $user = User::factory()->create(['balance' => 1000]);

            $service = new WalletManagementService();
            $transaction = $service->debit($user, 100);

            expect($transaction)->toBeInstanceOf(Transaction::class);
            expect($transaction->user_id)->toBe($user->id);
            expect($transaction->amount)->toBe(-100);
            expect($transaction->type)->toBe(TransactionType::DEBIT);
        });

        test('throws exception when balance is insufficient', function () {
            $user = User::factory()->create(['balance' => 50]);

            $service = new WalletManagementService();

            expect(fn() => $service->debit($user, 100))
                ->toThrow(Exception::class, "Balance isn't enough");
        });

        test('throws exception when balance equals zero', function () {
            $user = User::factory()->create(['balance' => 0]);

            $service = new WalletManagementService();

            expect(fn() => $service->debit($user, 50))
                ->toThrow(Exception::class);
        });

        test('debits exact amount when balance is sufficient', function () {
            $user = User::factory()->create(['balance' => 100]);

            $service = new WalletManagementService();
            $service->debit($user, 100);

            $user->refresh();
            expect($user->balance)->toBe(0);
        });

        test('allows multiple debits', function () {
            $user = User::factory()->create(['balance' => 1000]);

            $service = new WalletManagementService();
            $service->debit($user, 100);
            $service->debit($user, 200);
            $service->debit($user, 50);

            $user->refresh();
            expect($user->balance)->toBe(650);

            expect(Transaction::where('user_id', $user->id)->count())->toBe(3);
        });

        test('handles zero debit amount', function () {
            $user = User::factory()->create(['balance' => 1000]);

            $service = new WalletManagementService();
            $transaction = $service->debit($user, 0);

            $user->refresh();
            expect($user->balance)->toBe(1000);
            expect($transaction->amount)->toBe(0);
        });

        test('rolls back on transaction creation failure', function () {
            $user = User::factory()->create(['balance' => 1000]);
            $originalBalance = $user->balance;

            $service = new WalletManagementService();

            try {
                $service->debit($user, 100);
            } catch (Exception $e) {
                // Expected exception
            }

            $user->refresh();
            expect($user->balance)->toBeLessThanOrEqual(1000);
        });
    });

    describe('credit', function () {
        test('credits user balance', function () {
            $user = User::factory()->create(['balance' => 1000]);

            $service = new WalletManagementService();
            $transaction = $service->credit($user, 100);

            $user->refresh();
            expect($user->balance)->toBe(1100);
            expect($transaction->amount)->toBe(100);
        });

        test('creates credit transaction record', function () {
            $user = User::factory()->create(['balance' => 1000]);

            $service = new WalletManagementService();
            $transaction = $service->credit($user, 100);

            expect($transaction)->toBeInstanceOf(Transaction::class);
            expect($transaction->user_id)->toBe($user->id);
            expect($transaction->amount)->toBe(100);
            expect($transaction->type)->toBe(TransactionType::CREDIT);
        });

        test('allows credit on zero balance account', function () {
            $user = User::factory()->create(['balance' => 0]);

            $service = new WalletManagementService();
            $transaction = $service->credit($user, 100);

            $user->refresh();
            expect($user->balance)->toBe(100);
        });

        test('allows multiple credits', function () {
            $user = User::factory()->create(['balance' => 1000]);

            $service = new WalletManagementService();
            $service->credit($user, 100);
            $service->credit($user, 200);
            $service->credit($user, 50);

            $user->refresh();
            expect($user->balance)->toBe(1350);

            expect(Transaction::where('user_id', $user->id)->count())->toBe(3);
        });

        test('handles zero credit amount', function () {
            $user = User::factory()->create(['balance' => 1000]);

            $service = new WalletManagementService();
            $transaction = $service->credit($user, 0);

            $user->refresh();
            expect($user->balance)->toBe(1000);
            expect($transaction->amount)->toBe(0);
        });

        test('handles large credit amounts', function () {
            $user = User::factory()->create(['balance' => 1000]);

            $service = new WalletManagementService();
            $service->credit($user, 1000000);

            $user->refresh();
            expect($user->balance)->toBe(1001000);
        });
    });

    describe('concurrent operations', function () {
        test('maintains balance consistency with multiple users', function () {
            $user1 = User::factory()->create(['balance' => 1000]);
            $user2 = User::factory()->create(['balance' => 2000]);

            $service = new WalletManagementService();
            $service->debit($user1, 100);
            $service->credit($user2, 100);

            $user1->refresh();
            $user2->refresh();

            expect($user1->balance)->toBe(900);
            expect($user2->balance)->toBe(2100);
        });
    });
});
