<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/instituto', function(Request $request, Response $response){
    //echo "Estudiantes";
    $sql = "select*from instituto";

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
$app->get('/api/instituto/{clave_instituto}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('clave_carrera');
    $sql = "SELECT * FROM instituto WHERE clave_instituto = $nocontrol";
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
    $nocontrol = $request->getParam('clave_instituto');
    $nombre = $request->getParam('nombre_instituto');
    $sql = "INSERT INTO clave_instituto (clave_instituto, nombre_instituto) VALUES (:clave_instituto, :nombre_instituto)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_instituto',      $nocontrol);
        $stmt->bindParam(':nombre_instituto',         $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "instituto agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/instituto/update/{clave_instituto}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('clave_instituto');
    $nombre = $request->getParam('nombre_instituto');
    $sql = "UPDATE instructor SET
                clave_instituto               = :clave_instituto,
                nombre_instituto       = :nombre_instituto,
            WHERE clave_instituto = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_instituto',      $nocontrol);
        $stmt->bindParam(':nombre_instituto',         $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "instituto actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/instituto/delete/{clave_instituto}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('clave_instituto');
    $sql = "DELETE FROM instituto WHERE clave_instituto = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
?>