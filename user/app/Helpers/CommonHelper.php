<?php

namespace App\Helpers;

use Log;

class CommonHelper
{
    /**
     * write log request
     *@param \Illuminate\Http\Request $request
     */
    public static function logRequest($request)
    {
        $url         = $request->fullUrl();
        $method      = $request->getMethod();
        $ip          = $request->getClientIp();
        $dataRequest = $request->getContent();

        $log = "==================== \n {$ip}:  {$method}@{$url} [{$dataRequest}]";
        Log::info($log);
    }

    public function randomKey($str_length = 24)
    {
        // base 62 map
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // get enough random bits for base 64 encoding (and prevent '=' padding)
        // note: +1 is faster than ceil()
        $bytes = openssl_random_pseudo_bytes(3 * $str_length / 4 + 1);

        // convert base 64 to base 62 by mapping + and / to something from the base 62 map
        // use the first 2 random bytes for the new characters
        $repl = unpack('C2', $bytes);

        $first  = $chars[$repl[1] % 62];
        $second = $chars[$repl[2] % 62];

        return strtr(substr(base64_encode($bytes), 0, $str_length), '+/', "$first$second");
    }
}
