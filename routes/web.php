<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FakturController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ServiceDeskController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── Authentication (Guest only) ────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ── All Protected Routes (Auth required) ───────────────────────────────
Route::middleware('auth')->group(function () {

    // ── Service Desk (POS - Outbound) ──────────────────────────────────
    Route::get('/', [ServiceDeskController::class, 'index'])->name('service-desk');
    Route::post('/service-desk', [ServiceDeskController::class, 'store'])->name('service-desk.store');
    Route::get('/cetak-struk/{id}', [ServiceDeskController::class, 'cetakStruk'])->name('cetak-struk');

    // ── Inventory (Master Barang) ──────────────────────────────────────
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    // ── Customers ──────────────────────────────────────────────────────
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // ── Staff (Petugas) ────────────────────────────────────────────────
    Route::get('/staff', [StaffController::class, 'index'])->name('staff');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

    // ── Suppliers ──────────────────────────────────────────────────────
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // ── Inbound PO (Faktur - Inbound) ─────────────────────────────────
    Route::get('/inbound-po', [FakturController::class, 'index'])->name('inbound-po');
    Route::post('/inbound-po', [FakturController::class, 'store'])->name('inbound-po.store');

    // ── API Endpoints (AJAX) ──────────────────────────────────────────
    Route::get('/api/customers/search', [ServiceDeskController::class, 'searchCustomer'])->name('api.customers.search');
    Route::get('/api/barangs/search', [ServiceDeskController::class, 'searchBarang'])->name('api.barangs.search');
    Route::get('/api/staff/search', [StaffController::class, 'search'])->name('api.staff.search');
});
