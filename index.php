<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/config/app_config.php';
require __DIR__ . '/src/config/db.php';

$app = new \Slim\App();

// Ruta Player
require __DIR__ . '/src/rutas/routes.php';


$app->run();
