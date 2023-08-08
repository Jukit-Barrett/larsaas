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


Route::group(
    [
        'middleware' => 'auth:api',
    ],
    function (Router $router){
        // SystemHeader ******** ******** ******** ********  ******** ******** ******** ********
        $router->apiResource('system-header', \App\Http\Controllers\SystemHeaderController::class)->names(
            [
                'index'   => 'SystemHeader列表',
                'show'    => 'SystemHeader信息',
                'store'   => 'SystemHeader添加',
                'update'  => 'SystemHeader更新',
                'destroy' => 'SystemHeader删除',
            ]
        );

        $router->post('system-header-ext/multi', [\App\Http\Controllers\SystemHeaderController::class, 'many'])->name('SystemHeader批量获取');
});

//{{HERE}}



