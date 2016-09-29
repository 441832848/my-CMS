<?php
/**
 * 导航实体类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-06 09:05:42
 * @version 1.0
 */

class NavModel extends Model{

    /**
     * 添加管理员
     * @param string $user  admin_user
     * @param string $pass  admin_pass
     * @param int    $level level
     */
    public function addNav($nav_name,$pid,$sort,$nav_info){

        // 定义返回信息
        $this->_info = 'add nav error...';

        // 组织sql语句
        $this->_sql = "insert into cms_nav(nav_name,pid,sort,nav_info) values('{$nav_name}','{$pid}','{$sort}','{$nav_info}');";

        // 执行sql并获取信息
        $resultStr = parent::ADU();

        // 如果未填写sort字段或小于1就使用id值填充
        if ($sort==null || validate::checkLength($sort,1,false)) {
            // 设置sort字段值为id
            $this->_sql = "update cms_nav set sort=id where nav_name='{$nav_name}' and pid='{$pid}';";
            parent::ADU();
        }

        return $resultStr;

    }

    /**
     * 删除管理员
     * @param  int     $id    id
     * @return string         tips
     */
    public function deleteNav($id){

        // 定义返回信息
        $this->_info = 'delete nav error...';

        // 组织sql语句
        $this->_sql = "delete from cms_nav where id='{$id}';";

        // 执行sql并获取信息
        return parent::ADU();

    }

    /**
     * 编辑管理员信息
     * @param  int    $oldUser id
     * @param  string $user    
     * @param  string $pass    
     * @param  int    $level   
     * @return string          tips
     */
    public function updateNav($old_nav_name,$old_pid,$nav_name,$pid,$sort,$nav_info){

        // 定义返回信息
        $this->_info = 'update nav error...';

        // 组织sql语句
        $this->_sql = "update cms_nav set nav_name='{$nav_name}',pid='{$pid}',sort='{$sort}',nav_info='{$nav_info}' where nav_name='{$old_nav_name}' and pid='{$old_pid}';";

        // 执行sql并获取信息
        return parent::ADU();
    }

    /**
     * 查询导航数据
     * @return object 结果对象
     */
    public function getNav($current){

        // 组织sql语句
        $this->_sql = "select 
                            *
                         from 
                            cms_nav
                         where
                            pid='0'
                         order by
                            sort asc
                         limit
                            ".$current.",".PAGE_COUNT."
                            ;";

        // 返回结果数组
        return parent::selectAll();

    }

    /**
     * 查询导航信息条数
     * @return object 结果对象
     */
    public function getNavCount(){

        // 组织sql语句
        $this->_sql = "select 
                            id
                         from 
                            cms_nav
                         where
                            pid=0
                            ;";

        // 执行sql
        parent::selectAll();
        return $this->_affectedRows;

    }


    /**
     * 查询子导航数据
     * @return object 结果对象
     */
    public function getChildNav($current,$child){

        // 组织sql语句
        $this->_sql = "select 
                            *
                         from 
                            cms_nav
                         where
                            pid='{$child}'
                         order by
                            sort asc
                         limit
                            ".$current.",".PAGE_COUNT."
                            ;";

        // 返回结果数组
        return parent::selectAll();

    }

    /**
     * 查询所有子导航数据
     * @return object 结果对象
     */
    public function getAllChildNav($pid){

        // 组织sql语句
        $this->_sql = "select 
                            id,nav_name
                         from 
                            cms_nav
                         where
                            pid='{$pid}'
                         order by
                            sort asc
                            ;";

        // 返回结果数组
        return parent::selectAll();

    }



    /**
     * 查询子导航信息条数
     * @return int 结果集条数
     */
    public function getChildNavCount($pid=0){

        // 组织sql语句
        $this->_sql = "select 
                            id
                         from 
                            cms_nav
                         where
                            pid='{$pid}'
                            ;";

        // 执行sql
        parent::selectAll();
        return $this->_affectedRows;

    }

    /**
     * 前台获取导航信息
     * @return [type] [description]
     */
    public function getFrontNav(){

        // 组织sql语句
        $this->_sql = "select 
                            id,nav_name
                         from 
                            cms_nav
                         where
                            pid=0
                         order by
                            sort asc
                         limit
                            0,".NAV_SIZE."
                            ;";

        // 返回结果数组
        return parent::selectAll();        
    }



    /**
     * 查询所有子导航数据
     * @return object 结果对象
     */
    public function getChildNavInfo($id){

        // 组织sql语句
        $this->_sql = "select 
                            id,pid,nav_name
                         from 
                            cms_nav
                         where
                            id='{$id}'
                            ;";

        // 递归获取导航节点所有父节点
        if (!!$res = parent::selectAll()){
            $row = json_decode('{"id":"'.$res[0]->id.'","nav_name":"'.$res[0]->nav_name.'"}');
            array_push($this->_results,$row);
            $this->getChildNavInfo($res[0]->pid);
        }

        // 返回导航节点数组
        return $this->_results;

    }

    /**
     * 按照id查找row
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function checkNavId($id){

        // 组织sql语句
        $this->_sql = "select 
                            id,nav_name
                         from 
                            cms_nav
                         where
                            id='{$id}'
                         limit
                            0,1
                            ;";

        // 返回导航节点数组
        return parent::selectAll();

    }



    /**
     * 查询所有导航数据
     * @return object 结果对象
     */
    public function getAllNav(){

        // 组织sql语句
        $this->_sql = "select 
                            id,nav_name
                         from 
                            cms_nav
                         where
                            pid=0
                            ;";

        parent::selectAll();

        // 返回导航节点数组
        return $this->_resultArr;

    }


}