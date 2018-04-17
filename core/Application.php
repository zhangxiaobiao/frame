<?php

/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace core;

class Application
{
    public static function run()
    {
        // 设置字符集
        self::setCharset();
        // 定义路由常量
        self::defineRouteConst();
        // 定义路径常量
        self::definePathConst();
        // 定义自动加载
        self::defineAutoloader();
        // 开启session
        self::openSession();
        // 分发路由
        self::dispatchRoute();
    }

    protected static function setCharset()
    {
        header('Content-Type:text/html;charset=utf-8');
    }

    /**
     *
     */
    protected static function defineRouteConst()
    {
        $p = isset($_GET['p']) ? $_GET['p'] : 'backend';
        define('PLATFORM', $p);
        $a = isset($_GET['a']) ? $_GET['a'] : 'index';
        define('ACTION', $a);
        $c = isset($_GET['c']) ? $_GET['c'] : 'User';
        define('CONTROLLER', $c);
    }

    protected static function definePathConst() {
        define('VIEW_PATH', './app/view');
        define('CONFIG_PATH', './app/config');
    }
    //require 'core/MySQLDB.class.php';
    //require 'core/BaseModel.php';
    //require 'core/BaseController.php';
    //require 'app/model/UserModel.php';
    //require 'app/model/ProductModel.php';
    //require "app/controller/{$p}/UserController.php";
    //require 'app/controller/backend/ProductController.php';

    protected static function loadClass($className)
    {
        //echo '找不到： ' . $className . '<br />';
        $fileName = str_replace('\\', '/', $className) . ".php";
        if (is_file($fileName)) {
            require $fileName;
        }
    }

    protected static function defineAutoloader()
    {
        spl_autoload_register('self::loadClass');// loadClass 变成 __autoload
    }

    protected static function openSession()
    {
        session_start();
    }

    protected static function dispatchRoute()
    {
        $c = CONTROLLER . 'Controller';
        $c = "app\\controller\\" . PLATFORM . "\\" . $c;
        $obj = new $c();// new \app\controller\backend\UserController()
        $a = ACTION;
        $obj->$a();
    }
}
