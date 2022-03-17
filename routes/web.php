<?php

use Illuminate\Support\Facades\Route;

Route::get(config('loggable.route_path'), 'LoggableController@index')->name('loggable.index');
Route::get(config('loggable.route_path').'/logs', 'LoggableController@logs')->name('loggable.logs');
Route::get(config('loggable.route_path').'/users', 'LoggableController@users')->name('loggable.users');
Route::get(config('loggable.route_path').'/tables', 'LoggableController@tables')->name('loggable.tables');
Route::get(config('loggable.route_path').'/models', 'LoggableController@models')->name('loggable.models');
