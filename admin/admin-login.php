<?php
/**
 * 后台登录页面
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-02 19:51:43
 * @version 1.0
 */

    require_once(explode('\admin', __FILE__)[0].'\init.inc.php');

    // 实例化登录验证类
    new LoginAction();
    
    // 载入admin 页面
    $tpl->_display('admin-login.html');






