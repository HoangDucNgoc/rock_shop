<?php

return [
    'proxies' => env('PROXY_IP', '*') != '*' ? explode(',', env('PROXY_IP', '*')) : '*',
];
