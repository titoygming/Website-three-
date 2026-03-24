<?php

use App\Livewire\Dashboard;
use App\Livewire\Manager\Dashboard as ManagerDashboard;
use App\Livewire\Manager\Login;
use App\Livewire\Manager\Orders as ManagerOrders;
use App\Livewire\Manager\Services as ManagerServices;
use App\Livewire\Manager\Transactions as ManagerTransactions;
use App\Livewire\Manager\Users as ManagerUsers;
use App\Livewire\MyDevices;
use App\Livewire\Orders;
use App\Livewire\Transactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/devices', MyDevices::class)->name('devices');
    Route::get('/orders', Orders::class)->name('orders');
    Route::get('/transactions', Transactions::class)->name('transactions');
});

require __DIR__ . '/settings.php';

Route::prefix('/manager')
    ->name('manager.')
    ->group(function () {
        Route::middleware(['auth:manager'])->group(function () {
            Route::get('/dashboard', ManagerDashboard::class)->name('dashboard');
            Route::get('/orders', ManagerOrders::class)->name('orders');
            Route::get('/users', ManagerUsers::class)->name('users');
            Route::get('/transactions', ManagerTransactions::class)->name('transactions');
            Route::get('/services', ManagerServices::class)->name('services');


            Route::post('/logout', function () {
                Auth::guard('manager')->logout();
                Session::regenerateToken();
                Session::invalidate();
                redirect()->route('manager.login');
            })->name('logout');
        });

        Route::middleware(['guest:manager'])->group(function () {
            Route::get('/login', Login::class)->name('login');
        });
    });
