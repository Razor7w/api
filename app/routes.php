<?php


$app->get('/', 'Controller:info');

$app->get('/{gl_token}/player', 'Controller:getPlayers');

$app->post('/{gl_token}/player/nuevo', 'Controller:insertPlayer');

$app->put('/{gl_token}/player/modificar/{codigo}', 'Controller:updatePlayer');

$app->delete('/{gl_token}/player/delete/{codigo}', 'Controller:delPlayer');

$app->get('/{gl_token}/player/{codigo}', 'Controller:getPlayerByCodigo');
