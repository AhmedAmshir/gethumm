<?php

namespace App\Http\Middleware;

use Closure;
use App\Handlers\RequestHandler;
use App\Handlers\ResponseHandler;

class CheckApiKeyMiddleware
{

    use RequestHandler, ResponseHandler;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->header('x-api-key')) {
            return $this->Unauthorized('API KEY not found');
        }

        if($request->header('x-api-key') != config('app.API_KEY')) {
            return $this->Unauthorized('Wrong API KEY');
        }
        return $next($request);
    }
}
