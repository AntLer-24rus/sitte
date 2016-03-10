<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 16:41
 */
class Controller {

    public $model;
    public $view;

    public function __construct()
    {
        Session::init();
        // user has remember-me-cookie ? then try to login with cookie ("remember me" feature)
        if (!isset($_SESSION['user_logged_in']) && isset($_COOKIE['remember_me'])) {
            header('location: ' . URL . 'login/loginWithCookie');
        }
        // create database connection
        try {
            $this->db = new Database();
        } catch (PDOException $e) {
            throw new Exception('Не авторизованый доступ. ' . $e);
        }
        // create a view object (that does nothing, but provides the view render() method)
        $this->view = new View();
    }
    public function loadModel($name)
    {
        $path = MODELS_PATH . strtolower($name) . '.php';
        if (file_exists($path)) {
            require MODELS_PATH . strtolower($name) . '.php';
            // The "Model" has a capital letter as this is the second part of the model class name,
            // all models have names like "LoginModel"
            $modelName = $name;
            // return the new model object while passing the database connection to the model
            return new $modelName($this->db);
        }
    }
    public function index()
    {
        $this->view->render();
    }
}