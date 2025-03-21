<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    public static function route(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // for routing purposes, we only need the path part of the URI
        switch ($uri) {
            case '/':
                require __DIR__ . '/../Controllers/BillingController.php';
                break;
            default:
                header("HTTP/1.1 404 Not Found");
                echo "404 - Page Not Found";
                break;
        }
    }
}
