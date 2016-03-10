<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 23:19
 */
class Week extends Controller
{
//    public function __construct() {
//        parent::__construct();
//        // initialize the session
//        Session::init();
//        // if user is still not logged in, then destroy session, handle user as "not logged in" and
//        // redirect user to login page
//        if (!isset($_SESSION['user_logged_in'])) {
//            Session::destroy();
//            $this->view->generate('template_view', 'logout_view');
//            //header('location: ' . URL . 'login');
//            // to prevent fetching views via cURL (which "ignores" the header-redirect above) we leave the application
//            // the hard way, via exit(). @see https://github.com/panique/php-login/issues/453
//            //exit();
//        }
//    }
    function index()
    {
        $this->view->generate('template_view', 'week_view');
    }

}