<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserDeptID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next)
    {
        
        $requestedDeptId = $request->route('id');
        $user_id = Auth::id();

        $user = User::where('id', $user_id)->first();

        $loggedInUserDeptId = $user->department_id;

        if ($requestedDeptId != $loggedInUserDeptId) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
