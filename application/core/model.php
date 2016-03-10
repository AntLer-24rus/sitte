<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 08.01.2015
 * Time: 16:40
 */

class Model {
    protected  $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
} 