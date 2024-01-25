<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
//        if(! $request->user()) {
//            return $next($request);
//        }
 
        //$language = $request->user()->language;
        
        if(is_null(session('locale')))
{
  session(['locale'=> "en"]);
}
        $language = session('locale');
            app()->setLocale($language);
        return $next($request);
    }
}