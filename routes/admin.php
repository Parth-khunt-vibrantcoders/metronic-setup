<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\dashboard\DashboardController;
use App\Http\Controllers\backend\LoginController;


Route::get('/admin-logout', [LoginController::class, 'logout'])->name('admin-logout');

$adminPrefix = "admin";

Route::group(['prefix' => $adminPrefix, 'middleware' => ['admin']], function() {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});
?>
