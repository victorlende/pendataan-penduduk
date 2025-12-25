<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PendudukController;
use App\Http\Controllers\API\SyncController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes untuk Mobile App (Petugas RT/RW)
| Semua response dalam format JSON
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (Harus login dengan Sanctum token)
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Penduduk CRUD
    Route::get('/penduduk', [PendudukController::class, 'index']);
    Route::post('/penduduk', [PendudukController::class, 'store']);
    Route::get('/penduduk/{id}', [PendudukController::class, 'show']);
    Route::put('/penduduk/{id}', [PendudukController::class, 'update']);
    Route::delete('/penduduk/{id}', [PendudukController::class, 'destroy']);

    Route::get('/penduduk/keluarga/list', [PendudukController::class, 'getKeluargaList']);
    Route::get('/penduduk/keluarga/{no_kk}', [PendudukController::class, 'getAnggotaKeluarga']);

    // Sync (FITUR INTI!)
    Route::post('/sync/penduduk', [SyncController::class, 'syncPenduduk']);
    Route::get('/sync/logs', [SyncController::class, 'getLogs']);
});
