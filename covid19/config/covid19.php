<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Credentials
    |--------------------------------------------------------------------------
    |
    | The bcrypt hash of the admin password used to access the admin panel.
    | Override via the ADMIN_PASSWORD_HASH environment variable.
    | Generate a new hash with: php artisan tinker --execute="echo bcrypt('your-password');"
    |
    */

    'admin_password_hash' => env('ADMIN_PASSWORD_HASH', '$2y$10$55860tfMh.3GT9204nIdR.CtGL1cBtks.NDIDEN4V.epDD1G2ghKu'),

];
