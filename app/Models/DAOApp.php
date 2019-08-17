<?php

namespace App\Models;

class DAOApp{

  protected $db;

  function __construct(){
    $this->db = $GLOBALS['dbconn'];
  }


  public function getAll(){
      return  $this->db->select('app', '*');
  }


}
