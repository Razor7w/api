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
    $sql ="SELECT * FROM player";
    try{
      $db = new db();
      $db = $db->connectDB();
      $resultado = $db->query($sql);
      if ($resultado->rowCount() > 0) {
        $players = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($players);
      }else{
        echo json_encode("No existen players en la DB.");
      }
      $resultado = null;
      $db = null;
    }catch(PDOException $e){
      echo '{"error" : {"text":'.$e->getMessage().'}}';
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
          echo json_encode($players);
        }else{
          echo json_encode("No existe player con esa id en la DB");
        }
        $resultado = null;
        $db = null;
      }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}}';
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

      echo json_encode("Nuevo Player guardado");

      $resultado = null;
      $db = null;
    }catch(PDOException $e){
      echo '{"error" : {"text":'.$e->getMessage().'}}';
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

        echo json_encode("Player modificado");

        $resultado = null;
        $db = null;
      }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}}';
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
            echo json_encode("Player eliminado");
          }else{
            echo json_encode("No existe Player con esa id");
          }

          $resultado = null;
          $db = null;
        }catch(PDOException $e){
          echo '{"error" : {"text":'.$e->getMessage().'}}';
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
          echo json_encode($info);
      });
