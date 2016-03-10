<?php
/**
 * Created by PhpStorm.
 * User: AntLer
 * Date: 09.01.2015
 * Time: 14:13
 */
/**
 * the auto-loading function, which will be called every time a file "is missing"
 * NOTE: don't get confused, this is not "__autoload", the now deprecated function
 * The PHP Framework Interoperability Group (@see https://github.com/php-fig/fig-standards) recommends using a
 * standardized auto-loader https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md, so we do:
 */
function autoload($class) {
    // if file does not exist in LIBS_PATH folder [set it in config/config.php]
    if (file_exists(CORE_PATH . strtolower($class) . ".php")) {
        require CORE_PATH . strtolower($class) . ".php";
    } else {
        exit ('Current dir is ' . getcwd() . '\nThe file ' . $class . '.php is missing in ' . CORE_PATH . ' folder.');
    }
}
// spl_autoload_register defines the function that is called every time a file is missing. as we created this
// function above, every time a file is needed, autoload(THENEEDEDCLASS) is called
spl_autoload_register("autoload");