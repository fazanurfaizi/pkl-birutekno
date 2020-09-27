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

Route::group(["middleware" => "auth:api"], function () {
    Route::get('/me', 'UsersController@me')->name('api.me');
    Route::delete('/logout', 'AuthController@logout')->name('api.logout');
    Route::post('/change-password', 'UsersController@changePassword')->name('api.change-password');
    Route::post('/change-details', 'UsersController@changeDetails')->name('api.change-details');
});

Route::post('/login', 'AuthController@login')->name('api.login');
Route::post('/register', 'AuthController@register')->name('api.register');
Route::get('/email-verification', 'VerificationController@verify')->name('verification.verify');

Route::post('/forgot-password', 'ForgotPasswordController@sendResetLinkEmail')->name('api.forgot-password');
Route::post('/reset-password', 'ResetPasswordController@reset')->name('api.reset-password');

Route::get('/role-permissions', 'RolePermissionController@index')->name('api.role-permission');