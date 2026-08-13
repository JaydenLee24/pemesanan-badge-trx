<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/pesan', [OrderController::class, 'index'])->name('order.index');
Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');