<?php

$defaultCaInfo = null;

if (file_exists('/etc/ssl/certs/ca-certificates.crt')) {
    $defaultCaInfo = '/etc/ssl/certs/ca-certificates.crt';
} elseif (file_exists(base_path('cacert.pem'))) {
    $defaultCaInfo = base_path('cacert.pem');
}

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
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
        CURLOPT_SSLVERSION     => env('MIDTRANS_FORCE_TLS12', false) ? CURL_SSLVERSION_TLSv1_2 : null,
        CURLOPT_CAINFO         => env('MIDTRANS_CURL_CAINFO', $defaultCaInfo),
    ], static fn ($value) => $value !== null && $value !== ''),

    'curl_options_fallback' => array_filter([
        CURLOPT_HTTPHEADER    => [],
        CURLOPT_SSL_VERIFYPEER => env('MIDTRANS_SSL_VERIFYPEER', true),
        CURLOPT_SSL_VERIFYHOST => (int) env('MIDTRANS_SSL_VERIFYHOST', 2),
        CURLOPT_CONNECTTIMEOUT => (int) env('MIDTRANS_CONNECT_TIMEOUT', 15),
        CURLOPT_TIMEOUT        => (int) env('MIDTRANS_TIMEOUT', 30),
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
        CURLOPT_CAINFO         => env('MIDTRANS_CURL_CAINFO', $defaultCaInfo),
    ], static fn ($value) => $value !== null && $value !== ''),

];
