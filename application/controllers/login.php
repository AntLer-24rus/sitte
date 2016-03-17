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
        $this->model = new Users($this->db);
    }
    function index() {
        if (!isset($_SESSION['user_logged_in'])) {
            $this->view->generate('login_view');
        } else {
            $this->view->generate('userinfo_view', $_SESSION['user_name']);
        }
    }
    function login() {

        if (!empty($_POST['login']) & !empty($_POST['pass'])) {
            $user_info = $this->model->findUser($_POST['login']);
            if (empty($user_info))
            {
                http_response_code(400);
                $this->view->generate("df");
                $this->view->generate('login_view', 'Неверный логин или пароль');
                return;
            }
            if (password_verify($_POST['login'].':'.$_POST['pass'],$user_info['hash'])) {
                Session::init();
                Session::set('user_logged_in', true);
                Session::set('user_id', $user_info['id']);
                Session::set('user_name', $user_info['name']);
                $this->view->generate('userinfo_view', $_POST['login']);
            } else {
                http_response_code(401);
                $this->view->generate('login_view', 'Неверный логин или пароль');
            }
        } else {
            http_response_code(400);
            $this->view->generate('login_view', 'Пустой логин или пароль!');
        }

    }
    function logout() {
        Session::destroy();
        $this->view->generate('login_view');
    }
}