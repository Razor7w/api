<?php
use Medoo\Medoo;

$dbconn = new Medoo([
  'database_type' => 'mysql',
  'database_name' => 'apirest',
  'server' => 'localhost',
  'username' => 'root',
  'password' => '',
]);
