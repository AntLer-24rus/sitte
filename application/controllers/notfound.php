<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 20:05
 */
class NotFound extends Controller
{

    function index()
    {
        $this->view->generate('template_view','404_view');
    }

}