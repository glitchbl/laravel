<?php

/**
 * Client
 */
Route::get('connexion', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('connexion', 'Auth\LoginController@login');
Route::post('deconnexion', 'Auth\LoginController@logout')->name('logout');

Route::get('mot-de-passe/reinitialiser', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('mot-de-passe/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('mot-de-passe/reinitialiser/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('mot-de-passe/reinitialiser', 'Auth\ResetPasswordController@reset');

Route::group([
    'middleware' => ['auth:client'],
], function () {
    Route::get('', 'HomeController@index')->name('home');
});

/**
 * Admin
 */
Route::get('admin/connexion', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('admin/connexion', 'Admin\Auth\LoginController@login');
Route::post('admin/deconnexion', 'Admin\Auth\LoginController@logout')->name('admin.logout');

Route::get('admin/mot-de-passe/reinitialiser', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin/mot-de-passe/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/mot-de-passe/reinitialiser/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/mot-de-passe/reinitialiser', 'Admin\Auth\ResetPasswordController@reset');

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth:admin'],
], function () {
    Route::get('', 'HomeController@index')->name('home');
});