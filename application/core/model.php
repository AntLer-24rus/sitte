<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 16:40
 */

abstract class Model {
    /**
     * Класс подключенной базы данных
     * @var Database
     */
    protected  $db;

    /**
     * Связь с контроллером
     * @var Controller
     */
    protected $controller;

    /**
     * Model constructor.
     * @param Database $controller [@see Model::$controller}
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
        $this->db = $this->controller->db;
    }
} 