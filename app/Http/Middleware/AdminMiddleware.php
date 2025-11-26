<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\returnArgument;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin privileges
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // Check if the user has 'admin' or 'super-admin' role
        if (!$user->hasRole(['admin', 'super-admin'])) {
            return redirect()->back()->with('flash' , [
                'message' => 'You do not have permission to access this page.',
                'type' => 'warning',
            ],);
        }

        return $next($request);
    }
}
