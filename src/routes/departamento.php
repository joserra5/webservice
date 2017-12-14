<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/departamento', function(Request $request, Response $response){
    //echo "Estudiantes";
    $sql = "select*from departamento";

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
$app->get('/api/departamento/{rfc_departamento}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('rfc_departamento');
    $sql = "SELECT * FROM departamento WHERE rfc_departamento = $nocontrol";
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
$app->post('/api/departamento/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('rfc_departamento');
    $nombre = $request->getParam('nombre_departamento');
    $apellidop = $request->getParam('trabajador_rfc');
    $sql = "INSERT INTO departamento (rfc_departamento, nombre_departamento, trabajador_rfc) VALUES (:rfc_departamento, :nombre_departamento, :trabajador_rfc)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_departamento',      $nocontrol);
        $stmt->bindParam(':nombre_departamento',         $nombre);
        $stmt->bindParam(':trabajador_rfc',      $apellidop);
        $stmt->execute();
        echo '{"notice": {"text": "departamento agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/departamento/update/{rfc_departamento}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('rfc_departamento');
    $nombre = $request->getParam('nombre_departamento');
    $apellidop = $request->getParam('trabajador_rfc');
    $sql = "UPDATE departamento SET
                rfc_departamento               = :rfc_departamento,
                nombre_departamento       = :nombre_departamento,
                trabajador_rfc          = :trabajador_rfc,
             WHERE rfc_departamento = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_departamento',      $nocontrol);
        $stmt->bindParam(':nombre_departamento',         $nombre);
        $stmt->bindParam(':trabajador_rfc',      $apellidop);
        $stmt->execute();
        echo '{"notice": {"text": "departamento actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/departamneto/delete/{rfc_departamento}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('rfc_departamento');
    $sql = "DELETE FROM departamento WHERE rfc_departamento = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
?>