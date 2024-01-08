<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    |
    | Define which API service should be used to retrieve the exchange rates.
    |
    | Supported: "exchange-rates-api-io", "exchange-rates-data-api", "exchange-rate-host"
    |
    */
    'driver' => 'exchange-rates-api-io',

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Define your API key here.
    |
    */
    'api_key' => env('EXCHANGE_RATES_API_KEY'),
    'api_url' => env('EXCHANGE_RATES_API_URL', 'http://api.exchangeratesapi.io/v1/'),

    /*
    |--------------------------------------------------------------------------
    | Use HTTPS
    |--------------------------------------------------------------------------
    |
    | Define if the API should be accessed via HTTPS or HTTP. The free tiers of
    | exchangeratesapi.io and exchangerate.host only allow API access via HTTP.
    |
    */
    'https' => true,

];
