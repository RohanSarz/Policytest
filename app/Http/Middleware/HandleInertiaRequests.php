<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = fn() => $request->user() ? $request->user()->only('id', 'name', 'avatar', 'email') : null;
        $role = fn() => $request->user() ? $request->user()->getRoleNames() : null;

        $permissionNames = $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name')->toArray() : [];
        $permissionMap = array_fill_keys($permissionNames, true);

        return [
            ...parent::share($request),

            'auth' => [
                'user' => $user ?? null,
                'role' => $role ?? null,
            ],
            'permissions' => $permissionMap,

            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'type' => fn() => $request->session()->get('type'),
            ],
        ];
    }
}
