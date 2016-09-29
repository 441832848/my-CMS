<?php
/**
 * 后台登录类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-22 10:22:52
 * @version $Id$
 */

class LoginAction extends Action {
    
    function __construct(){

        $this->_model = new ManageModel();
        
        if (!empty($_POST['action']) && $_POST['action'] === 'login') {
            $this->_login();
        }else if (!empty($_GET['action']) && $_GET['action'] === 'logout') {
            $this->_logout();
        }
        
        // 登录成功后跳转到后台页面
        $this->_jumpToAdmin();

    }

    /**
     * 登录成功后跳转到后台页面
     */
    private function _jumpToAdmin(){

        Tool::openSession();
        if (isset($_SESSION['admin'])) {
            Tool::locationExit('admin.php');
        }

    }

    private function _login(){

        // 开启session
        Tool::openSession();

        // 验证验证码
        if (!empty($_POST['validateCode']) && !empty($_SESSION['validateCode']) && strtolower($_POST['validateCode'])===strtolower($_SESSION['validateCode'])) {

            // 验证数据
            $this->_validate();
            
            // 登录验证
            if ($this->_model->getManageOne($_POST['admin_user'],$_POST['admin_pass']) !== 'success') {
                Tool::alertBackExit('用户名或密码错误');
            }

            // 提示登录成功
            Tool::alert('登录成功');

            // 获取用户名和等级信息并写入session
            $managerInfo = $this->_model->getManageInfo($_POST['admin_user']);
            $_SESSION['admin'] = get_object_vars($managerInfo[0]);            // 将对象形式的信息转换成数组

            // 统计管理员登录信息
            $this->_model->updateManagerLoginInfo();

            // 跳转到后台界面
            Tool::locationExit('admin.php');

        }else{
            Tool::alertBackExit('登录失败');
        }

    }


    private function _logout(){

        // 开启session
        Tool::openSession();

        // 清理session
        $_SESSION['admin'] = null;

        // 跳转
        Tool::locationExit('../admin/admin-login.php');

    }


    private function _validate(){

        // 验证登录时的用户名和密码不为空
        if (Validate::checkNull($_POST['admin_user']) || Validate::checkNull($_POST['admin_pass'])) {
            Tool::alertBackExit('您还有未填写的表单项');
        }

        // 用户名不得小于2位,不得大于20位
        if (Validate::checkLength($_POST['admin_user'],2,false) || Validate::checkLength($_POST['admin_user'],20,true)) {
            Tool::alertBackExit('用户名不得小于2位,不得大于20位');
        }

        // 密码不得小于6位
        if (Validate::checkLength($_POST['admin_pass'],6,false)) {
            Tool::alertBackExit('密码不得小于6位');
        }

    }



}