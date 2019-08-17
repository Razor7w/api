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

  /**
  * Descripción	: Get Info Api
  * @author		  : <sebastian.carroza@gmail.cl> - 17/08/2019
  * @return     JSON
  */
  public function info (Request $request, Response $response){
      $info = array("Nombre API" => APP_NAME,
                    "Version API" => VERSION);

      return  $response->withJson($info);
  }

  /**
	* Descripción	: Get todos los players
	* @author		  : <sebastian.carroza@gmail.cl> - 17/08/2019
	* @return     JSON
	*/
  public function getPlayers (Request $request, Response $response){
    $perm = 1;
    if (PRIVATE_API == 1) {
      $gl_token = $request->getAttribute('gl_token');
      $perm = $this->_DAOApp->getStatusToken($gl_token);
    }
    if ($perm){
      $players = $this->_DAOPlayer->getAll();
      if ($players){
        return  $response->withJson($players);
      }else{
        $result = array("mensaje" => "No existen players en la DB.");
        return  $response->withJson($result);
      }
    }else{
      $result = array("mensaje" => "No tienes permisos para ocupar esta api");
      return  $response->withJson($result);
    }
  }

}
