<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Add caching headers for static assets
        if (strpos($request->path(), 'images/') !== false || 
            strpos($request->path(), 'css/') !== false || 
            strpos($request->path(), 'js/') !== false) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000');
        }

        return $response;
    }
}