<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || $request->user()->role !== $role) {
            // Redirect berdasarkan role user
            if ($request->user()) {
                if ($request->user()->role === 'admin') {
                    return redirect('/home')->with('error', 'Access denied.');
                } else {
                    return redirect('/welcome')->with('error', 'Access denied.');
                }
            }

            return redirect('/login')->with('error', 'Please login first.');
        }

        return $next($request);
    }
}
