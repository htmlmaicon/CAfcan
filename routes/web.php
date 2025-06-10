<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoopControler;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClienteLoginController;
use App\Http\Controllers\ClienteAuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AdminLoginController;

// Página de teste
Route::get('/welcome', function () {
    return view('welcome');
});

// =====================
// Rotas Públicas
// =====================
Route::get('/', [CoopControler::class, 'Home'])->name('home');
Route::get('/finalizar', [CoopControler::class, 'Finalizar'])->name('finalizar');
Route::get('/entrega', [CoopControler::class, 'Entrega'])->name('entrega');
Route::get('/endereco', [CoopControler::class, 'Endereco'])->name('endereco');
 
Route::get('/retirada', [CoopControler::class, 'Retirada'])->middleware('auth:cliente')->name('retirada');

// Carrinho
Route::middleware(['throttle:30,1'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// Checkout e Pedidos
Route::post('/pagamento', [CheckoutController::class, 'finalizarPedido'])->name('pagamento');
Route::post('/checkout/endereco', [CheckoutController::class, 'salvarEnderecoEntrega'])->name('salvar.endereco.entrega');
Route::get('/pedidos', [PedidoController::class, 'index'])->middleware('auth:cliente')->name('pedidos.index');

// Tela de pagamento
Route::get('/pagamento', function () {
    return view('Pagamento.pagamento');
})->name('pagamento.form');

// =====================
// Área Admin (guard: web)
// =====================
Route::prefix('admin/products')->name('products.')->middleware(['auth:web', 'can:isAdmin'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});

// =====================
// Login Cliente (guard: cliente)
// =====================
Route::prefix('cliente')->group(function () {
    Route::get('/login', [ClienteLoginController::class, 'showLoginForm'])->name('cliente.login');
    Route::post('/login', [ClienteLoginController::class, 'login'])->middleware('throttle:10,1')->name('cliente.login.post');
    Route::post('/logout', [ClienteLoginController::class, 'logout'])->name('cliente.logout');
    Route::get('/register', [ClienteAuthController::class, 'showRegister'])->name('cliente.register');
    Route::post('/register', [ClienteAuthController::class, 'register'])->middleware('throttle:5,1')->name('cliente.register.post');
});

// =====================
// Login Admin (guard: web)
// =====================
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
