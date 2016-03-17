<?php

class Login extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new Users($this);
    }

    function index()
    {
        if (!isset($_SESSION['user_logged_in'])) {
            $this->view->render_template('login_view');
        } else {
            $this->view->render_template('userinfo_view', $_SESSION['user_name']);
        }
    }

    function login()
    {
        $response = array('success' => false);

        if (!empty($_POST['login'])) {
            $user = $this->model->findUser($_POST['login']);
            if ($user["success"]) {
                $RND = "test_string";//base64_encode(openssl_random_pseudo_bytes(32));
                $iv = openssl_random_pseudo_bytes(16);
                $encryptRND = openssl_encrypt($RND, "AES256", $user['user_info']['hash'], false, $iv);
                $response["success"] = true;
                $response["hash"] = base64_encode(base64_encode($iv) . ":" . $encryptRND);
            } else {
                $response['userpic_view'] = $this->view->get_string_template('login_view', 'Неверный логин или пароль!');
            }
            /*            if (password_verify($_POST['login'] . ':' . $_POST['pass'], $user['hash'])) {
                            Session::init();
                            Session::set('user_logged_in', true);
                            Session::set('user_id', $user['id']);
                            Session::set('user_name', $user['name']);
                            $this->view->render_template('userinfo_view', $_POST['login']);
                        } else {
                            http_response_code(401);
                            $this->view->render_template('login_view', 'Неверный логин или пароль');
                        }*/
        } else {
            $response['userpic_view'] = $this->view->get_string_template('login_view', 'Пустой логин или пароль!');
        }
        echo json_encode($response);
    }

    function logout()
    {
        Session::destroy();
        $this->view->render_template('login_view');
    }
}