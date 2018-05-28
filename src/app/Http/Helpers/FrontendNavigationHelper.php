<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Request;

/**
 * Class FrontendNavigationHelper
 *
 * @package App\Http\Helpers
 */
class FrontendNavigationHelper
{
    /**
     * @return array
     */
    public static function prepareFeNavigation ()
    {
        $routes = [
            [
                'route' => route('shop'),
                'slug' => 'shop',
                'label' => __('Shop'),
                'active' => false
            ],
            [
                'route' => route('blog'),
                'slug' => 'blog',
                'label' => __('Blog'),
                'active' => false
            ]
        ];

        foreach ($routes as $key => $route) {
            if (Request::segment(1) == $route['slug']) {
                $routes[$key]['active'] = true;
            }
        }
        return $routes;
    }
}