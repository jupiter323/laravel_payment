<?php
namespace App\Http\Middleware;
use Closure;
use Entrust;

class StaffAccessible
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Entrust::hasRole(config('constant.default_customer_role')))
            return $next($request);
        else
            return redirect('/home')->withErrors(trans('messages.invalid_link'));
    }
}
