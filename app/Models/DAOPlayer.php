<?php

namespace App\Models;

class DAOPlayer{

  protected $db;

  function __construct(){
    $this->db = $GLOBALS['dbconn'];
  }


  public function getAllPlayer(){
      return  $this->db->select('player', '*');
  }


}
