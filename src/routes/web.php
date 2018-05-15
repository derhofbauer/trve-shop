<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Root route
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 * Auth Route
 */
Auth::routes();

/**
 * Frontend routes
 */
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::get('/admin', 'AdminController@index')->name('admin');
