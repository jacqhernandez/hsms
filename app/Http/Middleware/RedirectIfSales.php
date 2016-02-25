<?php namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfSales {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Auth::guest())
		{
			return redirect('/auth/login');	
		}
		elseif ( $request->user()->isGeneralManager() || $request->user()->isAccounting() )
		{			
			return $next($request);
		}
		return redirect('/home');	
	}

}
