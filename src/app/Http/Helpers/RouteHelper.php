<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Route;

/**
 * Class RouteHelper
 *
 * @package App\Http\Helpers
 */
class RouteHelper
{
    /**
     * Creates all required routes for backend CRUD operations
     *
     * @param string $controller
     * @param string $namePrefix
     * @param array  $skipRoutes
     */
    public static function createCRUDroutes ($controller, $namePrefix, $skipRoutes = [])
    {
        Route::get("/", "{$controller}@index")->name("{$namePrefix}");

        if (!in_array('edit', $skipRoutes)) {
            Route::get("/{id}", "{$controller}@show")->name("{$namePrefix}.edit");
        }
        if (!in_array('edit.submit', $skipRoutes)) {
            Route::post("/{id}", "{$controller}@update")->name("{$namePrefix}.edit.submit");
        }
        if (!in_array('create', $skipRoutes)) {
            Route::get("/create", "{$controller}@createView")->name("{$namePrefix}.create");
        }
        if (!in_array('create.submit', $skipRoutes)) {
            Route::post("/create", "{$controller}@create")->name("{$namePrefix}.create.submit");
        }
        if (!in_array('delete', $skipRoutes)) {
            Route::get("/delete/{id}", "{$controller}@delete")->name("{$namePrefix}.delete");
        }
    }

    /**
     * Prepares the config array for use in all backend controller config array
     *
     * @param string $namePrefix
     *
     * @return array
     */
    public static function prepareRouteConfigArray ($namePrefix)
    {
        return [
            'create' => "{$namePrefix}.create",
            'create-submit' => "{$namePrefix}.create.submit",
            'edit' => "{$namePrefix}.edit",
            'edit-submit' => "{$namePrefix}.edit.submit",
            'delete' => "{$namePrefix}.delete",
            'base' => $namePrefix
        ];
    }
}