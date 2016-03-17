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
    function generate($view, $data = null)
    {

        include VIEWS_PATH .  $view . '.php';
    }

    /**
     * Собрать все представления с шапкой и подвалом
     * @return void
     */
    function render()
    {
        include_once VIEWS_PATH . 'header_view.php';
        echo $this->views;
        include_once VIEWS_PATH . 'footer_view.php';
    }
}