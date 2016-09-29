<?php 

////////////
// right-manage-manager 入口文件 //
////////////

    
    // 引入初始化文件和管理员实体类
    require_once(explode('\admin', __FILE__)[0].'\init.inc.php');       // 初始化文件

    // 登录验证
    Validate::checkSession();

    // 实例化管理员控制器类
    $manager = new ManageAction($tpl);
    
    // 业务流程控制器
    $manager->action();

    // 解析
    $manager->_tpl->_display('admin-right-manage-manager.tpl');

