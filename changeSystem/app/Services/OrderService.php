<?php

namespace App\Services;

use Throwable;
use App\Models\Order;
use App\Models\Device;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function handle(Device $device, Service $service): Order | Throwable
    {
        $user = user();
        DB::beginTransaction();
        try {
            $transaction = (new WalletManagementService)->debit($user, (int) $service->price);
            $order = $user->orders()->create([
                'device_id' => $device->id,
                'transaction_id' => $transaction->id,
                'service_id' => $service->id,
                'amount' => $service->price
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $order;
    }

    public function accept(Order $order): void
    {
        try {
            $order->markAsAccepted();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function reject(Order $order): void
    {
        $user = $order->user;

        DB::beginTransaction();
        try {
            (new WalletManagementService)->credit($user, $order->amount);
            $order->markAsRejected();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function done(Order $order): void
    {
        try {
            $order->markAsDone();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function cancel(Order $order): void
    {
        $user = $order->user;
        DB::beginTransaction();
        try {
            (new WalletManagementService)->credit($user, $order->amount);
            $order->markAsCancelled();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
