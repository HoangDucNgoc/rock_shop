<?php

namespace App\Http\Middleware;

use App\Http\Responses\Response;
use App\Helpers\CommonHelper;
use Closure;

class JsonMiddleware
{
    const PARSED_METHODS = [
        'POST', 'PUT', 'PATCH',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = new Response();
        if ($request->isJson()) {
            if (in_array($request->getMethod(), self::PARSED_METHODS)) {
                $request->merge((array) json_decode($request->getContent()));
            }
        } else {
            return $response->formatInvalid();
        }

        CommonHelper::logRequest($request);

        return $next($request);
    }
}
