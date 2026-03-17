<?php

namespace App\Services;

use App\Models\Device;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Throwable;

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
}
