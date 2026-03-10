<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Staff\StaffSearchController;
use App\Http\Controllers\Staff\TransactionController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Role Based Dashboards
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', function () {
                return Inertia::render('Admin/Dashboard');
            })->name('dashboard');

            Route::resource('users', UserController::class);

            Route::get('activity', [ActivityController::class, 'index'])
                ->name('activity.index');
        });

    /*
    |--------------------------------------------------------------------------
    | Staff Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:staff')
        ->prefix('staff')
        ->name('staff.')
        ->group(function () {

            // Route::get('/dashboard', function () {
            //     return Inertia::render('Staff/Dashboard');
            // })->name('dashboard');
            Route::get('/dashboard',
                [\App\Http\Controllers\Staff\DashboardController::class, 'index']
            )->name('dashboard');

            Route::resource('accounts', \App\Http\Controllers\Staff\AccountController::class);
            Route::get('transactions', [TransactionController::class, 'index'])
                ->name('transactions.index');
            Route::get('transactions/create/{account}', [TransactionController::class, 'create'])
                ->name('transactions.create');
            Route::post('transactions', [TransactionController::class, 'store'])
                ->name('transactions.store');
            Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
            Route::get('accounts/{account}/statement',[TransactionController::class, 'statement'])
                ->name('accounts.statement');
            Route::get('/search', [StaffSearchController::class, 'search'])
                ->name('staff.search');
            Route::get('/accounts/{account}/deposit', [TransactionController::class, 'depositForm'])
                ->name('transactions.deposit.form');

            Route::post('/accounts/{account}/deposit', [TransactionController::class, 'deposit'])
                ->name('transactions.deposit');

            Route::get('/accounts/{account}/withdraw', [TransactionController::class, 'withdrawForm'])
                ->name('transactions.withdraw.form');

            Route::post('/accounts/{account}/withdraw', [TransactionController::class, 'withdraw'])
                ->name('transactions.withdraw');
            
        });

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            // Route::get('/dashboard', function () {
            //     return Inertia::render('User/Dashboard');
            // })->name('dashboard');
            Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])
            ->name('dashboard');
            Route::get('/accounts', [\App\Http\Controllers\User\AccountController::class, 'index'])
            ->name('accounts.index');
            Route::get('/transactions', [\App\Http\Controllers\User\TransactionController::class, 'index'])
            ->name('transactions.index');
        });

});


require __DIR__.'/auth.php';
