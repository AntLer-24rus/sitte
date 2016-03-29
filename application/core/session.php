<?php

/**
 * Session class
 *
 * handles the session stuff. creates session when no one exists, sets and
 * gets values, and closes the session properly (=logout). Those methods
 * are STATIC, which means you can call them with Session::get(XXX);
 */
class Session
{
    /**
     * Идентификатор сессии
     * @var string
     */
    private $id = "";
    /**
     * Состояние сессии
     * @var bool
     */
    private $userLoggedIn = false;
    /**
     * Массив для данных о вошедшем пользователе
     * @var array
     */
    private $userInfo = array();
    private $userPermissions = array();

    /**
     * Устанавливает информацию о пользователе
     * @param mixed $keyOrArray Может быть именем свойства или массивом со свойствами
     * @param mixed $value Значение свойсва переданного первым параметром
     */
    public function setUserInfo($keyOrArray, $value = null)
    {
        if (empty($value)) {
            $_SESSION['user_info'] = $keyOrArray;
            $this->userInfo = $keyOrArray;
        } else {
            $_SESSION['user_info'][$keyOrArray] = $value;
            $this->userInfo[$keyOrArray] = $value;
        }

    }

    /**
     * Устанавливает информацию о разрешения пользователя
     * @param mixed $keyOrArray Может быть именем свойства или массивом со свойствами
     * @param mixed $value Значение свойсва переданного первым параметром
     */
    public function setUserPermissions($keyOrArray, $value = null)
    {
        if (empty($value)) {
            $_SESSION['user_permissions'] = $keyOrArray;
            $this->userPermissions = $keyOrArray;
        } else {
            $_SESSION['user_permissions'][$keyOrArray] = $value;
            $this->userPermissions[$keyOrArray] = $value;
        }
    }

    /**
     * Отдает свойство пользователя или весь массив свойств
     * @param null $key Имя свойства, если не заданно отдает весь массив
     * @return array
     */
    public function getUserInfo($key = null)
    {
        if (empty($key)) {
            return $this->userInfo;
        } else {
            if (isset($this->userInfo[$key])) {
                return $this->userInfo[$key];
            } else {
                return null;
            }
        }
    }

    /**
     * Session constructor. старует сессия и заполняет переменные из массива $_SESSION
     */
    public function __construct()
    {
        // if no session exist, start the session
        if (session_id() == '') {
            session_start();
            $this->id = session_id();
            if (isset($_SESSION['user_logged_in'])) {
                $this->userLoggedIn = $_SESSION['user_logged_in'];
            }
            if (isset($_SESSION['user_info'])) {
                $this->userInfo = $_SESSION['user_info'];
            }
            if (isset($_SESSION['user_permissions'])) {
                $this->userPermissions = $_SESSION['user_permissions'];
            }
        }
    }

    /**
     *  Вход пользователя
     */
    public function login()
    {
        $this->userLoggedIn = true;
        $_SESSION['user_logged_in'] = true;
        unset($_SESSION['user_info']['hash']);
        unset($_SESSION['user_info']['rnd_key']);
    }

    /**
     * Возвращает статус пользователя
     * @return bool
     */
    public function isLogin()
    {
        return $this->userLoggedIn;
    }

    /**
     * Проверяет разрешения пользователя на доступ к контенту
     * @param string $object Объект для проверки разрешений
     * @return bool
     */
    public function verifyUserPermission($object)
    {
        if (empty($this->userPermissions[$object])) {
            return false;
        } else {
            return $this->userPermissions[$object];
        }
    }

    /**
     * Удаляет информацию пользователя из сесии
     */
    public function logout()
    {
        $this->userLoggedIn = false;
        $this->id = "";
        $this->userInfo = array();
        $_SESSION['user_logged_in'] = false;
        unset($_SESSION['user_info']);
        unset($_SESSION['user_permissions']);
    }
}