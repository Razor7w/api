<?php


/*$app->get('/home', function (){
  return 'Home';
});*/

$app->get('/', 'Controller:info');

$app->get('/{gl_token}/player', 'Controller:getPlayers');
