<?php
if (!isset($_SESSION['user_logged_in'])) {
    Session::destroy();
    echo 'TODO: Вывод экрана запроса авторизации';
} else {
    echo 'TODO: Вывод основной информации';
}