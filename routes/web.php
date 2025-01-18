<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SuporteController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Rotas Vendedor
Route::resource('vendedores', VendedorController::class)
    ->parameters(['vendedores' => 'vendedor']);


//Rotas Tickets
Route::resource('tickets', TicketController::class);


// Rotas para Suporte (gestão de suportes)
Route::resource('suporte', SuporteController::class);

require __DIR__.'/auth.php';
