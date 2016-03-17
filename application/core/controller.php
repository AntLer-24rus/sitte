<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 16:41
 */
abstract class Controller {
    /**
     * Свзяь с классом обрабатывающим модель
     * @access public
     * @var Model
     */
    public $model;
    /**
     * Связь с классом обрабатывающим представления
     * @access public
     * @var View
     */
    public $view;
    /**
     * Подключенная база данных
     * @access public
     * @var Database
     */
    public $db;

    /**
     *
     * Controller constructor.
     */
    public function __construct()
    {
        // initialize the session
        Session::init();
        // user has remember-me-cookie ? then try to login with cookie ("remember me" feature)
//        if (!isset($_SESSION['user_logged_in']) && isset($_COOKIE['remember_me'])) {
//            header('location: ' . URL . 'login/loginWithCookie');
//        }
        // create database connection
        try {
            $this->db = new Database();
        } catch (PDOException $e) {
            throw new Exception('Не авторизованый доступ. ' . $e);
        }
        // create a view object (that does nothing, but provides the view render() method)
        $this->view = new View($this);
    }
//    /**
//     * Поключение модели
//     * @param string $name название модели
//     * @return mixed
//     */
//    public function loadModel($name)
//    {
//        $path = MODELS_PATH . strtolower($name) . '.php';
//        if (file_exists($path)) {
//            require $path;
//            // The "Model" has a capital letter as this is the second part of the model class name,
//            // all models have names like "LoginModel"
//            $modelName = $name;
//            // return the new model object while passing the database connection to the model
//            return new $modelName($this->db);
//        }
//        return null;
//    }
    /**
     * Обязательно иметь стандартный метод
     * @return void
     */
    abstract public function index();
}