<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PersonController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BettingOddings;
use App\Http\Controllers\GameDailyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Payment\WebhookMPController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerInfoController;
use App\Http\Controllers\RefreshTeamsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StatController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/register-user', [RegisterController::class, 'registeruser']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Rutas RESTful para la entidad persons
    Route::get('/persons', [PersonController::class, 'index']);
    Route::get('/persons/{id}', [PersonController::class, 'show']);
    Route::post('/persons', [PersonController::class, 'store']);
    Route::put('/persons/{id}', [PersonController::class, 'update']);
    Route::patch('/persons/{id}', [PersonController::class, 'update']);
    Route::delete('/persons/{id}', [PersonController::class, 'destroy']);
});




Route::get('/subscriptions', [SubscriptionController::class, 'index']);
Route::get('/subscriptions/{id}', [SubscriptionController::class, 'show']);
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/subscriptions', [SubscriptionController::class, 'store']);
    Route::put('/subscriptions/{id}', [SubscriptionController::class, 'update']);
    Route::patch('/subscriptions/{id}', [SubscriptionController::class, 'update']);
    Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy']);
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::patch('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::post('/payment/notification', [WebhookMPController::class, 'handlenotification']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Rutas RESTful para la entidad payments
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::get('/payments/{id}', [PaymentController::class, 'show']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::put('/payments/{id}', [PaymentController::class, 'update']);
    Route::patch('/payments/{id}', [PaymentController::class, 'update']);
    Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);
});

Route::resource('/stats', StatController::class);

Route::post('/player-info', [PlayerInfoController::class, 'index']);


//TAREFAS CRON
Route::get('/game-daily', [GameDailyController::class, 'index']); //00:00 
Route::get('/game-daily/{gameDate}', [GameDailyController::class, 'getByGameDate']);

Route::get('/refresh-teams', [RefreshTeamsController::class, 'refreshTeams']); //00:00 
Route::get('/teams/{teamID}', [RefreshTeamsController::class, 'getByTeamID']);

Route::get('/fetch-news', [NewsController::class, 'fetchAndSaveNews']); //Cada 2 horas 
Route::get('/news', [NewsController::class, 'getNewsAll']);

Route::get('/betting-oddings', [BettingOddings::class, 'index']); //Nao definido
Route::get('/betting-odds/{teamIDHome}/{teamIDAway}', [BettingOddings::class, 'getByTeamIDs']);


Route::get('/fetch-players', [PlayerController::class, 'fetchAndStorePlayers']);
