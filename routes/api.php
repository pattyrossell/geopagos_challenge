<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource("v1/player", \App\Http\Controllers\Api\V1\PlayerController::class)->only(['index', 'show']);
Route::apiResource("v1/tournament", \App\Http\Controllers\Api\V1\TournamentController::class)->only(['index', 'show', 'store']);