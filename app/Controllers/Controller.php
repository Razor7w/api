<?php
namespace App\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class Controller{

  protected $_DAOPlayer;
  protected $_DAOApp;

  public function __construct(){
    $this->_DAOPlayer = new \App\Models\DAOPlayer();
    $this->_DAOApp    = new \App\Models\DAOApp();
  }


  public function info (Request $request, Response $response){

      //var_dump($this->_DAOPlayer->getAll());
      $info = array("Nombre API" => APP_NAME,
                    "Version API" => VERSION);

      return  $response->withJson($info);
  }

  public function getPlayers (Request $request, Response $response){
    $perm = 1;
    if (PRIVATE_API == 1) {
      $gl_token = $request->getAttribute('gl_token');
      $player = $this->_DAOPlayer->getAll();
      return  $response->withJson($player);
    }
  }

}
