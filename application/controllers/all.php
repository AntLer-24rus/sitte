<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 22:45
 */
class All extends Controller
{
    public function __construct() {
        parent::__construct();
        throw new Exception('Тест');
        $this->model = new Invoice($this);
    }
    function index()
    {
        $data = $this->model->getAllInvoices();
        if (Session::get('user_id') == 1) {
            $this->view->append_view('all_view', $data);
        } else {
            //Session::destroy();
            $this->view->append_view('TODO_view', 'Дописать экран предложения авторизации');
        }

        $this->view->render();
    }
    function content()
    {
        $data = $this->model->getAllInvoices();
        if (Session::get('user_id') == 1) {
            $this->view->generate('all_view', $data);
        } else {
            //Session::destroy();
            $this->view->generate('TODO_view', 'Дописать экран предложения авторизации');
        }


    }

}