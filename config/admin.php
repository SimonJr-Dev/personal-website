<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Account
    |--------------------------------------------------------------------------
    |
    | This project has no database, so the portfolio's single admin account is
    | configured here. The password below is only used to seed the credential
    | file (storage/app/private/admin-credentials.json) the first time someone
    | signs in; after that, change it from the admin settings page. Delete that
    | file to fall back to the value below again.
    |
    */

    'email' => env('ADMIN_EMAIL', 'simonjrdev@gmail.com'),

    'password' => env('ADMIN_PASSWORD', 'admin123'),

];
