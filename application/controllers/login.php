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
        if (empty($_POST["data"])) {
            http_response_code(400);
            $response["error_message"] = "Неправильные параметры запроса";
        } else {
            $request = $_POST["data"];
            if (empty($request["func"]) | empty($request["arg"])) {
                http_response_code(400);
                $response["error_message"] = "Неправильные параметры запроса";
            } else {
                switch ($request["func"]) {
                    case "step_one": {
                        $user = $this->model->findUser($request["arg"]);
                        $RND = bin2hex(openssl_random_pseudo_bytes(32));
                        if ($user["success"]) {
                            $this->session->setUserInfo($user["user_info"]);
                            $this->session->setUserInfo("rnd_key", $RND);
                            $user_key = hex2bin($user["user_info"]["hash"]);
                        } else {
                            $user_key = openssl_random_pseudo_bytes(32);
                        }
                        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-cbc"));
                        $encryptRND = openssl_encrypt($RND, "aes-256-cbc", $user_key, false, $iv);
                        $response["success"] = true;
                        $response["hash"] = base64_encode(bin2hex($iv) . ":" . $encryptRND);
                        break;
                    }
                    case "step_two": {
                        $RND = $this->session->getUserInfo("rnd_key");
                        if (empty($RND)) {
                            // TODO: Дописать обработку несуществующего пользователя
                            return;
                        }
                        $rawData = explode(':', base64_decode($request["arg"]));

                        $pass = openssl_decrypt($rawData[1], 'aes-256-cbc', hex2bin($RND), false, hex2bin($rawData[0]));

                        if ($pass) {
                            $test_hash = hash("sha256", $this->session->getUserInfo("login") . ":" . $pass);
                            if ($test_hash == $this->session->getUserInfo("hash")) {
                                $this->session->login();
                                $response["success"] = true;
                                $response["userpic_view"] = $this->view->get_string_template("userinfo_view");
                            } else {
                                // TODO: неправильный пароль
                            }
                        } else {
                            // TODO: Обработать дешифровки
                        }
                        break;
                    }
                    case "step_three": {

                    }
                }
            }
        }
        echo json_encode($response);
    }

    function logout()
    {
        $this->session->logout();
        $response["success"] = true;
        $response["userpic_view"] = $this->view->get_string_template("login_view");
        echo json_encode($response);
    }
}