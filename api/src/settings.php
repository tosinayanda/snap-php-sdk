<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
        // database connection details         
        "db" => [            
            "host" => "your-host",             
            "dbname" => "your-database-name",             
            "user" => "your-db-username",            
            "pass" => "your-db-password"        
        ],
        //JWT settings
        "jwt" => [
            'secret' => 'O5NVZ3ohjk9tGVlNjxv8fBnNU2KI4kBWbamt24mtYzpZ8p+9n1QUsLRvKD0FK1k0imgODRPSfC7lWSXk9n2YTw=='
        ],
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
