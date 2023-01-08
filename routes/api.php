<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\KanbanCardController;
use App\Http\Controllers\API\KanbanColumnController;
use App\Http\Controllers\API\UserController;
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

Route::post('login', [AuthController::class, 'login']);

Route::get('/k-board/cards', [KanbanColumnController::class, 'getCards'])->middleware('access.token');

// Authenticated routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('user', [UserController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('kanban-columns', KanbanColumnController::class);
    Route::post('cards/{column_id}/add', [KanbanColumnController::class, 'addCard']);

    Route::get('kanban-board/db/export', [KanbanColumnController::class, 'downloadBoard']);
});

