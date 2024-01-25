<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next)
    {
        
        $requestedDeptId = $request->route('id');
        $requestedUserId = $request->route('user_id');

        $user = User::where('id', $requestedUserId)->first();


        if ($requestedDeptId != $user->department_id) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
