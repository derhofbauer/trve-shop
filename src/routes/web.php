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
//Route::get('/', function () {
//    return view('frontend/welcome');
//})->name('root');
Route::get('/', 'HomeController@index')->name('root');

/**
 * Frontend routes
 */
Route::prefix('home')->group(function () {
    /**
     * Auth Route
     */
    Auth::routes();

    Route::get('/', 'HomeController@index')->name('home');
});

Route::prefix('blog')->group(function () {
    Route::get('/', 'BlogController@index')->name('blog');
    Route::get('/{id}/{slug?}', 'BlogController@show')->name('blog.show');
});

/**
 * Backend routes
 */
Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    Route::get('/users', 'SysBeuserController@index')->name('admin.users');
    Route::get('/users/backend', 'SysBeuserController@index')->name('admin.users.backend');
    Route::get('/users/backend/{id}', 'SysBeuserController@show')->name('admin.users.backend.edit');
    Route::post('/users/backend/{id}', 'SysBeuserController@update')->name('admin.user.backend.edit.submit');
    Route::get('/users/backend/create', 'SysBeuserController@createView')->name('admin.user.backend.create');
    Route::post('/users/backend/create', 'SysBeuserController@create')->name('admin.user.backend.create.submit');
    Route::get('/users/backend/delete/{id}', 'SysBeuserController@delete')->name('admin.users.backend.delete');
});