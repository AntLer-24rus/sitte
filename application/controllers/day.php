<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 22:48
 */
class Day extends Controller {

    public function __construct() {
        parent::__construct();
        $this->model = new Invoice($this);
//        // initialize the session
//        Session::init();
//        // if user is still not logged in, then destroy session, handle user as "not logged in" and
//        // redirect user to login page
//        if (!isset($_SESSION['user_logged_in'])) {
//            Session::destroy();
//            header('location: ' . URL . 'login');
//            // to prevent fetching views via cURL (which "ignores" the header-redirect above) we leave the application
//            // the hard way, via exit(). @see https://github.com/panique/php-login/issues/453
//            exit();
//        }
    }
    function index()
    {
        $data = $this->model->getDayInvoices(new DateTime(null,new DateTimeZone('Asia/Novosibirsk')));
        foreach ($data as $row) {

        }
        $this->view->append_view('day_view', $data);
        $this->view->render();
    }

}