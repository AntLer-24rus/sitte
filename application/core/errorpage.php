<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 20:05
 */
class ErrorPage extends Controller
{

    public function index()
    {
        $this->view->append_view('404_view');
        $this->view->render();
    }
    public function generatePage($errCode) {

        $this->view->append_view($errCode . '_view');
        $this->view->render();
    }

}