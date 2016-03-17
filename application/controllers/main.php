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
        $this->view->append_view('TODO_view', 'есть в ветке develop');
        $this->view->render();
    }
}