<?php
/**
 * detail web
 * @authors Sc (hellosc@qq.com)
 * @date    2016-09-19 13:14:23
 * @version 1.0
 */

    require_once(dirname(__FILE__).'/init.inc.php');

    // 实例化首页文章控制器类
    $list = new DetailAction($tpl);

    // 解析模版文件
    $tpl -> _display('detail.tpl');


