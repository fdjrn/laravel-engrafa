<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAuthJwt
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
        $token = $request->cookie('credential');

        if (empty($token)) {
            # code...
            $token = $request->session()->get('credential');
            if (empty($token)) {
                # code...
                return redirect('login');
            }
        }

        return $next($request);
    }
}
