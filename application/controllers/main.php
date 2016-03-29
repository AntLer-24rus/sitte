<?php

/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 29.02.16
 * Time: 12:36
 */
class Main extends Controller
{
    function index()
    {
        $this->view->append_view('main_view');
        $this->view->render();
    }
}