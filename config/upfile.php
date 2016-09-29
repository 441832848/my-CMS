<?php
/**
 * 文件上传
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-26 09:49:25
 * @version 1.0
 */

    require_once(explode('\config', __FILE__)[0].'\init.inc.php');

    // 引入文件上传类
    $uf = new uploadFile('pic');

    // 引入图像处理类
    $im = new Image($uf->fileName,['width'=>150,'height'=>'*'],WATER_TEXT);

    // 将路径传给父窗口并关闭当前窗口
    Tool::alertOpenerClose('图片上传成功',$uf->realFileName);


