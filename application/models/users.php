<?php

/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 11.01.2015
 * Time: 21:07
 */
class Users extends Model
{

    /**
     * @param $login
     * @return array
     */
    public function findUser($login)
    {
        $sql = "SELECT * FROM users WHERE login=:login";
        $query = $this->db->prepare($sql);

        $query->execute(array(':login' => $login));
        $user = $query->fetchAll();

        $result = array("success" => false);
        if (count($user) != 0) {
            $result["success"] = true;
            $result["user_info"] = $user[0];
        }
        return $result;
    }
}
