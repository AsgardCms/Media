<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Choose which filesystem you wish to use to store the media
    |--------------------------------------------------------------------------
    | Choose one or more of the filesystems you configured
    | in app/config/filesystems.php
    | Supported: "local", "s3"
    */
    'filesystem' => 'local',
    /*
    |--------------------------------------------------------------------------
    | The path where the media files will be uploaded
    |--------------------------------------------------------------------------
    | Note: Trailing slash is required
    */
    'files-path' => '/assets/media/',
    /*
    |--------------------------------------------------------------------------
    | Specify all the allowed file extensions a user can upload on the server
    |--------------------------------------------------------------------------
    */
    'allowed-types' => '.jpg,.png',
    /*
    |--------------------------------------------------------------------------
    | Determine the max file size upload rate
    | Defined in MB
    |--------------------------------------------------------------------------
    */
    'max-file-size' => '5',

    /*
    |--------------------------------------------------------------------------
    | Determine the max total media folder size
    |--------------------------------------------------------------------------
    | Expressed in bytes
    */
    'max-total-size' => 1000000000,

    /*
    |--------------------------------------------------------------------------
    | Define which assets will be available through the asset manager
    |--------------------------------------------------------------------------
    | These assets are registered on the asset manager
    */
    'media-partial-assets' => [
        // Styles
        'asgard.css' => ['theme' => 'css/asgard.css'],
        // Javascript
        'jquery-ui.js' => ['module' => 'dashboard:vendor/jquery-ui/jquery-ui.min.js'],
        'media-partial.js' => ['module' => 'media:js/media-partial.js'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Define which default assets will always be included in your pages
    | through the asset pipeline
    |--------------------------------------------------------------------------
    */
    'media-partial-required-assets' => [
        'css' => [
            'asgard.css',
        ],
        'js' => [
            'jquery-ui.js',
            'media-partial.js',
        ],
    ],
];
