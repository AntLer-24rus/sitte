<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 16:41
 */

class View
{
    //public $template_view; // здесь можно указать общий вид по умолчанию.
    private $views = "";

    function append_view($view, $data = null)
    {
        ob_start();
        include_once VIEWS_PATH . $view . '.php';
        $this->views = $this->views . ob_get_clean();
    }
    function prepend_view($view, $data = null)
    {
        ob_start();
        include_once VIEWS_PATH . $view . '.php';
        $this->views = ob_get_clean() . $this->views;
    }

    function generate($view, $data = null)
    {

        include VIEWS_PATH .  $view . '.php';
    }

    function render()
    {
        include_once VIEWS_PATH . 'header_view.php';
        echo $this->views;
        include_once VIEWS_PATH . 'footer_view.php';
    }
}