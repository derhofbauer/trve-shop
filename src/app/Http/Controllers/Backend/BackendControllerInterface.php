<?php

namespace App\Http\Controllers\Backend;

use \Illuminate\Http\Request;

/**
 * Interface BackendControllerInterface
 *
 * @package App\Http\Controllers\Backend
 */
interface BackendControllerInterface
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ();

    /**
     * @param int|string $id ID of item to edit
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show ($id);

    /**
     * @param Request    $request
     * @param int|string $id ID of item to update
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (Request $request, $id);

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createView ();

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create (Request $request);

    /**
     * @param Request    $request
     * @param int|string $id ID of item to delete
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete (Request $request, $id);

    /**
     * @return array
     */
    public static function getValidationRules ();

    /**
     * @param array $additionalConfig
     *
     * @return array
     */
    public static function prepareConfig (array $additionalConfig);
}