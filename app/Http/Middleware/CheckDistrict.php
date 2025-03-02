<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDistrict
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $dis_id = Auth::guard('district')->user();

        if ($dis_id && $dis_id->first_password_change == 0) {
            return redirect()->route('district.dashboard')->with('error', 'Please Change Your First Password !!'); // Redirect to change password view
        }

        return $next($request);
    }
}
