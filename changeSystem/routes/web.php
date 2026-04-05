<?php

use App\Livewire\Dashboard;
use App\Livewire\Manager\Dashboard as ManagerDashboard;
use App\Livewire\Manager\Login;
use App\Livewire\Manager\Orders as ManagerOrders;
use App\Livewire\Manager\RechargeRequests as ManagerRechargeRequests;
use App\Livewire\Manager\Services as ManagerServices;
use App\Livewire\Manager\Services\Create as ManagerCreate;
use App\Livewire\Manager\Services\Edit as ManagerEdit;
use App\Livewire\Manager\Transactions as ManagerTransactions;
use App\Livewire\Manager\Users as ManagerUsers;
use App\Livewire\MyDevices;
use App\Livewire\Orders;
use App\Livewire\RechargeForm;
use App\Livewire\RechargeGuide;
use App\Livewire\RechargeRequests;
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
    Route::get('/recharge', RechargeForm::class)->name('recharge');
    Route::get('/recharge-requests', RechargeRequests::class)->name('recharge-requests');
    Route::get('recharge-guide', RechargeGuide::class)->name('recharge-guide');
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
            Route::get('/services', ManagerServices::class)->name('services.home');
            Route::get('/services/create', ManagerCreate::class)->name('services.create');
            Route::get('/services/{service}/edit', ManagerEdit::class)->name('services.edit');
            Route::get('/recharge-requests', ManagerRechargeRequests::class)->name('recharge-requests');


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
