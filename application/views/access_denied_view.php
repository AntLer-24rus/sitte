<?php
if ($this->controller->session->isLogin()) {
    echo '<h3 style="padding: 20px 0; text-align: center">У вас нет прав доступа к данной странице</h3>';
} else {
    echo '<h3 style="padding: 20px 0; text-align: center">Для доступа к данной странице необходимо авторизоваться</h3>';
}