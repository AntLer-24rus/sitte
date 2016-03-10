<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Управление деньгами</title>

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
            <a href="http://chamaemelon.ru" title="Главная страница">
                <img width="225" height="60" src="/images/camomile-flowers.png" alt="Chamaemelon">
            </a>
        </div>
        <div id="menu" style="align-self: flex-end">
            <ul class="menu">
                <li><a href="/main" <?php echo $_SERVER['REQUEST_URI'] == '/main' ?  "class=\"selected\"" : "" ?>>Главная</a></li>
                <li><a href="/all" <?php echo $_SERVER['REQUEST_URI'] == '/all' ?  "class=\"selected\"" : "" ?>>Все</a></li>
                <li><a href="/day" <?php echo $_SERVER['REQUEST_URI'] == '/day' ?  "class=\"selected\"" : "" ?>>На день</a></li>
                <li><a href="/week" <?php echo $_SERVER['REQUEST_URI'] == '/week' ?  "class=\"selected\"" : "" ?>>На неделю</a></li>
                <?php
                if (isset($_SESSION['user_logged_in'])) {
                    echo '<li><a href="/range"';
                    echo $_SERVER['REQUEST_URI'] == '/range' ? "class=\"selected\"" : "";
                    echo '>В диапазоне</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="userpic">
        <?php
        if (!isset($_SESSION['user_logged_in'])) {
            include 'login_view.php';
        } else {
            include 'userinfo_view.php';
        }
        ?>

    </div>
</div>
<div id="wrapper">

    <div id="page">
<!--   Продолжение в файле footer.php     -->