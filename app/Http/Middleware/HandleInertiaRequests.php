<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'admin.app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ?  $request->user() : null,
            ],
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
            'flash' => [
                'success' => session('success'),
                'warning' => session('warning'),
                'error' => session('error'),
            ],
            'menus' => [
                [
                    'label' => 'Dashboard',
                    'url' => route('admin.dashboard'),
                    'isActive' => $request->routeIs('admin.dashboard'),
                    'isVisible' => true
                ],


            ],
            'dropdown' => [
                [
                    'label' => 'Permissions',
                    'url' => route('admin.permissions.index'),
                    'isVisible' => $request->user() ? $request->user()->can('view permissions module') : null,
                ],
                [
                    'label' => 'Roles',
                    'url' => route('admin.roles.index'),
                    'isVisible' => $request->user() ? $request->user()->can('view roles module') : null,
                ],


            ]


        ]);
    }
}
