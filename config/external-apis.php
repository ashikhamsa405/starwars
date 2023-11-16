<?php


/**
 * config file to set up the basic details
 */
return [
    'swapiprovider' => env('sw_api_provider', 'sw_api_live_provider'), // 'swapiprovider', 'testing'
    'sw_api_live_provider' => [
        'base_url' => 'https://swapi.dev/api/',
    ],
    'sw_api_test_provider' => [
        'base_url' => 'https://swapi.dev/api/',
    ],
];