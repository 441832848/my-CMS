<?php
/**
 * 模型基类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-08 10:31:28
 * @version 1.0
 */

class Model {
    
    protected $_info;
    protected $_sql;
    protected $_resultArr;
    protected $_results = [];
    protected $_affectedRows;

    function __construct(){
        
    }

    /**
     * 增删改操作函数模型
     *     执行内部组织的sql语句
     *     执行成功返回'success'
     *     执行失败返回_info
     * @return string 提示信息
     */
    protected function ADU(){

        // 连接数据库
        $_db = DB::getDB();

        // 执行sql语句
        $_result = $_db->query($this->_sql);

        // 遍历获取结果对象
        if ($_db->affected_rows > 0) {
            $this->_info = 'success';
        }

        // 清理mysqli 对象
        DB::unDB($_db,$_result);

        return $this->_info;

    }

    /**
     * 查询所有数据操作函数模型
     * @return array 对象数组形式的结果集
     */
    protected function selectAll(){
        // 连接数据库
        $_db = DB::getDB();

        // 初始化结果数组
        $this->_resultArr = [];

        // 执行sql语句
        $_result = $_db->query($this->_sql);

        // 获取受影响的行数
        $this->_affectedRows = $_db->affected_rows;

        // 如果执行出错,就返回错误sql
        if ($_result === false) {
            exit('<strong>错误SQL:</strong> <br>'.$this->_sql.'<br><strong>错误信息:</strong> <br>'.$_db->error);
        }

        // 如果结果集没有数据就返回false
        if ($_result->num_rows == 0) {
            return false;
        }

        // 获取数据
        while(!!$_row = $_result->fetch_object()){
            $this->_resultArr[] = $_row;
        }

        // 清理mysqli 对象
        DB::unDB($_db,$_result);

        return $this->_resultArr;
    }


}