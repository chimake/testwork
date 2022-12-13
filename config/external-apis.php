<?php

return [
    'inforu' => [
        'service_enabled' => env('INFORU_SERVICE_ENABLED', false),
        'login' => env('INFORU_LOGIN'),
        'api_token' => env('INFORU_API_TOKEN'),
        'sender_name' => env('INFORU_SENDER_NAME'),
        'xml_endpoint' => 'https://uapi.inforu.co.il/SendMessageXml.ashx'
    ],
];