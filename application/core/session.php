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
    public $id = "";
    /**
     * Состояние сессии
     * @var bool
     */
    public $userLoggedIn = false;
    /**
     * Массив для данных о вошедшем пользователе
     * @var array
     */
    public $userInfo = array();

    /**
     * Session constructor.
     */
    public function __construct()
    {
        // if no session exist, start the session
        if (session_id() == '') {
            session_start();
            $this->id = session_id();
            if (isset($_SESSION['user_logged_in'])) {
                $this->userLoggedIn = $_SESSION['user_logged_in'];
                $this->userInfo = $_SESSION['user_info'];
            } else {
                $this->userLoggedIn = false;
            }
        }
    }

    /**
     * starts the session
     */
    public static function init()
    {
        // if no session exist, start the session
        if (session_id() == '') {
            session_start();
            $_SESSION['session_id'] = session_id();
            if (!isset($_SESSION['user_logged_in'])) {
                $_SESSION['user_logged_in'] = false;
            }
        }
    }

    /**
     * sets a specific value to a specific key of the session
     * @param mixed $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * gets/returns the value of a specific key of the session
     * @param mixed $key Usually a string, right ?
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    /**
     * deletes the session (= logs the user out)
     */
    public function destroy()
    {
        $this->userLoggedIn = false;
        session_destroy();
    }
}