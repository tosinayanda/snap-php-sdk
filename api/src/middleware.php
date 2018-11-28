<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(new Tuupola\Middleware\CorsMiddleware);

$app->add(new \Tuupola\Middleware\JwtAuthentication([
    "path" => ["/api", "/admin"],
    "ignore" => ["/api/token", "/admin/ping"],
    "attribute" => "decoded_token_data",
    "secure" => true,
    "relaxed" => ["localhost", "snapapi.test"],
    "secret" => "O5NVZ3ohjk9tGVlNjxv8fBnNU2KI4kBWbamt24mtYzpZ8p+9n1QUsLRvKD0FK1k0imgODRPSfC7lWSXk9n2YTw==",
    "algorithm" => ["HS256"],
    "error" => function ($response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));
