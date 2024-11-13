<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_origins' => ['http://localhost:3000'], // Allowing your Next.js frontend origin

    'allowed_methods' => ['*'], // Allowing all HTTP methods (GET, POST, etc.)

    'allowed_headers' => ['*'], // Allowing all headers

    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,

];
