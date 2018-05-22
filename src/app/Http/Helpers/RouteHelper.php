<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Route;

class RouteHelper
{
    public static function createCRUDroutes ($controller, $namePrefix)
    {
        Route::get("/", "{$controller}@index")->name("{$namePrefix}");
        Route::get("/{id}", "{$controller}@show")->name("{$namePrefix}.edit");
        Route::post("/{id}", "{$controller}@update")->name("{$namePrefix}.edit.submit");
        Route::get("/create", "{$controller}@createView")->name("{$namePrefix}.create");
        Route::post("/create", "{$controller}@create")->name("{$namePrefix}.create.submit");
        Route::get("/delete/{id}", "{$controller}@delete")->name("{$namePrefix}.delete");
    }

    public static function prepareRouteConfigArray ($base)
    {
        return [
            'create' => "{$base}.create",
            'create-submit' => "{$base}.create.submit",
            'edit' => "{$base}.edit",
            'edit-submit' => "{$base}.edit.submit",
            'delete' => "{$base}.delete",
            'base' => $base
        ];
    }
}