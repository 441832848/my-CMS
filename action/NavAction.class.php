<?php
/**
 * 管理员业务流程控制器类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-07 19:41:27
 * @version 1.2
 *          新增add和update的数据验证
 *          新增分页
 */

class NavAction extends Action {

    private $_page;
    private $_isLoginCheck;

    public function __construct(&$tpl){

        // 获取模版和模型
        parent::__construct($tpl,new NavModel());

        // 初始化分页功能
        $this->_pageInit();

        // 业务流程控制器
        $this->action();

        // 解析
        $this->show();

    }


    /**
     * 操作处理函数
     * @return [type] [description]
     */
    private function action(){

        // 操作业务流程
        if (!empty($_POST['action'])) {

            switch ($_POST['action']) {

                case 'add':
                    $this->add();
                    break;

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

        // 其他业务流程
        if (!empty($_GET['action'])){

            switch ($_GET['action']) {

                case 'logout':
                    $this->logout();
                    exit();
                    break;

                case 'child':
                    $this->child();
                    // exit();
                    break;
                
                default:
                    exit('非法操作');
            }

        }


    }

    /**
     * 添加操作
     */
    private function add(){

        // 数据验证
        $this->validate();

        exit($this->_model->addNav($_POST['nav_name'],$_POST['pid'],$_POST['sort'],$_POST['nav_info']));
    }

    /**
     * 删除操作
     */
    private function delete(){
        exit($this->_model->deleteNav($_POST['id']));
    }

    /**
     * 修改操作
     */
    private function update(){

        // 数据验证
        $this->validate();

        exit($this->_model->updateNav($_POST['old_nav_name'],$_POST['old_pid'],$_POST['nav_name'],$_POST['pid'],$_POST['sort'],$_POST['nav_info']));

    }

    /**
     * 解析
     */
    private function show(){

        if (!empty($_GET['child']) && is_numeric($_GET['child']) && $_GET['child']>=0) {
            return false;
        }

        // 注入导航信息
        $this->_tpl->assign('navInfo',$this->_model->getNav($this->_page->limit));

        // 注入当前页码和每页显示的条数和总页数
        $this->_tpl->assign('currentPage',$this->_page->currentPage);
        $this->_tpl->assign('pageCount',PAGE_COUNT);
        $this->_tpl->assign('pageCountTotal',$this->_page->pageCountTotal);

        // 解析
        // $this->_tpl->_display('admin-right-content-nav.tpl');

    }

    /**
     * 数据检测
     */
    private function validate(){

        // 不得为空
        if (Validate::checkNull($_POST['nav_name'] || Validate::checkNull($_POST['pid']) || Validate::checkNull($_POST['sort']) || Validate::checkNull($_POST['nav_info']))) {
            exit('您还有未填写的表单项');
        }

        // 导航名不得小于2位,不得大于20位
        if (Validate::checkLength($_POST['nav_name'],6,true)) {
            if ($this->_isLoginCheck) {
                Tool::alertBackExit('导航名不得大于6位');
            }
        }
        // 密码不得小于6位
        if (Validate::checkLength($_POST['pid'],5,true)) {
            if ($this->_isLoginCheck) {
                Tool::alertBackExit('子分类不得大于5位');
            }
        }

    }

    /**
     * 初始化分页
     */
    private function _pageInit(){

        if (!empty($_GET['child']) && is_numeric($_GET['child']) && $_GET['child']>=0) {
            $child = $_GET['child'];
        }else{
            $child = null;
        }

        // 实例化分页类
        if ($child === null) {
            $this->_page = new Page($this->_model->getNavCount());
        }else{
            $this->_page = new Page($this->_model->getChildNavCount($child));
        }
        
        // 设置当前页
        $this->_page->currentPage = (empty($_GET['page']) || !is_numeric($_GET['page'])) ? 1:$_GET['page'];

        // 计算相应值
        $this->_page->count();

    }

    /**
     * 显示子导航
     * @return [type] [description]
     */
    private function child(){

        if (empty($_GET['child']) || !is_numeric($_GET['child']) || $_GET['child']<=0) {
            exit('param error...');
        }

        // 注入子导航信息
        $this->_tpl->assign('navInfo',$this->_model->getChildNav($this->_page->limit,$_GET['child']));

        // 注入当前页码和每页显示的条数和总页数
        $this->_tpl->assign('currentPage',$this->_page->currentPage);
        $this->_tpl->assign('pageCount',PAGE_COUNT);
        $this->_tpl->assign('pageCountTotal',$this->_page->pageCountTotal);

        // 解析
        // $this->_tpl->_display('admin-right-content-nav.tpl');

    }


    public function getFrontNav(){

        $this->_tpl->assign('frontNav',$this->_model->getFrontNav());

    }


}