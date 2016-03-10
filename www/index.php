<?php
// Load application config (error reporting, database credentials etc.)
require_once '../application/config/config.php';
// The auto-loader to load the php-login related internal stuff automatically
require '../application/config/autoload.php';

$router = new Route(); // запускаем маршрутизатор
