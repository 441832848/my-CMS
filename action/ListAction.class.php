<?php
/**
 * 首页列表页面业务流程控制
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-23 09:56:32
 * @version 1.0
 */

class ListAction extends Action {
    
    private $_docModel;

    function __construct(&$tpl){

        parent::__construct($tpl,new NavModel());

        // 实例化docModel
        $this->_docModel = new DocModel();

        // 初始化分页功能
        $this->_pageInit();

        // 解析
        $this->show();

    }

    public function show(){

        // 过滤page值
        $this->_checkPage();

        // 获取导航所有父导航和子导航
        $this->_getNav();

        // 获取文章
        $this->_getDocModule();

        // 获取首页主导航
        $this->_tpl->assign('frontNav',$this->_model->getFrontNav());

        // 注入当前页码和每页显示的条数和总页数
        $this->_tpl->assign('currentPage',$this->_page->currentPage);
        $this->_tpl->assign('pageCount',FRONT_PAGE_COUNT);
        $this->_tpl->assign('pageCountTotal',$this->_page->pageCountTotal);

        // 注入导航id值
        $this->_tpl->assign('navId',$_GET['nav']);

    }


    /**
     * 初始化分页
     */
    private function _pageInit(){

        // 过滤nav值
        $this->_checkNav();

        // 实例化分页类
        $this->_page = new Page($this->_docModel->getListDocCount((string)$_GET['nav'],$this->_model));

        // 设置当前页
        $this->_page->currentPage = (empty($_GET['page']) || !is_numeric($_GET['page']) || (int)$_GET['page']<1) ? 1:(string)((int)$_GET['page']);

        // 计算相应值
        $this->_page->count('front');

    }


    /**
     * 获取前台显示的所有导航信息
     */
    private function _getNav(){

        // 判断传入的id值是否正确
        if (!$this->_model->checkNavId($_GET['nav'])) {
            Tool::alertLocationExit('error:该导航不存在','list.php');
        }

        // 获取当前导航节点层次
        $this->_tpl->assign('childNavInfo',$this->_model->getChildNavInfo($_GET['nav']));

        // 获取当前导航的子导航列表
        $this->_tpl->assign('childNavList',$this->_model->getAllChildNav($_GET['nav']));

    }

    // 获取文章模块[标题/缩略图/日期/点击量/内容摘要]
    private function _getDocModule(){
        // 检测该导航是否存在文章
        if(!$this->_docModel->checkNavDoc($_GET['nav'])){
            return false;
        }

        // 获取文章模块
        $this->_tpl->assign('docModule',$this->_docModel->getDocModule($_GET['nav'],$_GET['page']));

    }


    /**
     * 检测nav值
     */
    private function _checkNav(){
        // nav值过滤
        if (empty($_GET['nav']) || !is_numeric($_GET['nav']) || validate::checkLength($_GET['nav'],1,false)) {
            Tool::LocationExit('index.php');
        }
    }

    /**
     * 检测page值
     */
    private function _checkPage(){
        // page值过滤
        if (isset($_GET['page'])) {
            if (empty($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page']<1) {
                Tool::LocationExit('index.php');
            }
        }else{
            $_GET['page'] = 1;
        }
    }


}