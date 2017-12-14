<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/estudiantes', function(Request $request, Response $response){
  //echo "Estudiantes";
  $sql = "select*from estudiante";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($estudiante);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});


// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');
    $sql = "SELECT * FROM estudiante WHERE No_control = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('No_control');
    $nombre = $request->getParam('nombre_estudiante');
    $apellidop = $request->getParam('apellido_p_estudiante');
    $apellidom = $request->getParam('apellido_m_estudiante');
    $semestre = $request->getParam('semestre');
    $clave_carrera = $request->getParam('carrera_clave');
    $sql = "INSERT INTO estudiante (No_control, nombre_estudiante, apellido_p_estudiante, apellido_m_estudiante, semestre, carrera_clave) VALUES (:No_control, :nombre_estudiante, :apellido_p_estudiante, :apellido_m_estudiante, :semestre, :carrera_clave)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':No_control',      $nocontrol);
        $stmt->bindParam(':nombre_estudiante',         $nombre);
        $stmt->bindParam(':apellido_p_estudiante',      $apellidop);
        $stmt->bindParam(':apellido_m_estudiante',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $clave_carrera);
        $stmt->execute();
        echo '{"notice": {"text": "Estudiante agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/estudiantes/update/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('No_control');
    $nombre = $request->getParam('nombre_estudiante');
    $apellidop = $request->getParam('apellido_p_estudiante');
    $apellidom = $request->getParam('apellido_m_estudiante');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');
    $sql = "UPDATE estudiante SET
                No_control               = :No_control,
                nombre_estudiante       = :nombre_estudiante,
                apellido_p_estudiante   = :apellido_p_estudiante,
                apellido_m_estudiante   = :apellido_m_estudiante,
                semestre                = :semestre,
                carrera_clave           = :carrera_clave
            WHERE No_control = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':No_control',      $nocontrol);
        $stmt->bindParam(':nombre_estudiante',         $nombre);
        $stmt->bindParam(':apellido_p_estudiante',      $apellidop);
        $stmt->bindParam(':apellido_m_estudiante',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);
        $stmt->execute();
        echo '{"notice": {"text": "Estudiante actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/estudiantes/delete/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');
    $sql = "DELETE FROM estudiante WHERE No_control = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

 ?>
