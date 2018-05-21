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
Route::get('/', 'Frontend\HomeController@index')->name('root');

/**
 * Frontend routes
 */
Route::prefix('home')->group(function () {
    /**
     * Auth Route
     */
    Auth::routes();

    Route::get('/', 'Frontend\HomeController@index')->name('home');
});

Route::prefix('blog')->group(function () {
    Route::get('/', 'Frontend\SysBlogEntryController@index')->name('blog');
    Route::get('/{id}/{slug?}', 'Frontend\SysBlogEntryController@show')->name('blog.show');
});

/**
 * Backend routes
 */
Route::prefix('admin')->group(function () {
    Route::get('/', 'Backend\AdminController@index')->name('admin');
    Route::get('/login', 'Backend\Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Backend\Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Backend\Auth\AdminLoginController@logout')->name('admin.logout');

    Route::get('/users', 'Backend\SysBeuserController@index')->name('admin.users');
    Route::get('/users/backend', 'Backend\SysBeuserController@index')->name('admin.users.backend');
    Route::get('/users/backend/{id}', 'Backend\SysBeuserController@show')->name('admin.users.backend.edit');
    Route::post('/users/backend/{id}', 'Backend\SysBeuserController@update')->name('admin.users.backend.edit.submit');
    Route::get('/users/backend/create', 'Backend\SysBeuserController@createView')->name('admin.users.backend.create');
    Route::post('/users/backend/create', 'Backend\SysBeuserController@create')->name('admin.users.backend.create.submit');
    Route::get('/users/backend/delete/{id}', 'Backend\SysBeuserController@delete')->name('admin.users.backend.delete');

    Route::get('/blog', 'Backend\SysBlogEntryController@index')->name('admin.blog');
    Route::get('/blog/{id}', 'Backend\SysBlogEntryController@show')->name('admin.blog.edit');
    Route::post('/blog/{id}', 'Backend\SysBlogEntryController@update')->name('admin.blog.edit.submit');
    Route::get('/blog/create', 'Backend\SysBlogEntryController@createView')->name('admin.blog.create');
    Route::post('/blog/create', 'Backend\SysBlogEntryController@create')->name('admin.blog.create.submit');
    Route::get('/blog/delete/{id}', 'Backend\SysBlogEntryController@delete')->name('admin.blog.delete');
});