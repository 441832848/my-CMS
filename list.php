<?php

    require_once(dirname(__FILE__).'/init.inc.php');

    // 实例化首页列表控制器类
    $list = new ListAction($tpl);



    // 导入参数
    

    // 解析模版文件
    $tpl -> _display('list.tpl');


