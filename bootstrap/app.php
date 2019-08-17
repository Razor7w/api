<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/dbconnect.php';
//require __DIR__ . '/../src/config/app_config.php';
//require __DIR__ . '/../src/config/db.php';

// Ruta Player
//require __DIR__ . '/../src/rutas/routes.php';
//Inicializar player
/*$player = new \App\Models\Player;
var_dump($player);
die();*/

 $app = new \Slim\App([
   'settings' => [
     'displayErrorDetails' => true,
   ]
 ]);

$container = $app->getContainer();

$container['Controller'] = function ($container){
  return new \App\Controllers\Controller;
};

require __DIR__ . '/../app/routes.php';
