<?php
/**
 * 工具类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-07 13:23:13
 * @version 1.0
 */

class Tool {
    
    function __construct(){
        
    }

    static public function log($str){
        echo '<script>console.log("'.$str.'");</script>';
    }

    static public function alert($str){
        echo '<script>alert("'.$str.'");</script>';
    }

    static public function alertLocation($str,$URL){
        echo '<script>alert("'.$str.'");location.href="'.$URL.'";</script>';
    }

    static public function alertBack($str){
        echo '<script>alert("'.$str.'");history.back();</script>';
    }

    static public function location($URL){
        echo '<script>location.href = "'.$URL.'";</script>';
    }


    static public function alertExit($str){
        exit('<script>alert("'.$str.'");</script>');
    }

    static public function alertLocationExit($str,$URL){
        exit('<script>alert("'.$str.'");location.href="'.$URL.'";</script>');
    }

    static public function alertBackExit($str){
        exit('<script>alert("'.$str.'");history.back();</script>');
    }

    static public function locationExit($URL){
        exit('<script>location.href = "'.$URL.'";</script>');
    }

    // 开启session
    static public function openSession(){
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    // 弹窗赋值关闭窗口(上传专用)
    static public function alertOpenerClose($info,$path){
        // 转义path中存在的反斜线
        $path = str_replace('\\','\\\\',$path);
        // 引入jQuery
        echo "<script type=\"text/javascript\" src=\"../js/jQuery.min.js\"></script>";
        // 输出操作成功提示
        echo '<script type="text/javascript">alert("'.$info.'");</script>';
        // 显示缩略图
        echo '<script type="text/javascript">$(opener.document).find(".uploadPic").css({display:"inline-block",height:"150px"}).attr("src","'.$path.'");</script>';
        // 调整布局样式
        echo '<script type="text/javascript">$(opener.document).find(".thumbnail").css("display","none");</script>';
        echo '<script type="text/javascript">$(opener.document).find(".thumbnailLine").css("height","160px");</script>';



        // echo '<script type="text/javascript">opener.document.getElementByClassName("uploadPic").style="display:inline-block;height: 150px;";</script>';
        // echo '<script type="text/javascript">opener.document.getElementByClassName("thumbnail").style="display:none;";</script>';
        // echo '<script type="text/javascript">opener.document.getElementByClassName("thumbnailLine").style="height:160px;";</script>';
        // echo '<script type="text/javascript">opener.document.getElementByClassName("uploadPic").src="'.$path.'";</script>';
        
        // 关闭窗口
        echo '<script type="text/javascript">window.close();</script>';
    }

    // 检测是否是前台页面中允许缓存的页面
    static public function checkCache(){
        foreach (explode('&',NO_CACHE) as $value) {
            if (strpos($_SERVER['SCRIPT_NAME'],$value) !== false) {
                return false;
            }
        }
        return true;
    }

    // 获取完整的模版文件名
    static public function getTplFileName(){
        preg_match('/\/([\w\-]+)\.php/',$_SERVER['SCRIPT_NAME'],$tplName);
        return empty($tplName[1]) ? '' : $tplName[1].'.tpl';
    }

    // 获取request URI
    static public function getURLRequest(){
        // null代表不缓存,''代表无URI
        if (preg_match('/NG\=/i',$_SERVER["QUERY_STRING"])) {
            return null;
        }
        $u = preg_replace('/\&/','',$_SERVER["QUERY_STRING"]);
        $u = empty($u)? $u : '.'.$u;
        return $u;
    }

}