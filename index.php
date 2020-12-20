<?php
use Core\Session;
use Core\Cookie;
use Core\Router;
use App\Models\User;
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

//    load configuration and helper functions
require_once(ROOT . DS . 'config' . DS . 'config.php');
require_once(ROOT . DS . 'config' . DS . 'database.php');
//require_once(ROOT . DS . 'config' . DS . 'setup.php');

//    Autoload classes
function autoload($className) {
    $classAry = explode('\\',$className);
    $class = array_pop($classAry);
    $subPath = strtolower(implode(DS,$classAry));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    if(file_exists($path)){
        require_once($path);
    }
}

spl_autoload_register('autoload');
session_start();

$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

//    Route the request
Router::route($url);