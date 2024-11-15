<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Mengambil semua data pasien.
Route::get('patients', [PatientController::class, 'index']);
// Menambahkan data pasien baru.
Route::post('patients', [PatientController::class, 'store']);
// Mengambil data pasien berdasarkan ID
Route::get('patients/{id}', [PatientController::class, 'show']);
// Memperbarui data pasien berdasarkan ID.
Route::put('patients/{id}', [PatientController::class, 'update']);
// Memperbarui data pasien berdasarkan ID.
Route::delete('patients/{id}', [PatientController::class, 'destroy']);
// Mencari pasien berdasarkan nama.
Route::get('patients/search/{name}', [PatientController::class, 'search']);

// Untuk pendaftaran pengguna baru.
Route::post('register', [AuthController::class, 'register']);
// Untuk login dan mendapatkan token autentikasi.
Route::post('login', [AuthController::class, 'login']);

