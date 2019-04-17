<?php
/**
 * @package  church-cms
 * @author John Muchiri
 * @date 2019
 */
namespace App\Http\Middleware;

use Closure;

class CheckRole
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string                   $role
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if(auth()->guest())
            return redirect('/login');

        //admin has all rights
        if(auth()->user()->role == 'admin')
            return $next($request);

        //if user has any of the roles proceed
        foreach ($roles as $role) {
            if(auth()->user()->role == $role)
                return $next($request);
        }

        return redirect()->back()->withErrors(__('Access denied'));
    }

}