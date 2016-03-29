<?php
$tabs = array(
    "Главная" => "/main",
    "Все" => "/all",
//    "На день" => "/day",
//    "На неделю" => "/week"
);

foreach ($tabs as $name => $url) {
    echo '<li>';
    echo '<a href="' . $url . (strpos($_SERVER['REQUEST_URI'], $url) === false ? '">' : '" class="selected">') . $name . '</a>';
    echo '</li>';
}

$private_tabs = array(
    "Счета" => "/invoices"
);

//if ($this->controller->session->isLogin()) {
    foreach ($private_tabs as $name => $url) {
        if ($this->controller->session->verifyUserPermission($url) | !(strpos($_SERVER['REQUEST_URI'], $url) === false)) {
            echo '<li>';
            echo '<a href="' . $url . (strpos($_SERVER['REQUEST_URI'], $url) === false ? '">' : '" class="selected">') . $name . '</a>';
            echo '</li>';
        }
    }
//}