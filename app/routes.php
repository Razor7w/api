<?php


$app->get('/', 'Controller:info');

$app->get('/{gl_token}/player', 'Controller:getPlayers');

$app->get('/{gl_token}/player/{codigo}', 'Controller:getPlayerByCodigo');
