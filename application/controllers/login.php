<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 09.01.2015
 * Time: 15:17
 */
class Login extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = $this->loadModel('users');
    }
    function index() {
        if (!isset($_SESSION['user_logged_in'])) {
            $this->view->generate('login_view');
        } else {
            $this->view->generate('userinfo_view', null, $_SESSION['user_name']);
        }
    }
    function login() {

        if (!empty($_POST['login']) & !empty($_POST['pass'])) {
            $user_info = $this->model->findUser($_POST['login']);
            if (empty($user_info))
            {
                http_response_code(400);
                $this->view->generate('login_view', null, 'Нет такого пользователя');
                return;
            }
            if (password_verify($_POST['login'].':'.$_POST['pass'],$user_info['hash']/*'$2y$10$AExG9X2YhrbFKU7URWCRmuAUUpTLEXth1y7i1MVBn6/JpK/PHHRV6'*/)) {
                Session::init();
                Session::set('user_logged_in', true);
                Session::set('user_id', $user_info['id']);
                Session::set('user_name', $user_info['name']);
                $this->view->generate('userinfo_view', null, $_POST['login']);
            } else {
                http_response_code(401);
                $this->view->generate('login_view', null, 'Неверный логин или пароль');
            }
        } else {
            http_response_code(400);
            $this->view->generate('login_view', null, 'Пустой логин или пароль!');
        }

    }
    function logout() {
        Session::destroy();
        $this->view->generate('login_view');
    }
}