<?php

namespace App\Models;

class DAOApp{

  protected $db;
  protected $table;
  protected $primary_key;

  function __construct(){
    $this->db = $GLOBALS['dbconn'];
    $this->table = TABLA_APP;
    $this->primary_key = "gl_token";
  }


  public function getAll(){
      return  $this->db->select(TABLA_APP, '*');
  }

  public function getStatusToken($gl_token){
    return  $this->db-> select(TABLA_APP, 'gl_nombre' ,  ["AND" => ["gl_token" => $gl_token, "bo_estado" => 1]] );
  }


}
