<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('lang')) {
            App::setLocale(session()->get('lang'));
        }
        return $next($request);
    }
}
