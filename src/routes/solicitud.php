<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/solicitud', function(Request $request, Response $response){
    //echo "Estudiantes";
    $sql = "select*from solicitud";

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
$app->get('/api/solicitud/{folio}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('folio');
    $sql = "SELECT * FROM solicitud WHERE folio = $nocontrol";
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
$app->post('/api/solicitud/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('folio');
    $nombre = $request->getParam('asunto');
    $apellidop = $request->getParam('fecha');
    $apellidom = $request->getParam('lugar');
    $semestre = $request->getParam('instituto_clave');
    $clave_carrera = $request->getParam('instructor_rfc');
    $estudianteNoc = $request->getParam('estudiante_No_contro')
    $sql = "INSERT INTO solicitud (folio, asunto, fecha, lugar, instituto_clave, instructor_rfc, estudiante_No_contro) VALUES (:folio, :asunto, :fecha, :lugar, :instituto_clave, :instructor_rfc, :estudiante_No_contro)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':folio',      $nocontrol);
        $stmt->bindParam(':asunto',         $nombre);
        $stmt->bindParam(':fecha',      $apellidop);
        $stmt->bindParam(':lugar',      $apellidom);
        $stmt->bindParam(':instituto_clave',       $semestre);
        $stmt->bindParam(':instructor_rfc',  $clave_carrera);
        $stmt->bindParam(':estudiante_No_contro',  $estudianteNoc);
        $stmt->execute();
        echo '{"notice": {"text": "solicitud agregada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/solicitud/update/{folio}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('folio');
    $nombre = $request->getParam('asunto');
    $apellidop = $request->getParam('fecha');
    $apellidom = $request->getParam('lugar');
    $semestre = $request->getParam('instituto_clave');
    $carrera_clave = $request->getParam('instructor_clave');
    $estudianteNoc = $request->getParam('estudiante_No_contro');
    $sql = "UPDATE solicitud SET
                folio        = :folio,
                asunto       = :asunto,
                fecha   = :fecha,
                lugar   = :lugar,
                instituto_clave    = :instituto_clave,
                instructor_rfc      = :instructor_clave,
                estudiante_No_contro  = :estudiante_No_contro,
            WHERE folio = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':folio',      $nocontrol);
        $stmt->bindParam(':asunto',         $nombre);
        $stmt->bindParam(':fecha',      $apellidop);
        $stmt->bindParam(':lugar',      $apellidom);
        $stmt->bindParam(':instituto_clave',       $semestre);
        $stmt->bindParam(':instructor_rfc',  $carrera_clave);
        $stmt->bindParam(':estudiante_No_contro',  $estudianteNoc);
        $stmt->execute();
        echo '{"notice": {"text": "solicitud actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/solicitud/delete/{folio}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('folio');
    $sql = "DELETE FROM solicitud WHERE folio = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "solicitud eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
?>