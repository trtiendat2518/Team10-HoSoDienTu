<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('../public/avatar'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'publicadmin' => [
            'driver' => 'local',
            'root' => storage_path('../public/avatar/admin'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'publiclecturer' => [
            'driver' => 'local',
            'root' => storage_path('../public/avatar/lecturer'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'publicstudent' => [
            'driver' => 'local',
            'root' => storage_path('../public/avatar/student'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'attachment' => [
            'driver' => 'local',
            'root' => storage_path('../public/attachments/requests'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'fileprocedure' => [
            'driver' => 'local',
            'root' => storage_path('../public/attachments/procedures'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'postavatar' => [
            'driver' => 'local',
            'root' => storage_path('../public/avatar/post'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
