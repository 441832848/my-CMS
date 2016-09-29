<?php
/**
 * Detail action
 * @authors Sc (hellosc@qq.com)
 * @date    2016-09-19 13:19:12
 * @version $Id$
 */

class UserAction extends Action{

    private $_actionType    = '注册';
    private $_isReg         = true;
    private $_isLogin       = false;
    private $_actionTypeArr = ['reg','login'];
    private $_faceCount     = 24;

    function __construct(&$tpl){

        parent::__construct($tpl,new UserModel());

        // 业务流程控制
        $this->_action();

        // 解析
        $this->show();

    }

    public function show(){

        // 业务类型
        $this->_tpl->assign('actionType',$this->_actionType);
        $this->_tpl->assign('reg',$this->_isReg);
        $this->_tpl->assign('login',$this->_isLogin);
        $this->_tpl->assign('faceCount',$this->_faceCount);

    }



    private function _action(){

        // GET
        if (!empty($_GET['action'])) {
            $this->_toggle($_GET['action']);
            return false;
        }else if (empty($_GET) && empty($_POST)) {
            $this->_toggle('reg');
            return false;
        }else if (!empty($_GET['checkLogin'])) {
            $this->_checkLogin($_GET['checkLogin']);
            exit('internal error -3 ...');
        }else if (!empty($_GET['logout'])) {
            $this->_logout();
            exit('internal error -4 ...');
        }

        // POST
        if (!empty($_POST['action']) && in_array($_POST['action'], $this->_actionTypeArr)) {
            $this->_toggle($_POST['action']);
            $this->_test();
            $this->_do();
            exit('internal error -2 ...');
        }

    }


    private function _toggle($type){

        switch ($type) {
            case 'reg':
                $this->_isLogin=false;
                $this->_isReg=true;
                break;
            case 'login':
                $this->_isLogin=true;
                $this->_isReg=false;
                $this->_actionType = '登录';
                break;
            default:
                Tool::locationExit('index.php');
                break;
        }

    }


    private function _test(){
        
        // 验证验证码
        $this->_checkValidateCode();

        // 过滤用户信息
        $this->_filter();

        // 检测是否存在该用户[邮箱]
        $this->_checkUser();

    }


    private function _do(){

        if ($this->_isReg) {
            $info = $this->_model->reg($_POST['username'],md5($_POST['password']),$_POST['email'],empty($_POST['question'])?'':$_POST['question'],empty($_POST['answer'])?'':$_POST['answer'],1,date('Y-m-d H:i:s'),$_POST['face']);
            $this->_saveSession($info);
        }else if ($this->_isLogin) {
            $info = $this->_model->login($_POST['username'],md5($_POST['password']));
            $this->_saveSession($info);
        }

    }


    private function _checkValidateCode(){

        if (!isset($_POST['validateCode']) || !is_string($_POST['validateCode'])) {
            exit('您还没有填写验证码');
        }
        Tool::openSession();
        if (empty($_SESSION['validateCode']) || strtolower($_SESSION['validateCode']) !== strtolower($_POST['validateCode'])) {
            exit('验证码错误');
        }else{
            // 清理验证码防止用户连续操作
            $_SESSION['validateCode'] = null;
        }

    }


    private function _filter(){

        if ($this->_isLogin) {
            if (Validate::checkNull([$_POST['username'],$_POST['password']],1)) exit('您还有未填写的表单项');
            if (Validate::checkLength($_POST['username'],2,false) || Validate::checkLength($_POST['username'],20,true) || preg_match('/[\'\,\(\)\"\#\\\\\s]/',$_POST['username'])) {
                exit('用户名长度有误或含有非法字符');
            }
            if (!preg_match('/[\w\!\@\#\$\%\^\&\*\(\)\_\+\-\=\[\]\{\}\;\'\,\.\/\:\"\<\>\?\\\\]{6,20}/',$_POST['password'])) {
                exit('密码长度有误或含有非法字符');
            }
        }else if ($this->_isReg) {
            if (Validate::checkNull([$_POST['username'],$_POST['password'],$_POST['email']],1)) exit('您还有未填写的表单项');
            if (Validate::checkLength($_POST['username'],2,false) || Validate::checkLength($_POST['username'],20,true) || preg_match('/[\'\,\(\)\"\#\\\\\s]/',$_POST['username'])) {
                exit('用户名长度有误或含有非法字符');
            }
            if (!preg_match('/[\w\!\@\#\$\%\^\&\*\(\)\_\+\-\=\[\]\{\}\;\'\,\.\/\:\"\<\>\?\\\\]{6,20}/',$_POST['password'])) {
                exit('密码长度有误或含有非法字符');
            }
            if (!preg_match('/^([\w-\.])+@([\w-])+(.[\w-])+/',$_POST['email'])) {
                exit('邮箱格式有误');
            }
            if (empty($_POST['face']) || !preg_match('/^\d{2}$/',$_POST['face']) || (int)$_POST['face']<0 || (int)$_POST['face']>$this->_faceCount) {
                $_POST['face'] = $this->_faceCount;
            }
            if (!empty($_POST['question']) && (!in_array($_POST['question'], [0,1,2]) || empty($_POST['answer']) || Validate::checkLength($_POST['answer'],20,true) || $_POST['answer']==='')) {
                exit('安全问题或答案有误'.$_POST['question']);
            }
        }else{
            exit('internal error -1 ...');
        }

    }


    private function _checkUser(){

        $user = $this->_model->checkUser($_POST['username']);
        
        if ($this->_isLogin && !$user) {
            exit('该用户不存在');
        }else if ($this->_isReg && $user) {
            exit('该用户已存在');
        }else if ($this->_isReg && $this->_model->checkEmail($_POST['email'])) {
            exit('该邮箱已被注册');
        }

    }


    /**
     * 写入session
     * @param  string $info information
     */
    private function _saveSession($info){

        // 判断操作是否成功
        if ($info === 'success') {
            $_SESSION['user'] = $_POST['username'];
            if ($_POST['getFace'] === '1') {
                $info .= '#'.$this->_model->getUserFace($_SESSION['user'])[0]->face;
            }

            // 更新用户最近登陆时间
            $this->_model->updateLoginTime(time());
        }

        exit($info);

    }



    private function _checkLogin(){

        // 已登录返回头像数字和用户名,失败返回#fail
        Tool::openSession();
        if (empty($_SESSION['user'])){
            exit('#fail');
        }
        $face = $this->_model->getUserFace($_SESSION['user'])[0]->face;
        $userInfo = $_SESSION['user'].'#'.($face===false ? $this->_faceCount : $face);
        exit($userInfo); 

    }


    private function _logout(){

        // 清理SESSION
        Tool::openSession();
        $_SESSION['user'] = null;

    }


    public static function getLoginUserList(){

        $list = (new UserModel())->getLoginUserList();
        foreach ($list as $key=>$value) {
            $value->face<10 ? $list[$key]->face='0'.$list[$key]->face : null;
        }
        return $list;

    }







}