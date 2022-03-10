<?php

use Illuminate\Support\Facades\Route;

Route::get(config('loggable.route_path'), [Jvizcaya\Loggable\Controllers\LoggableController::class, 'index']);
Route::get(config('loggable.route_path').'/logs', [Jvizcaya\Loggable\Controllers\LoggableController::class, 'logs']);
Route::get(config('loggable.route_path').'/users', [Jvizcaya\Loggable\Controllers\LoggableController::class, 'users']);
Route::get(config('loggable.route_path').'/tables', [Jvizcaya\Loggable\Controllers\LoggableController::class, 'tables']);
Route::get(config('loggable.route_path').'/models', [Jvizcaya\Loggable\Controllers\LoggableController::class, 'models']);
