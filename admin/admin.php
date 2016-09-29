<?php
/**
 * 后台页面
 * @authors Your Name (you@example.org)
 * @date    2016-08-02 19:51:43
 * @version $Id$
 */

    require_once(explode('\admin', __FILE__)[0].'\init.inc.php');

    // 验证是否登录
    Validate::checkSession();

    // 导入变量
    $tpl->assign('left','侧边栏');
    $tpl->assign('top','顶部导航区');
    $tpl->assign('right','内容区');

    $tpl->assign('admin_user',$_SESSION['admin']['admin_user']);
    $tpl->assign('admin_level',$_SESSION['admin']['level']);
    $tpl->assign('admin_level_name',$_SESSION['admin']['level_name']);
    
    // 载入admin 页面
    $tpl->_display('admin.tpl');



