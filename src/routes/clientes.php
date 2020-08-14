<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET todos los clients
$app->get('/api/clientes', function (Request $request, Response $response) {
    $sql = "SELECT * FROM clientes";
    try {
        $db = new Database();
        $db = $db->dbConnection();
        $result = $db->query($sql);
        if ($result->rowCount() > 0) {
            $clientes = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($clientes);
        } else {
            echo json_encode("No existen clientes en la BBDD.");
        }
        $result = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error": {"text":"' . ($e->getMessage()  ) . '"}}';
    }
});

// GET recuperar clientes por ID 
$app->get('/api/clientes/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM clientes WHERE id = $id";
    try {
        $db = new database();
        $db = $db->dbConnection();
        $result = $db->query($sql);

        if ($result->rowCount() > 0) {
            $cliente = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($cliente);
        } else {
            echo json_encode("No existen cliente en la BBDD con este ID.");
        }
        $result = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text":' . ($e->getMessage()) . '}';
    }
});

// POST crear un nuevo cliente 
$app->post('/api/clientes/nuevo', function (Request $request, Response $response) {
    $nombre = $request->getParam('nombre');
    $apellidos = $request->getParam('apellidos');
    $telefono = $request->getParam('telefono');
    $email = $request->getParam('email');
    $direccion = $request->getParam('direccion');
    $ciudad = $request->getParam('ciudad');

    $sql = "INSERT INTO clientes 
        (nombre, apellidos, telefono, email, direccion, ciudad) VALUES 
        (:nombre, :apellidos, :telefono, :email, :direccion, :ciudad)";
    try {
        $db = new Database();
        $db = $db->dbConnection();
        $result = $db->prepare($sql);

        $result->bindParam(':nombre', $nombre);
        $result->bindParam(':apellidos', $apellidos);
        $result->bindParam(':telefono', $telefono);
        $result->bindParam(':email', $email);
        $result->bindParam(':direccion', $direccion);
        $result->bindParam(':ciudad', $ciudad);

        $result->execute();
        echo json_encode("Nuevo cliente guardado.");

        $result = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text":' . ($e->getMessage()) . '}';
    }
});

// PUT actualizar un cliente 
$app->put('/api/clientes/modificar/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $nombre = $request->getParam('nombre');
    $apellidos = $request->getParam('apellidos');
    $telefono = $request->getParam('telefono');
    $email = $request->getParam('email');
    $direccion = $request->getParam('direccion');
    $ciudad = $request->getParam('ciudad');

    $sql = "UPDATE clientes SET
        nombre = :nombre,
        apellidos = :apellidos,
        telefono = :telefono,
        email = :email,
        direccion = :direccion,
        ciudad = :ciudad
        WHERE id = $id";

    try {
        $db = new Database();
        $db = $db->dbConnection();
        $result = $db->prepare($sql);

        $result->bindParam(':nombre', $nombre);
        $result->bindParam(':apellidos', $apellidos);
        $result->bindParam(':telefono', $telefono);
        $result->bindParam(':email', $email);
        $result->bindParam(':direccion', $direccion);
        $result->bindParam(':ciudad', $ciudad);

        $result->execute();
        echo json_encode("Cliente modificado.");

        $result = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text":' . ($e->getMessage()) . '}';
    }
});

// DELETE borrar cliente 
$app->delete('/api/clientes/delete/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM clientes WHERE id = $id";

    try {
        $db = new Database();
        $db = $db->dbConnection();
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount() > 0) {
            echo json_encode("Cliente eliminado.");
        } else {
            echo json_encode("No existe cliente con este ID.");
        }

        $result = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" : {"text":' . ($e->getMessage()) . '}';
    }
});
