<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
    	//dd('here');
        if(\Auth::guard('admin')->user()){
            return $next($request);
        }else{
			return redirect('/app-admin/login');
		}
        return redirect()->back();
            
        
    }
}
