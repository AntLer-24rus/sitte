<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 11.01.2015
 * Time: 21:07
 */
class Users extends Model {

    /**
     * @param $login
     * @return array
     */
    public function findUser($login) {
        $sql = "SELECT * FROM users WHERE login=:login";
        $query = $this->db->prepare($sql);
        // fetchAll() is the PDO method that gets all result rows
        $query->execute(array(':login' => $login));
        $result = $query->fetchAll();

        return array(
            "id" => $result[0]->id,
            "name" => $result[0]->name,
            "hash" => $result[0]->hash
        );
    }
}