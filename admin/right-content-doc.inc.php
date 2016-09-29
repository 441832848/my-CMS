<?php 

////////////
// right-manage-manager 入口文件 //
////////////

    
    // 引入初始化文件和管理员实体类
    require_once(explode('\admin', __FILE__)[0].'\init.inc.php');       // 初始化文件

    // 验证是否登录
    Validate::checkSession();

    // 实例化管理员控制器类
    $doc = new DocAction($tpl);

    // 解析
    $doc->_tpl->_display('admin-right-content-doc.tpl');
    

