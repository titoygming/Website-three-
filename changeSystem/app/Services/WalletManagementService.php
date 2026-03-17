<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class WalletManagementService
{
    public function debit(User $user, int $amount): Transaction | Throwable
    {
        if ($user->balance < $amount) {
            throw new Exception("Balance isn't enough");
        }

        DB::beginTransaction();
        try {
            $transaction = $user->transactions()->create([
                'amount' => -$amount,
                'type' => TransactionType::DEBIT->value
            ]);

            $user->balance = ($user->balance - $amount);
            $user->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception("Unable to debit debit");
        }

        return $transaction;
    }

    public function credit(User $user, int $amount): Transaction | Throwable
    {
        DB::beginTransaction();
        try {
            $transaction = $user->transactions()->create([
                'amount' => $amount,
                'type' => TransactionType::CREDIT->value
            ]);

            $user->balance = ($user->balance + $amount);
            $user->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception("Unable to credit account");
        }

        return $transaction;
    }
}
