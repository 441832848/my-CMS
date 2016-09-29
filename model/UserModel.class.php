<?php
/**
 * 导航实体类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-06 09:05:42
 * @version 1.0
 */

class UserModel extends Model{



    public function checkUser($username){

        // 组织sql语句
        $this->_sql = " select  
                            id
                        from 
                            cms_user 
                        where  
                            username='{$username}'
                        ;";

        // 执行sql并获取信息
        return parent::selectAll()!==false;

    }


    public function checkEmail($email){

        // 组织sql语句
        $this->_sql = " select  
                            id
                        from 
                            cms_user 
                        where  
                            email='{$email}'
                        ;";

        // 执行sql并获取信息
        return parent::selectAll()!==false;

    }


    public function reg($username,$password,$email,$question,$answer,$state,$date,$face){

        $this->_info = 'add user error ...';

        // 组织sql语句
        $this->_sql = " insert into   
                            cms_user(username,password,email,question,answer,state,date,face)
                        values
                            ('$username','$password','$email','$question','$answer','$state','$date','$face')
                        ;";

        // 执行sql并获取信息
        return parent::ADU();

    }


    public function login($username,$password){

        $this->_info = 'password error ...';

        // 组织sql语句
        $this->_sql = " select 
                            id 
                        from 
                            cms_user
                        where 
                            username='$username' and password='$password'
                        ;";

        // 执行sql并获取信息
        return (parent::selectAll()!==false ? 'success' : $this->_info);

    }


    public function getUserFace($username){

        // 组织sql语句
        $this->_sql = " select 
                            face 
                        from 
                            cms_user
                        where 
                            username='$username'
                        ;";

        // 执行sql并获取信息
        return parent::selectAll();

    }


    public function updateLoginTime($time){

        // 组织sql语句
        $this->_sql = " update 
                            cms_user  
                        set 
                            login_time=$time
                        where 
                            username='".$_SESSION['user']."'
                        ;";

        // 执行sql并获取信息
        parent::ADU();

    }


    public function getLoginUserList(){

        // 组织sql语句
        $this->_sql = " select 
                            username,face  
                        from 
                            cms_user 
                        order by 
                            login_time desc 
                        limit 
                            0,6
                        ;";

        // 执行sql并获取信息
        return parent::selectAll();

    }


















}