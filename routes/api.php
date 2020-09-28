<?php

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
Route::namespace('Api')->group(function() {
    Route::group(["middleware" => "auth:api"], function () {
        Route::get('/me', 'UsersController@me')->name('api.me');
        Route::delete('/logout', 'AuthController@logout')->name('api.logout');
        Route::post('/change-password', 'UsersController@changePassword')->name('api.change-password');
        Route::post('/change-details', 'UsersController@changeDetails')->name('api.change-details');

        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', 'CategoryController@index');
            Route::post('/', 'CategoryController@store');
            Route::get('/{id}', 'CategoryController@show');
            Route::put('/{id}', 'CategoryController@update');
            Route::delete('/{id}', 'CategoryController@destroy');
        });

        Route::group(['prefix' => 'priorities'], function () {
            Route::get('/', 'PriorityController@index');
            Route::post('/', 'PriorityController@store');
            Route::get('/{id}', 'PriorityController@show');
            Route::put('/{id}', 'PriorityController@update');
            Route::delete('/{id}', 'PriorityController@destroy');
        });

        Route::group(['prefix' => 'projects'], function () {
            Route::get('/', 'ProjectController@index');
            Route::get('/getAll', 'ProjectController@getAll');
            Route::post('/', 'ProjectController@store');
            Route::get('/{id}', 'ProjectController@show');
            Route::put('/{id}', 'ProjectController@update');
            Route::delete('/{id}', 'ProjectController@destroy');
        });

        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/', 'TicketController@index');
            Route::post('/', 'TicketController@store');
            Route::get('/{id}', 'TicketController@show');
            Route::put('/{id}', 'TicketController@update');
            Route::delete('/{id}', 'TicketController@destroy');
        });    
    });

    Route::post('/login', 'AuthController@login')->name('api.login');
    Route::post('/register', 'AuthController@register')->name('api.register');
    Route::get('/email-verification', 'VerificationController@verify')->name('verification.verify');

    Route::post('/forgot-password', 'ForgotPasswordController@sendResetLinkEmail')->name('api.forgot-password');
    Route::post('/reset-password', 'ResetPasswordController@reset')->name('api.reset-password');

    Route::get('/role-permissions', 'RolePermissionController@index')->name('api.role-permission');
});

Route::namespace('Admin')->group(function() {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/tickets', 'TicketController@index');
        Route::get('/projects', 'ProjectController@index');
    });
});