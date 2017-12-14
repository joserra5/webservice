<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/trabajador', function(Request $request, Response $response){
    //echo "Estudiantes";
    $sql = "select*from trabajador";

    try{
        //Get DB Object
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiantes);
    } catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});
// Obtener un estudiante por no de control
$app->get('/api/trabajador/{rfc_trabajador}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('rfc_trabajador');
    $sql = "SELECT * FROM trabajador WHERE rfc_trabajador = $nocontrol";
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
$app->post('/api/trabajador/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('rfc_trabajador');
    $nombre = $request->getParam('nombre_trabajador');
    $apellidop = $request->getParam('apellido_p');
    $apellidom = $request->getParam('apellido_m');
    $semestre = $request->getParam('clave_presupuestal');
    $sql = "INSERT INTO trabajador (rfc_trabajador, nombre_trabajador, apellido_p, apellido_m, clave_presupuestal) VALUES (:rfc_trabajador, :nombre_trabajador, :apellido_p, :apellido_m, :clave_presupuestal)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_trabajador',      $nocontrol);
        $stmt->bindParam(':nombre_trabajador',         $nombre);
        $stmt->bindParam(':apellido_p',      $apellidop);
        $stmt->bindParam(':apellido_m',      $apellidom);
        $stmt->bindParam(':clave_presupuestal',       $semestre);
        $stmt->execute();
        echo '{"notice": {"text": "trabajador agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/trabajador/update/{rfc_trabajador}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('rfc_trabajador');
    $nombre = $request->getParam('nombre_trabajador');
    $apellidop = $request->getParam('apellido_p');
    $apellidom = $request->getParam('apellido_m');
    $semestre = $request->getParam('clave_presupuestal');
   $sql = "UPDATE estudiante SET
                rfc_trabajador     = :rfc_trabajador,
                nombre_trabajador  = :nombre_trabajador,
                apellido_p  = :apellido_p,
                apellido_m   = :apellido_m,
                clave_presupuestal   = :clave_presupuestal,
           WHERE rfc_trabajador = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_trabajador',      $nocontrol);
        $stmt->bindParam(':nombre_trabajador',         $nombre);
        $stmt->bindParam(':apellido_p',      $apellidop);
        $stmt->bindParam(':apellido_m',      $apellidom);
        $stmt->bindParam(':clave_presupuestal',       $semestre);
        $stmt->execute();
        echo '{"notice": {"text": "trabajador actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/trabajador/delete/{rfc_trabajador}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('rfc_trabajador');
    $sql = "DELETE FROM trabajador WHERE rfc_trabajador = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "trabajador eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
?>