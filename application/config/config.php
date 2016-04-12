<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 09.01.2015
 * Time: 14:07
 */
/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ALL);
ini_set("display_errors", 0);


ini_set('session.use_cookies',1);
//ini_set('session.use_only_cookies',1);
ini_set('session.use_strict_mode',1);
ini_set('session.use_trans_sid',0);
ini_set('session.cookie_lifetime',1*3600);//Сессия длится 1 час
ini_set('session.name','SID');

/**
 * Configuration for: Base URL
 * This is the base url of our app. if you go live with your app, put your full domain name here.
 * if you are using a (different) port, then put this in here, like http://mydomain:8888/subfolder/
 * Note: The trailing slash is important!
 */
define('URL', $_SERVER['SERVER_NAME']);
/**
 * Configuration for: Folders
 * Here you define where your folders are. Unless you have renamed them, there's no need to change this.
 */
define('CORE_PATH', '../application/core/');
define('CONTROLLER_PATH', '../application/controllers/');
define('MODELS_PATH', '../application/models/');
define('VIEWS_PATH', '../application/views/');
/**
 * Configuration for: Database
 * This is the place where you define your database credentials, type etc.
 *
 * database type
 * define('DB_TYPE', 'mysql');
 * database host, usually it's "127.0.0.1" or "localhost", some servers also need port info, like "127.0.0.1:8080"
 * define('DB_HOST', '127.0.0.1');
 * name of the database. please note: database and database table are not the same thing!
 * define('DB_NAME', 'login');
 * user for your database. the user needs to have rights for SELECT, UPDATE, DELETE and INSERT
 * By the way, it's bad style to use "root", but for development it will work
 * define('DB_USER', 'root');
 * The password of the above user
 * define('DB_PASS', 'xxx');
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', $_SERVER['OPENSHIFT_MYSQL_DB_HOST']);
define('DB_NAME', 'moneymanagement');
define('DB_USER', $_SERVER['OPENSHIFT_MYSQL_DB_USERNAME']);
define('DB_PASS', $_SERVER['OPENSHIFT_MYSQL_DB_PASSWORD']);