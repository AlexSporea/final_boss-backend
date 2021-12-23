<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\AdminEventoController;
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

Route::get('/eventType', function () {
    $events = Http::get('https://api.euskadi.eus/culture/events/v1.0/eventType');

    return $events->json();;
});

Route::get('/provinces', function () {
    $provinces = Http::get('https://api.euskadi.eus/culture/events/v1.0/provinces');

    return $provinces->json();;
});

Route::get('/municipalities', function () {
    $municipalities = Http::get('https://api.euskadi.eus/culture/events/v1.0/municipalities?_elements=285');

    return $municipalities->json();
});

Route::get('/populateEventos', [EventoController::class, 'populateTable']);

Route::get('/populateAdminEventos', [AdminEventoController::class, 'populateTable']);



