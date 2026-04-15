<?php
$routes = [
    'login' => ['user_controller', 'login'],
];

if(isset($_GET["path"])) {
    $path = $_GET["path"];
    [$controller_name, $method] = $routes[$path];
    require $_SERVER['DOCUMENT_ROOT']."/Orbit/src/controller/$controller_name.php";
    $controller_name = "$controller_name\\$controller_name";
    $controller = new $controller_name();
    $controller->$method();
} else {
    http_response_code(404);
}
?>