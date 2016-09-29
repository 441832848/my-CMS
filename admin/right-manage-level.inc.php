<?php 

////////////
// right-manage-manager 入口文件 //
////////////

    
    // 引入初始化文件和管理员实体类
    require_once(explode('\admin', __FILE__)[0].'\init.inc.php');       // 初始化文件

    // 验证是否登录
    Validate::checkSession();

    // 实例化管理员控制器类
    $level = new LevelAction($tpl);

    // 业务流程控制器
    $level->action();

    // 解析
    $level->_tpl->_display('admin-right-manage-Level.tpl');
    

