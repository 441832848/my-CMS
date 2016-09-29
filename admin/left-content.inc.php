<?php

//////////////////////////
// 解析 sidebar-content //
//////////////////////////

    require_once(explode('\admin', __FILE__)[0].'\init.inc.php');

    if (!empty($_POST['load'])) {
        $_tpl = new Templates();
    }else{
        global $_tpl;
    }

    // 验证是否登录
    Validate::checkSession();

    $_tpl->_display('admin-left-content.tpl');



    