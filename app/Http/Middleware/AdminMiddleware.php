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
    public function handle($request, Closure $next)
    {
        $this->foo();
        return $next($request);
    }

    public function foo(){

        echo "in join";

    }

    public function bar($request, Closure $next){
        echo "out";
        return $next($request);
    }
}
