<?php 

    // 设置编码
    header('Content-Type:text/html;charset=utf-8');

    // 网站根目录
    define('ROOT_PATH', dirname(__FILE__));

    // 引入初始化配置文件
    require_once(ROOT_PATH.'\\config\\profile.inc.php');

    // 自动加载类
    function __autoload($_className){
        if (substr($_className,-6) == 'Action') {
            // 加载action类
            require_once(ROOT_PATH.'\\action\\'.$_className.'.class.php');
        }else if (substr($_className,-5) == 'Model') {
            // 加载model类
            require_once(ROOT_PATH.'\\model\\'.$_className.'.class.php');
        }else{
            // 加载其他类
            require_once(ROOT_PATH.'\\includes\\'.$_className.'.class.php');
        }
    }

    // 设置时区
    date_default_timezone_set(TIMEZONE);

    // 实例化模版类
    $tpl = new Templates();

    // 引入公共文件
    require_once('common.inc.php');

