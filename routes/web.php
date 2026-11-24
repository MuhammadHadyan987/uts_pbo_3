<?php

use App\Http\Controllers\ExampleController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/example')->name('home');

// Route statis /create ditempatkan sebelum route dinamis /{kode}.
Route::get('/example', [ExampleController::class, 'index'])->name('example.index');
Route::get('/example/create', [ExampleController::class, 'create'])->name('example.create');
Route::post('/example', [ExampleController::class, 'store'])->name('example.store');
Route::get('/example/{kode}/edit', [ExampleController::class, 'edit'])->name('example.edit');
Route::match(['put', 'patch'], '/example/{kode}', [ExampleController::class, 'update'])->name('example.update');
Route::delete('/example/{kode}', [ExampleController::class, 'destroy'])->name('example.destroy');
Route::get('/example/{kode}', [ExampleController::class, 'show'])->name('example.show');
