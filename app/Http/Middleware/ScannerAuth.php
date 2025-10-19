<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScannerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('scanner_user')) {
            return redirect()->route('scanner.login');
        }
        
        return $next($request);
    }
}