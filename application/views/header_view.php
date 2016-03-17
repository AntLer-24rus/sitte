<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Управление деньгами</title>
    <link rel='icon' href='favicon.ico' type='image/x-icon'>
    <link rel='shortcut icon' href='favicon.ico' type='image/x-icon'>
    <link rel="stylesheet" type="text/css" href="/css/styleMy.css"/>
    <link rel="stylesheet" type="text/css" href="/css/bar.css"/>
    <link rel="stylesheet" type="text/css" href="/css/google_buttones.css"/>

    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/js-sha256.js"
    <script type="text/javascript" src="http://point-at-infinity.org/jsaes/jsaes.js"></script>
    <script type="text/javascript" src="/js/AES-JS.js"></script>
    <script type="text/javascript" src="/js/md5.js"></script>
</head>
<body>
<div id="bar">
    <div class="logo_container">
        <div class="logo">
            <a href="<?php echo URL;?>" title="Главная страница">
                <img width="225" height="60" src="/images/camomile-flowers.png" alt="Chamaemelon">
            </a>
        </div>
        <div id="menu" style="align-self: flex-end">
            <ul class="menu">
                <?php
                $tabs = json_decode(str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', file_get_contents("../application/config/site_map")), true);
                foreach ($tabs as $key => $value) {
                    if ($this->controller->session->userLoggedIn) {
                        echo '<li>';
                        echo '<a href="' . $value . ($_SERVER['REQUEST_URI'] == $value ? '" class="selected">' : '">') . $key . '</a>';
                        echo '</li>';
                    }

                }


                ?>
                <!--                --><?php
                //                if (isset($_SESSION['user_logged_in'])) {
                //                    echo '<li><a href="/range"';
                //                    echo $_SERVER['REQUEST_URI'] == '/range' ? "class=\"selected\"" : "";
                //                    echo '>В диапазоне</a></li>';
                //                }
                //                ?>
            </ul>
        </div>
    </div>
    <div class="userpic">
        <?php
        if (Session::get('user_logged_in')) {
            include 'userinfo_view.php';
        } else {
            include 'login_view.php';
        }
        ?>

    </div>
</div>
<div id="wrapper">

    <div id="page">
<!--   Продолжение в файле footer.php     -->