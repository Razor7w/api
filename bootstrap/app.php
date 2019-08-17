<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/app_const.php';
require __DIR__ . '/../app/dbconnect.php';

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
