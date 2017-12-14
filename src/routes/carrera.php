<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/carrera', function(Request $request, Response $response){
    //echo "Estudiantes";
    $sql = "select*from carrera";

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
$app->get('/api/estudiantes/{clave_carrera}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('clave_carrera');
    $sql = "SELECT * FROM carrera WHERE clave_carrera = $nocontrol";
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
$app->post('/api/carrera/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('clave_carrera');
    $nombre = $request->getParam('nombre_carrera');
    $sql = "INSERT INTO carrera (clave_carrera, nombre_carrera) VALUES (:clave_carrera, :nombre_carrera)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_carrera',      $nocontrol);
        $stmt->bindParam(':nombre_carrera',         $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "carrera agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/carrera/update/{clave_carrera}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('clave_carrera');
    $nombre = $request->getParam('nombre_carrera');
    $sql = "UPDATE carrera SET
                clave_carrera               = :clave_carrera,
                nombre_carrera       = :nombre_carrera,
            WHERE clave_carrera = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_carrera',      $nocontrol);
        $stmt->bindParam(':nombre_carrera',         $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "carrera actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/carrera/delete/{clave_carrera}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('clave_carrera');
    $sql = "DELETE FROM carrera WHERE clave_carrera = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "carrera eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
?>
