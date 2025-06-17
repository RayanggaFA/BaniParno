<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SocialLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route default
Route::get('/', function () {
    return view('welcome');
});

Route::get('/family', [FamilyController::class, 'index']);
Route::get('/families/{id}/edit', [FamilyController::class, 'edit'])->name('families.edit');
Route::put('/families/{family}', [FamilyController::class, 'update'])->name('families.update');


// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/statistics', [DashboardController::class, 'statistics'])->name('dashboard.statistics');

// Resource Routes (Gunakan ini saja, lebih clean)
Route::resource('families', FamilyController::class);
Route::resource('members', MemberController::class);
Route::resource('social-links', SocialLinkController::class);

// Family Tree Routes (custom routes)
Route::get('/family-tree', [FamilyController::class, 'tree'])->name('families.tree');
Route::get('/families/{family}/tree', [FamilyController::class, 'showTree'])->name('families.show-tree');

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/stats', [DashboardController::class, 'apiStats']);
    Route::get('/families', [FamilyController::class, 'apiIndex']);
    Route::get('/members', [MemberController::class, 'apiIndex']);
    Route::get('/social-links', [SocialLinkController::class, 'apiIndex']);
});