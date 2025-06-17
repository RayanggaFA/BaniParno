<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\SocialLinkController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\FamilyController as APIFamilyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function () {
    
    // Dashboard & Statistics
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/dashboard/recent-members', [DashboardController::class, 'getRecentMembers']);
    
    // Family Management
    Route::apiResource('families', FamilyController::class);
    Route::get('/families/{family}/members', [FamilyController::class, 'getMembers']);
    Route::get('/families/{family}/tree', [FamilyController::class, 'getFamilyTree']);
    
    // Member Management
    Route::apiResource('members', MemberController::class);
    Route::get('/members/search/{query}', [MemberController::class, 'search']);
    Route::get('/members/{member}/children', [MemberController::class, 'getChildren']);
    Route::get('/members/{member}/history', [MemberController::class, 'getHistory']);
    Route::post('/members/{member}/upload-photo', [MemberController::class, 'uploadPhoto']);
    
    // Social Links Management
    Route::apiResource('members.social-links', SocialLinkController::class)->shallow();
    
    // Family Tree Visualization
    Route::get('/tree/full', [FamilyController::class, 'getFullFamilyTree']);
    Route::get('/tree/branch/{family}', [FamilyController::class, 'getBranchTree']);
    
    // Statistics & Reports
    Route::get('/statistics/by-generation', [DashboardController::class, 'getByGeneration']);
    Route::get('/statistics/by-location', [DashboardController::class, 'getByLocation']);
    Route::get('/statistics/by-age-group', [DashboardController::class, 'getByAgeGroup']);
    
});