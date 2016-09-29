<?php
/**
 * 管理员业务流程控制器类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-07 19:41:27
 * @version 1.2
 *          新增add和update的数据验证
 *          新增分页
 */

class MemberAction extends Action {

    private $_page;

    public function __construct(&$tpl){

        // 获取模版和模型
        parent::__construct($tpl,new MemberModel());

        // 初始化分页功能
        $this->_pageInit();

        // 解析
        $this->show();

    }


    /**
     * 操作处理函数
     * @return [type] [description]
     */
    public function action(){

        // 业务流程
        if (!empty($_POST['action'])) {
            switch ($_POST['action']) {

                case 'delete':
                    $this->delete();
                    break;

                case 'update':
                    $this->update();
                    break;

                default:
                    exit('非法操作');
            }
        }

    }

    /**
     * 删除操作
     */
    private function delete(){
        if ($_POST['id'] == '1') {
            exit("该用户不可删除...");
        }
        exit($this->_model->deleteMember($_POST['id']));
    }

    /**
     * 修改操作
     */
    private function update(){
        if ($_POST['id'] == '1') {
            exit("该用户不可修改...");
        }
        // 数据验证
        $this->validate();
        exit($this->_model->updateMember($_POST['username'],$_POST['email'],floor($_POST['state']),$_POST['id']));
    }

    /**
     * 解析
     */
    private function show(){

        // 注入管理员信息
        $this->_tpl->assign('memberInfo',$this->_model->getMember($this->_page->limit));

        // 注入当前页码和每页显示的条数和总页数
        $this->_tpl->assign('currentPage',$this->_page->currentPage);
        $this->_tpl->assign('pageCount',PAGE_COUNT);
        $this->_tpl->assign('pageCountTotal',$this->_page->pageCountTotal);

    }



    /**
     * 数据检测类
     */
    private function validate(){

        // 不得为空
        if ((Validate::checkNull($_POST['username']) || Validate::checkNull($_POST['email']) || Validate::checkNull($_POST['state']) || Validate::checkNull($_POST['id']))) {
            exit('您还有未填写的表单项');
        }

        // 用户名不得小于2位,不得大于20位
        if (Validate::checkLength($_POST['username'],2,false) || Validate::checkLength($_POST['username'],20,true)) {
            exit('用户名不得小于2位,不得大于20位');
        }

        // 密码不得小于6位
        if (Validate::checkLength($_POST['password'],6,false)) {
            exit('密码不得小于6位');
        }

        // 状态值为1位int值
        if (!is_numeric($_POST['state']) || $_POST['state']<0 || $_POST['state']>9) {
            exit('状态值有误');
        }

    }

    /**
     * 初始化分页
     */
    private function _pageInit(){

        // 实例化分页类
        $this->_page = new Page($this->_model->getMemberCount());

        // 设置当前页
        $this->_page->currentPage = (empty($_GET['page']) || !is_numeric($_GET['page'])) ? 1:$_GET['page'];

        // 计算相应值
        $this->_page->count();

    }

}