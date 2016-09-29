<?php
/**
 * 数据验证类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-10 08:56:52
 * @version 1.0
 */

class Validate {
    
    function __construct(){

    }

    /**
     * 检测数据是否为空
     * @param  string  $data string
     * @param  integer $mode 0:全部都为空才返回true / 1:如果有一个为空就返回true
     * @return boolean        result
     */
    static public function checkNull($data,$mode=0){

        if (!is_int($mode)) {
            throw new Exception("param type error", 1);
        }

        if (!empty($data) && is_array($data) && count($data)>1) {
            foreach ($data as $value) {
                // 全部都为空才返回true
                if (!empty($value) || ($mode === 0 && trim($value)!=='')) {
                    return false;
                }else if (empty($value) || ($mode === 1 && trim($value)==='')) {
                    // 如果有一个为空就返回true
                    return true;
                }
            }
            return ($mode === 0)?true:false;
        }

        return(trim($data)==='' ?  true : false);

    }

    /**
     * 检测数据长度
     * @param  string   $data   data
     * @param  int      $length length
     * @param  boolean  $flag   check flag [true为大于,false为小于]
     * @return boolean          数据是否正确
     */
    static public function checkLength($data,$length,$flag){

        if(!self::checkNull($data)){
            if (($flag && mb_strlen($data,'utf-8')>$length) || (!$flag && mb_strlen($data,'utf-8')<$length)) {
                return true;
            }
        }

        return false;

    }

    /**
     * 检测数据是否一致
     * @param  string  $data  data
     * @param  string  $data2 data2
     * @return boolean        数据是否正确
     */
    static public function checkEquals($data,$data2){

        if (!self::checkNull($data) && !self::checkNull($data2) && $data===$data2) {
            return true;
        }

        return false;

    }


    /**
     * 检测数据类型
     * @param  string $str  string
     * @param  string $type type
     * @return boolean      check 
     */
    static public function checkType($param,$type,$isMulti=false){

        if (empty($type) || !is_string($type) || !in_array($type, ['int','float','string','boolean','array','object','resource','null'])) {
            throw new Exception("type error");
        }

        if ($type === 'boolean') {
            $type = 'bool';
        }

        $methodName = 'is_'.$type;

        if ($isMulti && is_array($param) && count($param)>1) {
            foreach ($param as $value) {
                if (!$methodName($value)) {
                    return false;
                }
            }
            return true;
        }else{
            return $methodName($param);
        }


    }

    /**
     * 检测是否含有特殊字符
     * @param  string $str string
     * @return boolean      true/false
     */
    static public function checkChars($str){

        $pattern = '/[\'\"\;\\\#\`\!\=\-\_\)\(\*\&\^\$\]\[\{\}\,\.\/\?\>\<\|]+/';
        if (is_string($str) && preg_match($pattern,$str)) {
            return true;
        }

        return false;

    }

    /**
     * session验证
     */
    static public function checkSession(){

        // 开启缓冲区
        Tool::openSession();

        // 验证失败时跳转
        if (!isset($_SESSION['admin'])) {
            Tool::locationExit('../admin/admin-login.php');
        }

    }

}