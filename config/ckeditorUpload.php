<?php
/**
 * ckeditor 编辑器上传处理
 * @authors Sc (hellosc@qq.com)
 * @date    2016-09-03 12:06:53
 * @version $Id$
 */

    require_once(explode('\config', __FILE__)[0].'\init.inc.php');

    if (!empty($_GET['type'])) {

        // 这里的文件imput name值是upload
        // 引入文件上传类
        $uf = new uploadFile('upload',512000);

        $path = preg_replace('/\\\\/','/',$uf->realFileName);

        // $a = 'D:\wamp\www\test\CMS\upload_files\20160904\201609040848595330.png';

        // Tool::alert(preg_replace('/\\\\/','/',$uf->fileName));

        // 在上传框中显示图片
        echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$_GET['CKEditorFuncNum'].',"'.$path.'","文件上传成功");</script>';
        

    }else{
        Tool::alertExit('error: `101 非法操作');
    }