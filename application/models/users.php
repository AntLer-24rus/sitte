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

    /**
     * @param $user_id
     * @return array
     */
    public function getUserPermissions($user_id)
    {
        $sql = "SELECT item, rights FROM permission WHERE user_id = :user_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':user_id' => $user_id));
        $permissions = $query->fetchAll();
        $result["success"] = false;
        if (count($permissions) != 0) {
            $result["success"] = true;
            foreach ($permissions as $index => $permission) {
                $result["user_permissions"][$permission['item']] = boolval($permission['rights']);
            }

        }
        return $result;
    }
}
