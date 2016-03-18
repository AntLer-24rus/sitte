<?php

/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 16:41
 */
class View
{
    /**
     * Связь с контроллером
     * @var Controller
     */
    public $controller;
    /**
     * Хранилиже промежуточных отрендереных представлений
     * @var string
     */
    private $views = "";

    /**
     * View constructor.
     * @param Controller $controller создающий контроллер
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Добавить в конец вывода представление
     * @param $view
     * @param null $data
     * @return void
     */
    function append_view($view, $data = null)
    {
        ob_start();
        include_once VIEWS_PATH . $view . '.php';
        $this->views .= ob_get_clean();
    }

    /**
     * Добавить в начало вывода представление
     * @param $view
     * @param null $data
     * @return void
     */
    function prepend_view($view, $data = null)
    {
        ob_start();
        include_once VIEWS_PATH . $view . '.php';
        $this->views = ob_get_clean() . $this->views;
    }

    /**
     * Генерация произвольного представления из файла {@link $view}
     * @param string $view Название генерируемого представления
     * @param null $data Передаваемые в представление данные
     * @return void
     */
    function render_template($view, $data = null)
    {

        include VIEWS_PATH . $view . '.php';
    }

    /**
     * Генерация произвольного представления из файла {@link $view} с результатом помещаемым в строку
     * @param string $view Название генерируемого представления
     * @param null $data Передаваемые в представление данные
     * @return string Сгенерированное пресдавление
     */
    function get_string_template($view, $data = null)
    {
        ob_start();
        include VIEWS_PATH . $view . '.php';
        return ob_get_clean();
    }

    /**
     * Собрать все представления с шапкой и подвалом
     * @return void
     */
    function render()
    {
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
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
                    <a href="<?php echo URL; ?>" title="Главная страница">
                        <img width="225" height="60" src="/images/camomile-flowers.png" alt="Chamaemelon">
                    </a>
                </div>
                <div id="menu" style="align-self: flex-end">
                    <ul class="menu">
                        <?php
                        $tabs = json_decode(str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', file_get_contents("../application/config/site_map")), true);
                        foreach ($tabs as $name => $url) {
                            echo '<li>';
                            echo '<a href="' . $url . ($_SERVER['REQUEST_URI'] == $url ? '" class="selected">' : '">') . $name . '</a>';
                            echo '</li>';
                        }
                        if ($this->controller->session->isLogin()) {
                            $userID = $this->controller->session->getUserInfo('id');
                            if ($userID == 1 || $userID == 2) {
                                $url = '/invoices';
                                $name = 'Счета';
                                echo '<li>';
                                echo '<a href="' . $url . ($_SERVER['REQUEST_URI'] == $url ? '" class="selected">' : '">') . $name . '</a>';
                                echo '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="userpic">
                <?php
                if ($this->controller->session->isLogin()) {
                    include VIEWS_PATH . 'userinfo_view.php';
                } else {
                    include VIEWS_PATH . 'login_view.php';
                }
                ?>
            </div>
        </div>
        <div id="wrapper">
            <div id="page">
                <?php
                echo $this->views;
                ?>
            </div>
            <div id="footer">
                <a href="http://vk.com/antler">code by AntLer &copy; 2015</a>
            </div>
        </body>
        <script src="/js/authorization.js" type="text/javascript"></script>
        </html>
        <?php
    }
}