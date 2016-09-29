<?php

    require_once(dirname(__FILE__).'/init.inc.php');

    // 获取导航信息
    $nav = new NavAction($tpl);
    $nav->getFrontNav();

    // 导入参数
    $tpl->assign('topTips1','<a href="user.php" class="top-tips">注册</a>');
    $tpl->assign('topTips2','<a href="user.php?action=login" class="top-tips">登录</a>');
    $tpl->assign('loginUserList',UserAction::getLoginUserList());

    

    // 解析模版文件
    $tpl -> _display('index.tpl');





