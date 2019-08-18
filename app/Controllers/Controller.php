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
  * @author		  : <seba.carroza@gmail.cl> - 17/08/2019
  * @return     JSON
  */
  public function info (Request $request, Response $response){
      $info = array("Nombre API" => APP_NAME,
                    "Version API" => VERSION);

      return  $response->withJson($info);
  }

  /**
	* Descripción	: Get todos los players
	* @author		  : <seba.carroza@gmail.cl> - 17/08/2019
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
  /**
  * Descripción	: Get player por codigo
  * @author		  : <seba.carroza@gmail.cl> - 17/08/2019
  * @return     JSON
  */
  public function getPlayerByCodigo(Request $request, Response $response){
    $perm = 1;
    if (PRIVATE_API == 1) {
      $gl_token = $request->getAttribute('gl_token');
      $perm = $this->_DAOApp->getStatusToken($gl_token);
    }
    if($perm){
      $codigo = $request->getAttribute('codigo');
      $player = $this->_DAOPlayer->getPlayerByCodigo($codigo);
      if ($player) {
        return  $response->withJson($player);
      }else{
        $result = array("mensaje" => "No existe player con esa id en la DB.");
        return  $response->withJson($result);
      }
    }else{
      $result = array("mensaje" => "No tienes permisos para ocupar esta api");
      return  $response->withJson($result);
    }
  }
  /**
  * Descripción	: POST crear player
  * @author		  : <seba.carroza@gmail.cl> - 17/08/2019
  * @return     JSON
  */
  public function insertPlayer(Request $request, Response $response){
    $perm = 1;
    if (PRIVATE_API == 1) {
      $gl_token = $request->getAttribute('gl_token');
      $perm = $this->_DAOApp->getStatusToken($gl_token);
    }
    if($perm){
      $codigo = $request->getParam('codigo');
      $player = $this->_DAOPlayer->getPlayerByCodigo($codigo);
      if($player){
        $result = array("mensaje" => "Ya existe este usuario en la DB");
        return  $response->withJson($result);
      }else{
        $nombre = $request->getParam('nombre');
        $equipo = $request->getParam('equipo');
        $params = array("codigo" => $codigo,
                        "nombre" => $nombre,
                        "equipo" => $equipo
                        );
        $last_id = $this->_DAOPlayer->insertPlayer($params);
        if($last_id <> 0){
          $result = array("mensaje" => "Nuevo Player guardado.");
          return  $response->withJson($result);
        }else{
          $result = array("mensaje" => "Problemas con el servidor.");
          return  $response->withJson($result);
        }
      }
    }else{
      $result = array("mensaje" => "No tienes permisos para ocupar esta api");
      return  $response->withJson($result);
    }
  }
  /**
	* Descripción	: PUT modificar player
	* @author		  : <seba.carroza@gmail.cl> - 18/08/2019
	* @return     JSON
	*/
  public function updatePlayer(Request $request, Response $response){
    $perm = 1;
    if (PRIVATE_API == 1) {
      $gl_token = $request->getAttribute('gl_token');
      $perm = $this->_DAOApp->getStatusToken($gl_token);
    }
    if($perm){
      $codigo_up = $request->getAttribute('codigo');
      $player = $this->_DAOPlayer->getPlayerByCodigo($codigo_up);
      if($player){
        $codigo = $request->getParam('codigo');
        if ($codigo_up == $codigo) {
          $result = array("mensaje" => "No se puede modificar el codigo por el mismo.");
          return  $response->withJson($result);
        }else{
          $nombre = $request->getParam('nombre');
          $equipo = $request->getParam('equipo');

          $params = array("codigo_up" => $codigo_up,
                          "codigo"    => $codigo,
                          "nombre"    => $nombre,
                          "equipo"    => $equipo
                          );
          $rowCount = $this->_DAOPlayer->updatePlayer($params);
          if($rowCount <> 0){
            $result = array("mensaje" => "Player Modificado.");
            return  $response->withJson($result);
          }else{
            $result = array("mensaje" => "Problemas con el servidor.");
            return  $response->withJson($result);
          }
        }
      }else{
        $result = array("mensaje" => "No existe player con esa id en la DB.");
        return  $response->withJson($result);
      }

    }else{
      $result = array("mensaje" => "No tienes permisos para ocupar esta api");
      return  $response->withJson($result);
    }
  }
  /**
  * Descripción	: DELETE eliminar player
  * @author		  : <seba.carroza@gmail.cl> - 14/08/2019
  * @return     JSON
  */
  public function delPlayer(Request $request, Response $response){
    $perm = 1;
    if (PRIVATE_API == 1) {
      $gl_token = $request->getAttribute('gl_token');
      $perm = $this->_DAOApp->getStatusToken($gl_token);
    }
    if($perm){
      $codigo = $request->getAttribute('codigo');
      $player = $this->_DAOPlayer->getPlayerByCodigo($codigo);
      if($player){
        $rowCount = $this->_DAOPlayer->delPlayer($codigo);
        if ($rowCount <> 0) {
          $result = array("mensaje" => "Player Eliminado");
          return  $response->withJson($result);
        }else{
          $result = array("mensaje" => "Problemas con el servidor.");
          return  $response->withJson($result);
        }
      }else{
        $result = array("mensaje" => "No existe player con esa id en la DB.");
        return  $response->withJson($result);
      }
    }else{
      $result = array("mensaje" => "No tienes permisos para ocupar esta api");
      return  $response->withJson($result);
    }

  }
}
