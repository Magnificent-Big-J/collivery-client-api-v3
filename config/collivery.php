<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Collivery API Credentials
    |--------------------------------------------------------------------------
    |
    | Here you may specify your Collivery API credentials, including your
    | username and password. These credentials will be used for authenticating
    | requests to the Collivery API.
    |
    */

    'username' => env('COLLIVERY_USERNAME', 'your-username'),
    'password' => env('COLLIVERY_PASSWORD', 'your-password'),

    /*
    |--------------------------------------------------------------------------
    | Application Information
    |--------------------------------------------------------------------------
    |
    | These settings specify details about your application, such as the app
    | name, version, host environment, language, and URL. These details will
    | be sent as headers in each API request.
    |
    */

    'app_name' => env('COLLIVERY_APP_NAME', 'My Custom App'),
    'app_version' => env('COLLIVERY_APP_VERSION', '0.2.1'),
    'app_host' => env('COLLIVERY_APP_HOST', 'PHP 8.0'),
    'app_lang' => env('COLLIVERY_APP_LANG', 'en'),
    'app_url' => env('COLLIVERY_APP_URL', 'https://example.com'),


];
