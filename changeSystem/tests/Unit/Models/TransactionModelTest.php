<?php

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;

test('transaction belongs to user', function () {
    $user = User::factory()->create();
    $transaction = Transaction::factory()->for($user)->create();

    expect($transaction->user)->toBeInstanceOf(User::class);
    expect($transaction->user->id)->toBe($user->id);
});

test('transaction stores amount', function () {
    $amount = 100;
    $transaction = Transaction::factory()->create(['amount' => $amount]);

    expect($transaction->amount)->toBe($amount);
});

test('transaction stores negative amount for debit', function () {
    $transaction = Transaction::factory()->create(['amount' => -50]);

    expect($transaction->amount)->toBe(-50);
});

test('transaction type is cast to enum', function () {
    $transaction = Transaction::factory()->create(['type' => TransactionType::DEBIT->value]);

    expect($transaction->type)->toBe(TransactionType::DEBIT);
});

test('transaction type can be credit', function () {
    $transaction = Transaction::factory()->create(['type' => TransactionType::CREDIT->value]);

    expect($transaction->type)->toBe(TransactionType::CREDIT);
});

test('transaction uses ulid for id', function () {
    $transaction = Transaction::factory()->create();

    expect($transaction->id)->toBeTruthy();
    expect(strlen($transaction->id))->toBe(26);
});

test('transaction has timestamps', function () {
    $transaction = Transaction::factory()->create();

    expect($transaction->created_at)->not->toBeNull();
    expect($transaction->updated_at)->not->toBeNull();
});

test('multiple transactions can exist for single user', function () {
    $user = User::factory()->create();

    Transaction::factory()->count(5)->for($user)->create();

    expect(Transaction::where('user_id', $user->id)->count())->toBe(5);
});
