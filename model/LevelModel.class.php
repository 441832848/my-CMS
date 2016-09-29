<?php
/**
 * 管理员等级实体类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-06 09:05:42
 * @version 1.0
 */

class LevelModel extends Model{

    /**
     * 添加管理员等级
     * @param string $user  admin_user
     * @param string $pass  admin_pass
     * @param int    $level level
     */
    public function addLevel($level,$level_name,$level_info){

        // 定义返回信息
        $this->_info = 'delete level error...';

        // 组织sql语句
        $this->_sql = "insert into cms_level(level,level_name,level_info) values('{$level}','{$level_name}','{$level_info}');";

        // 执行sql并获取信息
        return parent::ADU();

    }

    /**
     * 删除管理员等级
     * @param  int     $id    id
     * @return string         tips
     */
    public function deleteLevel($level,$level_name){

        // 定义返回信息
        $this->_info = 'delete level error...';

        // 组织sql语句
        $this->_sql = "delete from cms_level where level='{$level}' and level_name='{$level_name}';";

        // 执行sql并获取信息
        return parent::ADU();

    }

    /**
     * 编辑管理员等级信息
     * @param  int    $oldUser id
     * @param  string $user    
     * @param  string $pass    
     * @param  int    $level   
     * @return string          tips
     */
    public function updateLevel($oldLevel,$oldLevelName,$level,$level_name,$level_info){

        // 定义返回信息
        $this->_info = 'update level error...';

        // 组织sql语句
        $this->_sql = "update cms_level set level='{$level}',level_name='{$level_name}',level_info='{$level_info}' where level='{$oldLevel}' and level_name='{$oldLevelName}';";

        // 执行sql并获取信息
        return parent::ADU();
    }

    /**
     * 查询所有管理员等级数据
     * @return object 结果对象
     */
    public function getLevel($limit){

        // 组织sql语句
        $this->_sql = "select 
                            level,level_name
                       from 
                            cms_level
                       order by
                            level desc
                       limit ".$limit.",".PAGE_COUNT."
                        ;";

        // 返回结果数组
        return parent::selectAll();

    }

    /**
     * 查询单条管理员等级数据
     * @return object 结果对象
     */
    public function selectOne($level,$level_name){

        // 定义返回信息
        $this->_info = 'select none...';

        // 组织sql语句
        $this->_sql = "select 
                            level,level_name
                       from 
                            cms_level
                       where
                            level='{$level}' and level_name='{$level_name}'
                        ;";

        // 返回结果数组
        return parent::ADU();

    }

    /**
     * 查询单条管理员数据
     * @return object 结果对象
     */
    public function selectExist($level){

        // 定义返回信息
        $this->_info = 'select none...';

        // 组织sql语句
        $this->_sql = "select 
                            level
                       from 
                            cms_manage
                       where
                            level='{$level}'
                        ;";

        // 返回结果数组
        return parent::ADU();

    }

    /**
     * 获取等级信息条数
     */
    public function getLevelCount(){

        // 组织sql语句
        $this->_sql = "select 
                    id
                 from 
                    cms_level
                    ;";

        // 执行sql
        parent::selectAll();
        return $this->_affectedRows;
    }


}