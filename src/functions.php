<?php

function getStatusKey($gl_token){

  $sql = "SELECT bo_estado FROM app WHERE gl_token = '$gl_token' ";

  try{
    $db = new db();
    $db = $db->connectDB();
    $resultado = $db->query($sql);
    if ($resultado->rowCount() > 0) {
      $app = $resultado->fetchAll(PDO::FETCH_OBJ);
      if ($app[0]->bo_estado == 1) {
        return  true;
      }else{
        return false;
      }
    }else{
      return false;
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    return $result = array("error" => "TEXT: ".$e->getMessage());
  }
}

 ?>
