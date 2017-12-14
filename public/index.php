<?php
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	require '../vendor/autoload.php';
    require '../src/config/db.php';

	$app = new \Slim\App;
	$app->get('/hello/{name}', function(Request $request, Response $response) {
		$name = $request->getAttribute('name');
		$response->getBody()->write("Hello, $name");

		return $response;
	});


	require '../src/routes/estudiantes.php';
    require '../src/routes/instructores.php';
    //require '../src/routes/carrera.php';
    //require '../src/routes/departamento.php';
    //require '../src/routes/instituto.php';
    //require '../src/routes/solicitud.php';
    //require '../src/routes/trabajador.php';
    //require '../src/routes/complementaria.php';
	$app->run();
