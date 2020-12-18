<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\InstallmentsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();

Route::middleware('auth')->group(function() {
  Route::get('/', [HomeController::class, 'index'])->name('home');

  Route::name('clients.')->group(function() {
  	Route::get('/clientes', [ClientsController::class, 'index'])->name('index');
    Route::post('/clientes', [ClientsController::class, 'store'])->name('store');
    Route::get('/clientes/{client}', [ClientsController::class, 'show'])->name('show');
    Route::patch('/clientes/{client}', [ClientsController::class, 'patch'])->name('patch');
    Route::get('/clientes/{client}/get-client', [ClientsController::class, 'getClient']);
    Route::get('/clientes/{client}/get-client-details-view', [ClientsController::class, 'getClientDetailsView'])->name('show.details');
    Route::delete('/clientes/{client}/delete', [ClientsController::class, 'destroy'])->name('delete');
  });

  Route::name('orders.')->group(function() {
    Route::get('/pedidos', [OrdersController::class, 'index'])->name('index');
    Route::get('/clientes/{client}/pedidos/novo', [OrdersController::class, 'create'])->name('create');
    Route::post('/clientes/{client}/pedidos/novo', [OrdersController::class, 'store'])->name('store');
    route::get('/clientes/{client}/pedidos/{order}', [OrdersController::class, 'show'])->name('show');
    Route::get('/clientes/{client}/pedidos/{order}/get-order', [OrdersController::class, 'getOrder']);
    Route::get('/clientes/{client}/pedidos/{order}/alterar-dados', [OrdersController::class, 'edit'])->name('edit');
    Route::patch('/clientes/{client}/pedidos/{order}/alterar-dados', [OrdersController::class, 'patch']);
    Route::get('/clientes/{client}/pedidos/{order}/get-order-details-view', [OrdersController::class, 'getOrderDetailsView'])->name('show.details');
    Route::get('/clientes/{client}/get-orders-card', [OrdersController::class, 'getOrdersCardView'])->name('show.card');
    Route::delete('/clientes/{client}/pedidos/{order}/delete', [OrdersController::class, 'destroy'])->name('delete');
  });

  Route::name('payments.')->group(function() {
    Route::post('/clientes/{client}/pedidos/{order}/parcela/{installment}/pagar', [InstallmentsController::class, 'pay']);
    Route::post('/clientes/{client}/pedidos/{order}/pagar', [PaymentsController::class, 'store']);
  });
});

// Rotas de autenticação
Route::name('auth.')->group(function() {
  Route::middleware('guest')->group(function() {
    Route::get('/entrar', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('/entrar', [LoginController::class, 'login'])->name('login');
  });

  Route::middleware('auth')->group(function() {
    Route::get('/sair', [LoginController::class, 'logout'])->name('logout');
  });
});

