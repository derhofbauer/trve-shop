<?php

namespace App\Http\Controllers\Backend;

use \Illuminate\Http\Request;

interface BackendControllerInterface
{
    public function index ();

    public function show ($id);

    public function update (Request $request, $id);

    public function createView ();

    public function create (Request $request);

    public function delete (Request $request, $id);

    public static function getValidationRules ();

    public static function prepareConfig (array $additionalConfig);
}