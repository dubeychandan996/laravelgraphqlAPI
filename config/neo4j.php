<?php

return [
    'connection' => [
        'uri' => env('NEO4J_URI', 'neo4j://localhost:7687'),
        'user' => env('NEO4J_USER', 'neo4j'),
        'password' => env('NEO4J_PASSWORD', 'h6u4%krd'),
    ],
];
