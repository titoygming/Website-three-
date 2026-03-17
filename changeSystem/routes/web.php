<?php

use App\Livewire\Dashboard;
use App\Livewire\MyDevices;
use App\Livewire\Orders;
use App\Livewire\Transactions;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/devices', MyDevices::class)->name('devices');
    Route::get('/orders', Orders::class)->name('orders');
    Route::get('/transactions', Transactions::class)->name('transactions');
});

require __DIR__ . '/settings.php';
