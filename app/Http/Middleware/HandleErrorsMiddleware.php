<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleErrorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Definiamo la funzione highlight_file se non esiste
        if (!function_exists('highlight_file')) {
            function highlight_file($filename, $return = false) {
                $code = file_get_contents($filename);
                $highlighted = '<pre>' . htmlentities($code) . '</pre>';
                
                if ($return) {
                    return $highlighted;
                }
                
                echo $highlighted;
                return true;
            }
        }
        
        // Definiamo anche la funzione highlight_string se non esiste
        if (!function_exists('highlight_string')) {
            function highlight_string($string, $return = false) {
                $highlighted = '<pre>' . htmlentities($string) . '</pre>';
                
                if ($return) {
                    return $highlighted;
                }
                
                echo $highlighted;
                return true;
            }
        }
        
        return $next($request);
    }
} 