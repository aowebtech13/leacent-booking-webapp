<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To View Collections: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_values(array_filter(array_unique(array_merge(
        [
            'http://localhost:3000',
            'http://localhost:3001',
            'http://localhost:3002',
            'http://localhost:5173',
            'http://127.0.0.1:3000',
            'http://127.0.0.1:3001',
            'http://127.0.0.1:3002',
            'http://127.0.0.1:5173',
            'https://www.mictomonbespoketailor.com',
            'https://mictomonbespoketailor.com',
            'https://backdmctmntlorsh.mictomonbespoketailor.com',
            
        ],
        array_filter([
            env('APP_URL'),
            env('FRONTEND_URL'),
        ]),
        array_map('trim', explode(',', env('CORS_ALLOWED_ORIGINS', '')))
    )))),

    'allowed_origins_patterns' => array_filter(array_merge(
        [
            '#^https://[^/]+\\.vercel\\.app$#',
            '#^https://[^/]+\\.netlify\\.app$#',
            '#^https://[^/]+\\.netlify\\.com$#',
            '#^https://[^/]+\\.mictomonbespoketailor\\.com$#',
            '#^https://[^/]+\\.mictomonbespoketailor\\.net$#',
            '#^https://[^/]+\\.mictomonbespoketailor\\.org$#',
            '#^https://[^/]+\\.mictomonbespoketailor\\.ng$#',
        ],
        array_map('trim', explode(',', env('CORS_ALLOWED_ORIGIN_PATTERNS', '')))
    )),

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
