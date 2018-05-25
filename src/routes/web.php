<?php

use App\Http\Helpers\RouteHelper;

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
    Route::prefix('/users/backend')->group(function () {
        RouteHelper::createCRUDroutes('Backend\SysBeuserController', 'admin.users.backend');
    });

    Route::prefix('/users/frontend')->group(function () {
        RouteHelper::createCRUDroutes('Backend\SysFeuserController', 'admin.users.frontend');
    });

    Route::prefix('/blog')->group(function () {
        RouteHelper::createCRUDroutes('Backend\SysBlogEntryController', 'admin.blog');
    });

    Route::prefix('/products')->group(function () {
        RouteHelper::createCRUDroutes('Backend\SysProductController', 'admin.products');
    });

    Route::prefix('/categories')->group(function () {
        RouteHelper::createCRUDroutes('Backend\SysProductCategoryController', 'admin.categories');
    });

    Route::prefix('/comments')->group(function () {
        RouteHelper::createCRUDroutes('Backend\SysCommentController', 'admin.comments', [
            'create',
            'create.submit'
        ]);
    });

    Route::prefix('/ratings')->group(function () {
        RouteHelper::createCRUDroutes('Backend\SysRatingController', 'admin.ratings', [
            'create',
            'create.submit',
            'edit',
            'update'
        ]);
    });

    Route::prefix('/orders')->group(function () {
        RouteHelper::createCRUDroutes('Backend\SysOrderController', 'admin.orders');
    });
});