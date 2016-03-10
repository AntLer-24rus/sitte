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
        // initialize the session
        Session::init();
        // if user is still not logged in, then destroy session, handle user as "not logged in" and
        // redirect user to login page

    }
    function index()
    {
        $invoices = $this->loadModel('invoice');
        $data = $invoices->getAllInvoices();
        if (Session::get('user_id') == 1) {
            $this->view->append_view('all_view', $data);
        } else {
            Session::destroy();
            $this->view->append_view('TODO_view', 'Дописать экран предложения авторизации');
        }

        $this->view->render();
    }
    function content()
    {
        $invoices = $this->loadModel('invoice');
        $data = $invoices->getAllInvoices();
        if (Session::get('user_id') == 1) {
            $this->view->generate('all_view', $data);
        } else {
            Session::destroy();
            $this->view->generate('TODO_view', 'Дописать экран предложения авторизации');
        }


    }

}