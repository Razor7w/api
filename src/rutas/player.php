<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET Todos los Players
  $app->get('/api/player', function(Request $request, Response $response){
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

  // GET player por codigo
    $app->get('/api/player/{codigo}', function(Request $request, Response $response){
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

    // POST crear player
      $app->post('/api/player/nuevo', function(Request $request, Response $response){
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

      // PUT modificar player
        $app->put('/api/player/modificar/{id}', function(Request $request, Response $response){
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

        // DELETE eliminar player
          $app->delete('/api/player/delete/{id}', function(Request $request, Response $response){
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