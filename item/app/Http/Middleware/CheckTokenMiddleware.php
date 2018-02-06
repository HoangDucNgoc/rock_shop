<?php

namespace App\Http\Middleware;

use App\Http\Responses\Response;
use Closure;

class CheckTokenMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$response = new Response();
		$gatewayToken = $request->header('app-token');

		// check token gateway
		/*if ($gatewayToken != '' && $gatewayToken != 'TOKEN_INVALID') {
			$decode = explode('_', base64_decode($gatewayToken));
			if (!isset($decode[1]) || $decode[1] != env('PRIVATE_GATEWAY_KEY')) {
				return $response->formatInvalid();
			}

		} else {
			return $response->formatInvalid();
		}*/

		return $next($request);
	}
}
