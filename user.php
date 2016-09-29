<?php

    require_once(dirname(__FILE__).'/init.inc.php');

    // 获取导航信息
    $reg = new UserAction($tpl);
    
    // 解析模版文件
    $tpl -> _display('user.tpl');