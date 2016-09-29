<?php
/**
 * 管理员实体类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-06 09:05:42
 * @version 1.0
 */

class MemberModel extends Model{

    /**
     * 删除管理员
     * @param  int     $id    id
     * @return string         tips
     */
    public function deleteMember($id){

        // 定义返回信息
        $this->_info = 'delete member error...';

        // 组织sql语句
        $this->_sql = "delete from cms_user where id='{$id}';";

        // 执行sql并获取信息
        return parent::ADU();

    }

    /**
     * 更新用户信息
     * @param  string $username username
     * @param  string $email    email
     * @param  string $state    state
     * @param  string $id       id
     * @return string           tips
     */
    public function updateMember($username,$email,$state,$id){

        // 定义返回信息
        $this->_info = 'update member error...';

        // 组织sql语句
        $pass = md5($pass);
        $this->_sql = "update cms_user set username='{$username}',email='{$email}',state={$state} where id='{$id}';";

        // 执行sql并获取信息
        return parent::ADU();
    }

    /**
     * 查询管理员数据
     * @return object 结果对象
     */
    public function getManage($current){

        // 组织sql语句
        $this->_sql = "select 
                    m.id,m.admin_user,l.level,l.level_name,m.login_count,m.login_ip,m.login_time,m.reg_time
                 from 
                    cms_manage m,cms_level l
                 where
                    m.level=l.level
                 order by
                    m.id asc
                 limit
                    ".$current.",".PAGE_COUNT."
                    ;";

        // 返回结果数组
        return parent::selectAll();

    }

    /**
     * 查询管理员信息条数
     * @return object 结果对象
     */
    public function getManageCount(){

        // 组织sql语句
        $this->_sql = "select 
                    id
                 from 
                    cms_manage
                    ;";

        // 执行sql
        parent::selectAll();
        return $this->_affectedRows;

    }

    /**
     * 登录验证
     * @param  string $user username
     * @param  string $pass password
     * @return string       info
     */
    public function getManageOne($user,$pass){

        // 定义返回信息
        $this->_info = 'not found manager...';

        // 密码处理
        $pass = sha1($pass);

        // 组织sql语句
        $this->_sql = "select id from cms_manage where admin_user='{$user}' and admin_pass='{$pass}'";

        // 执行sql并获取信息
        return parent::ADU();

    }

    /**
     * 获取用户信息[用户名、等级、等级名称]
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function getManageInfo($user){

        // 定义返回信息
        $this->_info = 'get manager info error...';

        // 组织sql语句
        $this->_sql = "select 
                            m.admin_user,l.level,l.level_name
                         from
                            cms_manage m,cms_level l 
                         where 
                            m.level=l.level and admin_user='{$user}'
                            ;";

        // 执行sql并获取信息
        return parent::selectAll();

    }

    /**
     * 统计管理员登录信息[登录次数、登录ip、登录时间]
     */
    public function updateManagerLoginInfo(){

        // 定义返回信息
        $this->_info = 'update manager login info error...';

        // 组织sql语句
        $this->_sql = "update 
                            cms_manage
                         set 
                            login_count=login_count+1,
                            login_ip='{$_SERVER['REMOTE_ADDR']}',
                            login_time='".date('Y-m-d H:i:s')."' 
                         where 
                            admin_user='{$_POST['admin_user']}'
                            ;";

        // 执行sql并获取信息
        parent::ADU();

    }


}