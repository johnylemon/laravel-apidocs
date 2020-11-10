<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General documentation info
    |--------------------------------------------------------------------------
    |
    | This section contains basic documentation info
    |
    */
    'info' => [
        'version' => '1.0',
        'title' => 'Laravel API documentation',
        'description' => 'Laravel API documentation',
    ],

    /*
    |--------------------------------------------------------------------------
    | Domain Address
    |--------------------------------------------------------------------------
    |
    */
    'domain' => env('APP_URL'),

    /*
    |--------------------------------------------------------------------------
    | Default exporter
    |--------------------------------------------------------------------------
    |
    | This package can export api documentation data with different format
    | if you would like.
    |
    | By default `Johnylemon\Apidocs\Exporter` class will be used,
    | but feel free to use your own, if you would like to do so
    |
    */
    'exporter' => Johnylemon\Apidocs\Exporter::class,

    /*
    |--------------------------------------------------------------------------
    | Apidocs header name
    |--------------------------------------------------------------------------
    |
    | Here you can set name of header added to request when `try it`
    | functionality is used
    |
    | Change it if default value interferes with your app
    |
    */
    'header_name' => 'x-apidocs',

    /*
    |--------------------------------------------------------------------------
    | Apidocs uri
    |--------------------------------------------------------------------------
    |
    | Uri address where documentation will be presented
    |
    */
    'uri' => env('APIDOCS_URI', '/apidocs'),

    /*
    |--------------------------------------------------------------------------
    | Json data file location
    |--------------------------------------------------------------------------
    |
    | Exported json file location
    |
    */
    'file_path' => env('APIDOCS_FILE_PATH', storage_path('apidocs.json')),

    /*
    |--------------------------------------------------------------------------
    | Directories
    |--------------------------------------------------------------------------
    |
    | Default directory names used for storing newly created classes
    | when `apidocs:endpoint` or `apidocs:param` are called.
    | Relatve to `app` directory
    |
    */
    'dir' => [
        'endpoints' => 'Apidocs/Endpoints',
        'params' => 'Apidocs/Params',
    ],
];
