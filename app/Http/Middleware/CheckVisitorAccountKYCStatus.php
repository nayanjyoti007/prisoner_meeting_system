<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckVisitorAccountKYCStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $visitor = Auth::guard('visitor')->user();

        if ($visitor && $visitor->kyc_status !== 'Approved') {
            return redirect()->route('visitor.dashboard')->with('error', 'Your KYC is not approved. Please upload your Aadhar & Voter ID.'); // Redirect to change password view
        }

        return $next($request);
    }
}
