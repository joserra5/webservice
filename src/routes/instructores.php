<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/instructores', function(Request $request, Response $response){
    //echo "Estudiantes";
    $sql = "select*from instructor";

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
$app->get('/api/instructores/{rfc_instructor}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('rfc_instructor');
    $sql = "SELECT * FROM instructor WHERE rfc_instructor = $nocontrol";
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
// Agregar un instructor
$app->post('/api/instructores/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('rfc_instructor');
    $nombre = $request->getParam('nombre_instructor');
    $apellidop = $request->getParam('apellido_p_instructor');
    $apellidom = $request->getParam('apellido_m_instructor');
    $semestre = $request->getParam('act_complemetaria_clave_act');
    $sql = "INSERT INTO instructor (rfc_instructor, nombre_instructor, apellido_p_instructor, apellido_m_instructor, act_complementaria_clave_act) VALUES (:rfc_instructor, :nombre_instructor, :apellido_p_instructor, :apellido_m_instructor, :act_complementaria_clave_act)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_instructor',      $nocontrol);
        $stmt->bindParam(':nombre_instructor',         $nombre);
        $stmt->bindParam(':apellido_p_instructor',      $apellidop);
        $stmt->bindParam(':apellido_m_instructor',      $apellidom);
        $stmt->bindParam(':act_complementaria_clave_act',       $semestre);
        $stmt->execute();
        echo '{"notice": {"text": "instructor agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/instructores/update/{rfc_instructor}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('rfc_instructor');
    $nombre = $request->getParam('nombre_instructor');
    $apellidop = $request->getParam('apellido_p_instructor');
    $apellidom = $request->getParam('apellido_m_instructor');
    $actividad = $request->getParam('act_complemetaria_clave_act');
    $sql = "UPDATE instructor SET
                rfc_instructor               = :rfc_instructor,
                nombre_instructor       = :nombre_instructor,
                apellido_p_instructor   = :apellido_p_instructor,
                apellido_m_instructor   = :apellido_m_instructor,
                act_complementaria_clave_act                = :act_complementaria_clave_act
            WHERE rfc_instructor = '$nocontrol'";
    echo $actividad;
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rfc_instructor',      $nocontrol);
        $stmt->bindParam(':nombre_instructor',         $nombre);
        $stmt->bindParam(':apellido_p_instructor',      $apellidop);
        $stmt->bindParam(':apellido_m_instructor',      $apellidom);
        $stmt->bindParam(':act_complementaria_clave_act',       $actividad);
        $stmt->execute();
        echo '{"notice": {"text": "instructor actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/instructores/delete/{rfc_instructor}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('rfc_instructor');
    $sql = "DELETE FROM instructor WHERE rfc_instructor = '".$nocontrol."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instructor eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
?>
