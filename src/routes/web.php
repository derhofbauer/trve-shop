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
Route::get('/', function () {
    return redirect()->route('shop');
})->name('root');

/**
 * Auth Route
 */
Auth::routes();

/**
 * Frontend routes
 */
Route::prefix('shop')->group(function () {
    Route::get('/', 'Frontend\SysProductController@index')->name('shop');
    Route::get('/products', 'Frontend\SysProductController@index')->name('products');
    Route::get('/products/{id}/{slug?}', 'Frontend\SysProductController@show')->name('products.show');
    Route::get('/products/filter', 'Frontend\FilterController@filter')->name('products.filter');
    Route::post('/products/{id}', 'Frontend\SysCommentController@create')->name('products.comment.add');
});
Route::prefix('cart')->group(function () {
    Route::get('/', 'Frontend\CartController@index')->name('cart');
    Route::get('/add/{id}/{returnUrl?}', 'Frontend\CartController@addToCart')->name('cart.add');
    Route::post('/update', 'Frontend\CartController@update')->name('cart.update');
    Route::get('/remove/{id}', 'Frontend\CartController@removeFromCart')->name('cart.remove');
});
Route::prefix('blog')->group(function () {
    Route::get('/', 'Frontend\SysBlogEntryController@index')->name('blog');
    Route::get('/{id}/{slug?}', 'Frontend\SysBlogEntryController@show')->name('blog.show');
});
Route::prefix('profile')->group(function () {
    Route::get('/', 'Frontend\ProfileController@index')->name('profile');
    Route::post('/', 'Frontend\ProfileController@update')->name('profile.update');
    Route::get('/orders', 'Frontend\ProfileController@orders')->name('profile.orders');
});
Route::get('/search/{searchterm?}', 'Frontend\SearchController@search')->name('search');
Route::prefix('checkout')->group(function () {
    Route::get('/', 'Frontend\CartController@checkout')->name('checkout');
    Route::post('/confirm', 'Frontend\CartController@confirmAndBuy')->name('checkout.confirm');
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