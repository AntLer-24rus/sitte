<?php
if (isset($_GET["file_path"])) {
    if (file_exists("../" . $_GET["file_path"])) {
        $file = file_get_contents("../" . $_GET["file_path"]);
        if (!$file) {
            http_response_code(404);
            die();
        } else {
            echo $file;
            die();
        }
    } else {
        http_response_code(404);
        die();
    }
}
// Load application config (error reporting, database credentials etc.)
require_once '../application/config/config.php';
// The auto-loader to load the php-login related internal stuff automatically
require '../application/config/autoload.php';

$router = new Route(); // запускаем маршрутизатор
