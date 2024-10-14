<?php

use App\Http\Controllers\ExplorerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/explorers', [ExplorerController::class, 'store'])->name('explorers.store');
Route::put('/explorers/{id}',[ExplorerController::class, 'update'])->name('explorers.update');
Route::post('explorers/{id}/inventario',[ExplorerController::class, 'edit'])->name('explorers.edit');
Route::post('explorers/trocar',[ExplorerController::class,'trocarItem'])->name('explorers.trocarItem');
Route::get('/explorers/{id}',[ExplorerController::class,'show'])->name('explorers.show');