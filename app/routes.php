<?php


$app->get('/', 'Controller:info');

$app->get('/{gl_token}/player', 'Controller:getPlayers');

$app->get('/{gl_token}/player/nuevo', 'Controller:insertPlayer');

$app->put('/{gl_token}/player/modificar/{codigo}', 'Controller:updatePlayer');

$app->post('/{gl_token}/player/{codigo}', 'Controller:getPlayerByCodigo');
