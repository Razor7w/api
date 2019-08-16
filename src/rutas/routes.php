<?php
/**
 ******************************************************************************
 * Sistema           : API_GO
 *
 * Descripción       : Aquí se contendrán las rutas
 *
 * Plataforma        : PHP
 *
 * Creación          : 14/08/2019
 *
 * @name             routes.php
 *
 * @version          1.0.0
 *
 * @author			<sebastian.carroza@gmail.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha			Descripción
 * ----------------------------------------------------------------------------
 *
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
 use Psr\Http\Message\ServerRequestInterface as Request;
 use Psr\Http\Message\ResponseInterface as Response;

 $app = new \Slim\App();

  /**
	* Descripción	: Get todos los players
	* @author		  : <sebastian.carroza@gmail.cl> - 14/08/2019
	* @return     JSON
	*/
  $app->get('/player', function(Request $request, Response $response){
    $sql ="SELECT * FROM plaayer";
    try{
      $db = new db();
      $db = $db->connectDB();
      $resultado = $db->query($sql);
      if ($resultado->rowCount() > 0) {
        $players = $resultado->fetchAll(PDO::FETCH_OBJ);
        return  $response->withJson($players);
      }else{
        $result = array("mensaje" => "No existen players en la DB.");
        return  $response->withJson($result);
      }
      $resultado = null;
      $db = null;
    }catch(PDOException $e){
      $result = array("error" => "TEXT: ".$e->getMessage());
      return  $response->withJson($result);
    }
  });

  /**
	* Descripción	: Get player por codigo
	* @author		  : <sebastian.carroza@gmail.cl> - 14/08/2019
	* @return     JSON
	*/
  $app->get('/player/{codigo}', function(Request $request, Response $response){
      $codigo = $request->getAttribute('codigo');
      $sql = "SELECT * FROM player WHERE codigo = $codigo ";
      try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
          $players = $resultado->fetchAll(PDO::FETCH_OBJ);
          return  $response->withJson($players);
        }else{
          $result = array("mensaje" => "No existe player con esa id en la DB.");
          return  $response->withJson($result);
        }
        $resultado = null;
        $db = null;
      }catch(PDOException $e){
        $result = array("error" => "TEXT: ".$e->getMessage());
        return  $response->withJson($result);
      }
  });

  /**
	* Descripción	: POST crear player
	* @author		  : <sebastian.carroza@gmail.cl> - 14/08/2019
	* @return     JSON
	*/
  $app->post('/player/nuevo', function(Request $request, Response $response){
    $codigo = $request->getParam('codigo');
    $nombre = $request->getParam('nombre');
    $equipo = $request->getParam('equipo');
    $sql = "INSERT INTO player (codigo, nombre, equipo) VALUES (:codigo, :nombre, :equipo) ";
    try{
      $db = new db();
      $db = $db->connectDB();
      $resultado = $db->prepare($sql);
      $resultado->bindParam(':codigo', $codigo);
      $resultado->bindParam(':nombre', $nombre);
      $resultado->bindParam(':equipo', $equipo);

      $resultado->execute();

      $result = array("mensaje" => "Nuevo Player guardado.");
      return  $response->withJson($result);

      $resultado = null;
      $db = null;
    }catch(PDOException $e){
      $result = array("error" => "TEXT: ".$e->getMessage());
      return  $response->withJson($result);
    }
  });


  /**
	* Descripción	: PUT modificar player
	* @author		  : <sebastian.carroza@gmail.cl> - 14/08/2019
	* @return     JSON
	*/
    $app->put('/player/modificar/{id}', function(Request $request, Response $response){
      $id_player = $request->getAttribute('id');
      $codigo = $request->getParam('codigo');
      $nombre = $request->getParam('nombre');
      $equipo = $request->getParam('equipo');
      $sql = "UPDATE player
              SET codigo = :codigo,
                  nombre = :nombre,
                  equipo = :equipo
              WHERE id_player = $id_player";
      try{
        $db = new db();
        $db = $db->connectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':codigo', $codigo);
        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':equipo', $equipo);

        $resultado->execute();

        $result = array("mensaje" => "Player modificado.");
        return  $response->withJson($result);

        $resultado = null;
        $db = null;
      }catch(PDOException $e){
        $result = array("error" => "TEXT: ".$e->getMessage());
        return  $response->withJson($result);
      }
    });

    /**
  	* Descripción	: DELETE eliminar player
  	* @author		  : <sebastian.carroza@gmail.cl> - 14/08/2019
  	* @return     JSON
  	*/
      $app->delete('/player/delete/{id}', function(Request $request, Response $response){
        $id_player = $request->getAttribute('id');
        $sql = "DELETE FROM player
                WHERE id_player = $id_player";
        try{
          $db = new db();
          $db = $db->connectDB();
          $resultado = $db->prepare($sql);
          $resultado->execute();

          if ($resultado->rowCount() > 0) {
            $result = array("mensaje" => "Player eliminado.");
            return  $response->withJson($result);
          }else{
            $result = array("mensaje" => "No existe Player con esa id.");
            return  $response->withJson($result);
          }

          $resultado = null;
          $db = null;
        }catch(PDOException $e){
          $result = array("error" => "TEXT: ".$e->getMessage());
          return  $response->withJson($result);
        }
      });

      /**
    	* Descripción	: Get todos los players
    	* @author		  : <sebastian.carroza@gmail.cl> - 14/08/2019
    	* @return     JSON
    	*/
      $app->get('/info', function(Request $request, Response $response){
          $info = array("Nombre API" => APP_NAME,
                        "Version API" => VERSION);

          return  $response->withJson($info);
      });

      /**
    	* Descripción	: Validar Acceso
    	* @author		  : <sebastian.carroza@gmail.cl> - 14/08/2019
    	* @return     JSON
    	*/
      $app->get('/statuskey/{gl_key}', function(Request $request, Response $response){
        $gl_key = $request->getAttribute('gl_key');
        $sql = "SELECT bo_estado FROM app WHERE gl_key = '$gl_key' ";
        try{
          $db = new db();
          $db = $db->connectDB();
          $resultado = $db->query($sql);
          if ($resultado->rowCount() > 0) {
            $app = $resultado->fetchAll(PDO::FETCH_OBJ);
            if ($app[0]->bo_estado == 1) {
              $result = array('bo_estado' => true, 'existe' => true);
              return  $response->withJson($result);
            }else{
              $result = array('bo_estado' => false, 'existe' => true);
              return  $response->withJson($result);
            }
          }else{
            $result = array('bo_estado' => false,'existe' => false);
            return  $response->withJson($result);
          }
          $resultado = null;
          $db = null;
        }catch(PDOException $e){
          $result = array("error" => "TEXT: ".$e->getMessage());
          return  $response->withJson($result);
        }

      });
