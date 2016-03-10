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
        include_once 'application/views/' . $view . '.php';
        $this->views = $this->views . ob_get_clean();
    }
    function prepend_view($view, $data = null)
    {
        ob_start();
        include_once 'application/views/' . $view . '.php';
        $this->views = ob_get_clean() . $this->views;
    }

    function generate($view, $data = null)
    {

        include 'application/views/' . $view . '.php';
    }

    function render()
    {
        include_once 'application/views/header_view.php';
        echo $this->views;
        include_once 'application//views/footer_view.php';
    }
}