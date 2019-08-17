<?php
namespace App\Controllers;

class Controller{

  protected $_DAOPlayer;
  public function __construct(){
    $this->_DAOPlayer = new \App\Models\DAOPlayer();
  }

  public function index ($request, $response){

      var_dump($this->_DAOPlayer->getAllPlayer());
      //return  'Home Controller';
  }

}
