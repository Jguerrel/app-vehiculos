<?php

namespace App\Http\Middleware;

use App\Enum\StatusVehicleEnum;
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
    protected $rootView = 'app';

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
     * @return mixed[]
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },

            // mensajes flash
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],

            // path
            'path' => [
                'vehicle' => [
                    'resize' => config('storage.vehicle.resize_pp'),
                    'original' => config('storage.vehicle.original_pp'),
                ],
            ],

            // status generales
            'status' => [
                // status de vehículos
                'vehicle' => [
                    'available' => StatusVehicleEnum::AVAILABLE,
                    'pending' => StatusVehicleEnum::PENDING,
                    'maintenance' => StatusVehicleEnum::MAINTENANCE,
                    'in_repair' => StatusVehicleEnum::IN_REPAIR,
                    'repaired' => StatusVehicleEnum::REPAIRED,
                ],
            ]
        ]);
    }
}
