<?php namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotGeneralManager {

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
			flash()->error('You are not authorized to proceed.');

		return redirect('/');	
		}
		elseif ( $request->user()->isGeneralManager())
		{			
			return $next($request);
		}
		flash()->error('You are not authorized to proceed.');
		return redirect('/');	
	}

}
