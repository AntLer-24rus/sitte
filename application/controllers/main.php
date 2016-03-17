<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 29.02.16
 * Time: 12:36
 */
class Main extends Controller
{
    public function __construct() {
        parent::__construct();
        // if user is still not logged in, then destroy session, handle user as "not logged in" and
        // redirect user to login page
        // Проверка пользователя и отказ в доступе
//        if (!isset($_SESSION['user_logged_in'])) {
//            Session::destroy();
//            throw new Exception('Не авторизованый доступ.');
////            header('location: ' . URL . 'login');
//            // to prevent fetching views via cURL (which "ignores" the header-redirect above) we leave the application
//            // the hard way, via exit(). @see https://github.com/panique/php-login/issues/453
////            exit();
//        }
    }
    function index()
    {
        $this->view->append_view('TODO_view', 'есть в ветке develop');
        $this->view->render();
    }

}