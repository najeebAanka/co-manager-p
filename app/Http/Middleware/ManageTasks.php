<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManageTasks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        $user = $request->user();

        // Check if user can manage department tasks or his own department tasks
        if ($user->can('manage-department-tasks') || $user->can('manage-his-department-tasks')) {
            return $next($request);
        }

        // Neither permission is applicable, handle as needed (e.g., return a response or redirect)
        return abort(403, 'Unauthorized');
    }
}
