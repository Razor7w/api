<?php

namespace App\Models;

class DAOPlayer{

  protected $db;
  protected $table;
  protected $primary_key;

  function __construct(){
    $this->db = $GLOBALS['dbconn'];
    $this->table = TABLA_PLAYER;
    $this->primary_key = "codigo";
  }


  public function getAll(){
      return  $this->db->select(TABLA_PLAYER, '*');
  }

  public function getPlayerByCodigo($codigo){
      return  $this->db-> select(TABLA_PLAYER, '*' ,[ $this->primary_key => $codigo ]);
  }


}
