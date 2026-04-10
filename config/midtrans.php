<?php

$defaultCaInfo = file_exists(base_path('cacert.pem')) ? base_path('cacert.pem') : null;

return [

    /*
    |--------------------------------------------------------------------------
    | Midtrans Server Key
    |--------------------------------------------------------------------------
    */
    'server_key'    => env('MIDTRANS_SERVER_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Client Key
    |--------------------------------------------------------------------------
    */
    'client_key'    => env('MIDTRANS_CLIENT_KEY', ''),

    /*  
    |--------------------------------------------------------------------------
    | Midtrans Is Production
    |--------------------------------------------------------------------------
    */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Sanitized
    |--------------------------------------------------------------------------
    */
    'is_sanitized'  => env('MIDTRANS_SANITIZED', true),

    /*
    |--------------------------------------------------------------------------
    | Midtrans 3DS
    |--------------------------------------------------------------------------
    */
    'is_3ds'        => env('MIDTRANS_3DS', true),

    'curl_options'  => array_filter([
        CURLOPT_HTTPHEADER    => [],
        CURLOPT_SSL_VERIFYPEER => env('MIDTRANS_SSL_VERIFYPEER', true),
        CURLOPT_SSL_VERIFYHOST => (int) env('MIDTRANS_SSL_VERIFYHOST', 2),
        CURLOPT_CONNECTTIMEOUT => (int) env('MIDTRANS_CONNECT_TIMEOUT', 15),
        CURLOPT_TIMEOUT        => (int) env('MIDTRANS_TIMEOUT', 30),
        CURLOPT_SSLVERSION     => env('MIDTRANS_FORCE_TLS12', true) ? CURL_SSLVERSION_TLSv1_2 : null,
        CURLOPT_CAINFO         => env('MIDTRANS_CURL_CAINFO', $defaultCaInfo),
    ], static fn ($value) => $value !== null && $value !== ''),

];
