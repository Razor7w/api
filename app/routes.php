<?php


/*$app->get('/home', function (){
  return 'Home';
});*/

$app->get('/', 'HomeController:index');
