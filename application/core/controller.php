<?php

/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 16:41
 */
abstract class Controller
{
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
     * Хранилище информации о сессии
     * @var Session
     */
    public $session;

    /**
     * Обязательно иметь стандартный метод
     * @return void
     */
    abstract public function index();

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        // initialize the session
        $this->session = new Session();
        // create database connection
        $this->db = new Database();
        $this->view = new View($this);
    }
}