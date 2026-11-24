<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/membership/apply', [MembershipApplicationController::class, 'create'])->name('membership.create');
Route::post('/membership/apply', [MembershipApplicationController::class, 'store'])->name('membership.store');
Route::get('/weather', [WeatherController::class, 'show'])->name('weather.show');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth')->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->middleware('auth')->name('categories.store');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->middleware('auth')->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware('auth')->name('categories.destroy');
Route::get('/levels', [LevelController::class, 'index'])->middleware('auth')->name('levels.index');
Route::post('/levels', [LevelController::class, 'store'])->middleware('auth')->name('levels.store');
Route::put('/levels/{level}', [LevelController::class, 'update'])->middleware('auth')->name('levels.update');
Route::delete('/levels/{level}', [LevelController::class, 'destroy'])->middleware('auth')->name('levels.destroy');

Route::get('/about', [PageController::class, 'about']);
Route::get('/tasks/{id}', [PageController::class, 'task']);

Route::get('/tasks', [TaskController::class, 'index'])
    ->name('tasks.index');

Route::post('/tasks', [TaskController::class, 'store'])
    ->name('tasks.store');

Route::resource('members', MemberController::class)->middleware('auth');
Route::delete('/members/{member}/delete', [MemberController::class, 'deleteMember'])->middleware('auth')
    ->name('members.delete');

Route::get('/transactions', [TransactionController::class, 'index'])->middleware('auth')->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->middleware('auth')->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->middleware('auth')->name('transactions.store');
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->middleware('auth')->name('transactions.show');
Route::get('/transactions/{transaction}/receipt', [TransactionController::class, 'receipt'])->middleware('auth')->name('transactions.receipt');
Route::get('/members/{member}/transactions', [TransactionController::class, 'memberHistory'])->middleware('auth')->name('members.transactions');
Route::patch('/transactions/{transaction}/paid', [TransactionController::class, 'markPaid'])->middleware('auth')->name('transactions.paid');
Route::post('/transactions/{transaction}/payments', [PaymentController::class, 'store'])->middleware('auth')->name('payments.store');
Route::patch('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->middleware('auth')->name('transactions.approve');
Route::patch('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->middleware('auth')->name('transactions.cancel');

