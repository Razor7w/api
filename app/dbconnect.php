<?php
use Medoo\Medoo;

$dbconn = new Medoo([
  'database_type' => DATABASE_TYPE,
  'database_name' => DATABASE_NAME,
  'server' => SERVER,
  'username' => USERNAME,
  'password' => PASSWORD,
]);
