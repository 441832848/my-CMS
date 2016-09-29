<?php
/**
 * 数据库操作类
 * @authors Your Name (you@example.org)
 * @date    2016-08-05 19:46:06
 * @version $Id$
 */

class DB {
    
    function __construct(){
        
    }

    /**
     * 初始化数据库连接
     * @return object mysqli对象
     */
    static function getDB(){

        // 连接数据库
        @$_mysqli = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

        // 检测是否连接成功
        if (mysqli_connect_error()) {
            exit('<p>连接数据库失败... '.mysqli_connect_error().'</p>');
        }
        
        // 设置编码
        $_mysqli->set_charset('utf8');

        return $_mysqli;

    }

    /**
     * 清理mysqli
     *     这里的参数必须传引用,否则对象无法被销毁
     * @param  object $result result 对象
     * @param  object $mysqli nysqli 对象
     */
    static function unDB(&$mysqli=null,&$result=null){

        // 判断result是否是对象
        if (is_object($result)) {
            // 销毁结果集
            $result->free();
            // 销毁结果对象
            $result = null;
        }

        // 判断mysqli是否是对象
        if (is_object($mysqli)) {
            // 关闭数据库连接
            $mysqli->close();
            // 销毁mysqli对象
            $mysqli = null;
        }

    }


}