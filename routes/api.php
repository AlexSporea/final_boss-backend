<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\AdminEventoController;
use App\Http\Controllers\MeteoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/populateEventos', [EventoController::class, 'populateTable']);

Route::get('/populateAdminEventos', [AdminEventoController::class, 'populateTable']);

Route::get('/populateMeteo', [MeteoController::class, 'populateTable']);

Route::get('/getEventos', [EventoController::class, 'getEventos']);

Route::get('/getAdminEventos', [AdminEventoController::class, 'getAdminEventos']);

Route::get('/getMeteo', [MeteoController::class, 'getMeteo']);



