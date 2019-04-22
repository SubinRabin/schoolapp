<?php

return [

    /*
    |--------------------------------------------------------------------------
    | UNIFONIC Apps Id
    |--------------------------------------------------------------------------
    |
    | Application key for unifonic API.
    |
     */
    'appsid' => [
        'default' => env('UNIFONIC_APPS_ID', 'CVqs8GIzUtPHSxjSu3oq7qyXkL6nqe'),
        // OPTIONAL
        'second' => env('UNIFONIC_SECOND_APPS_ID', 'jpP9uKbhZWLUat00MNKQGTrjA53Xpp')
    ],


    /*
    |--------------------------------------------------------------------------
    | Api URLS
    |--------------------------------------------------------------------------
    |
    | Urls for UNIFONIC Messages API
    |
     */
    'urls' => [
        'messages'  => 'http://api.unifonic.com/rest/Messages/',
        'account'  => 'http://api.unifonic.com/rest/Account/',
    ],

];