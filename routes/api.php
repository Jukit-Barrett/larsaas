<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

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

Route::group([], function (Router $router) {
    $router->apiResource('activity', \App\Http\Controllers\ActivityController::class);

    $router->post("activity-restore/{id}", [\App\Http\Controllers\ActivityController::class, "restore"]);

    $router->get("codeGenerator", [\App\Http\Controllers\ActivityController::class, "codeGenerator"]);

});


