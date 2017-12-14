        <?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/compementaria', function(Request $request, Response $response){
    //echo "Estudiantes";
    $sql = "select*from complementaria";

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
$app->get('/api/complementaria/{clave_act}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('clave_act');
    $sql = "SELECT * FROM complementaria WHERE clave_act = $nocontrol";
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
$app->post('/api/complementaria/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('clave_act');
    $nombre = $request->getParam('nombre_complementarias');
    $sql = "INSERT INTO clave_act (clave_act, nombre_complementarias) VALUES (:clave_act, :nombre_complementarias)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_act',      $nocontrol);
        $stmt->bindParam(':nombre_complementarias',         $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "complementaria agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/complementaria/update/{clave_act}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('clave_carrera');
    $nombre = $request->getParam('nombre_complementarias');
    $sql = "UPDATE instructor SET
                clave_act         = :clave_act,
                nombre_complementarias   = :nombre_complementarias,
            WHERE clave_act = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_act',      $nocontrol);
        $stmt->bindParam(':nombre_complementarias',         $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "complementaria actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/complementaria/delete/{clave_act}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('clave_act');
    $sql = "DELETE FROM complementaria WHERE clave_act = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "complementaria eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
?>