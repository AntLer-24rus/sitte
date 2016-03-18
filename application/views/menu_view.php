<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 18.03.16
 * Time: 13:40
 */
$tabs = array(
    "Главная" => "/main",
    "Все" => "/all",
    "На день" => "/day",
    "На неделю" => "/week"
);

foreach ($tabs as $name => $url) {
    echo '<li>';
    echo '<a href="' . $url . ($_SERVER['REQUEST_URI'] == $url ? '" class="selected">' : '">') . $name . '</a>';
    echo '</li>';
}

$private_tabs = array(
    "Счета" => "/invoices"
);

if ($this->controller->session->isLogin()) {
    foreach ($private_tabs as $name => $url) {
        if ($this->controller->session->verifyUserPermission(substr($url, 1))) {
            echo '<li>';
            echo '<a href="' . $url . ($_SERVER['REQUEST_URI'] == $url ? '" class="selected">' : '">') . $name . '</a>';
            echo '</li>';
        }
    }
}