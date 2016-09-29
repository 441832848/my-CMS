<?php 

    require_once(explode('\config', __FILE__)[0].'\init.inc.php');

    // 生成验证码
    $vc = new ValidateCode();
    $vc->loadImage();


