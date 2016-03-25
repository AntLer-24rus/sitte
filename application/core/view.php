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
    private $css = array();
    private $js = array();

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

    function add_css($file_name)
    {
        $file_css_from_controller = 'css/' . strtolower($file_name) . '.css';
        if (file_exists($file_css_from_controller)) {
            array_push($this->css, $file_css_from_controller);
        }
    }

    function add_js($file_name)
    {
        $file_css_from_controller = 'js/' . strtolower($file_name) . '.js';
        if (file_exists($file_css_from_controller)) {
            array_push($this->js, $file_css_from_controller);
        }
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

            <link rel='icon' href='/favicon.ico' type='image/x-icon'>
            <link rel='shortcut icon' href='/favicon.ico' type='image/x-icon'>

            <link rel="stylesheet" type="text/css" href="/css/common.css"/>
            <link rel="stylesheet" type="text/css" href="/css/bar.css"/>
            <link rel="stylesheet" type="text/css" href="/css/menu.css"/>
            <link rel="stylesheet" type="text/css" href="/css/google_buttons.css"/>
            <?php
            foreach ($this->css as $file) {
                echo '<link rel="stylesheet" type="text/css" href="/' . $file . '"/>';
            }
            ?>

            <script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
            <script type="text/javascript" src="/bower_components/cryptojslib/rollups/aes.js"></script>
            <script type="text/javascript" src="/bower_components/cryptojslib/rollups/sha256.js"></script>

            <script type="text/javascript" src="/js/authorization.js"></script>
            <?php
            foreach ($this->js as $file) {
                echo '<script type="text/javascript" src="/' . $file . '"></script>';
            }
            ?>
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
                        <?php include VIEWS_PATH . 'menu_view.php'; ?>
                    </ul>
                </div>
            </div>
            <div class="userpic">
                <?php include VIEWS_PATH . ($this->controller->session->isLogin() ? 'userinfo_view.php' : 'login_view.php'); ?>
            </div>
        </div>
        <div id="wrapper">
            <!--            <div id="page">-->
            <?php echo $this->views; ?>
            <!--            </div>-->
            <div id="footer">
                <a href="http://vk.com/antler">code by AntLer &copy; 2015</a>
            </div>
        </body>

        </html>
        <?php
    }
}