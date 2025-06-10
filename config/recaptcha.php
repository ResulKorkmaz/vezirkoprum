<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google reCAPTCHA v3 Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Google reCAPTCHA v3 settings.
    |
    */

    'site_key' => env('RECAPTCHA_SITE_KEY', ''),
    'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
    'enabled' => env('RECAPTCHA_ENABLED', true),
    'score_threshold' => env('RECAPTCHA_SCORE_THRESHOLD', 0.5),
    'timeout' => env('RECAPTCHA_TIMEOUT', 30),
]; 