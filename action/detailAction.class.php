<?php
/**
 * Detail action
 * @authors Sc (hellosc@qq.com)
 * @date    2016-09-19 13:19:12
 * @version $Id$
 */

class DetailAction extends Action{

    function __construct(&$tpl){

        parent::__construct($tpl,new DocModel());

        // 初始化分页功能
        // $this->_pageInit();
        
        // 业务流程控制
        $this->_action();

        // 解析
        $this->show();

    }

    public function show(){

        // 过滤nav值
        $this->_checkId();

        // 过滤page值
        // $this->_checkPage();

        // get front web header navs
        $this->_tpl->assign('frontNav',(new navModel())->getFrontNav());

        // get document detail
        // var_dump($this->_model->getDocDetail($_GET['id']));
        if (!$document = $this->_model->getDocDetail($_GET['id'])[0]) {
            Tool::locationExit('./index.php');
        }
        // update clicks
        $this->_model->updateClicks($_GET['id']);
        $document->count++;
        // assign document contents
        if (isset($document->content)) {
            $this->_tpl->assign('docDetailDocument',htmlspecialchars_decode(stripcslashes($document->content)));
        }
        // assign document information
        $this->_tpl->assign('docDetail',$document);

        // 注入当前页码和每页显示的条数和总页数
        // $this->_tpl->assign('currentPage',$this->_page->currentPage);
        // $this->_tpl->assign('pageCount',FRONT_PAGE_COUNT);
        // $this->_tpl->assign('pageCountTotal',$this->_page->pageCountTotal);

        // 注入导航id值
        // $this->_tpl->assign('navId',$_GET['nav']);
        

    }


    /**
     * 初始化分页
     */
    private function _pageInit(){

        // 实例化分页类
        $this->_page = new Page($this->_docModel->getListDocCount((isset($_GET['nav'])?(string)$_GET['nav']:'1'),$this->_model));

        // 设置当前页
        $this->_page->currentPage = (empty($_GET['page']) || !is_numeric($_GET['page']) || (int)$_GET['page']<1) ? 1:(string)((int)$_GET['page']);

        // 计算相应值
        $this->_page->count('front');

    }

    private function _action(){

        if (!empty($_GET['clicksNavID'])) {
            $this->_clicks();
        }

    }


    private function _clicks(){

        if (!IS_CACHE) {
            exit('');
        }

        if (empty($_GET['clicksNavID']) || !is_numeric($_GET['clicksNavID']) || validate::checkLength(floor($_GET['clicksNavID']),1,false)) {
            exit($_GET['clicksNavID']);
        }

        // 累加点击量
        $this->_model->updateClicks(floor($_GET['clicksNavID']));

        // 获取点击量
        exit($this->_model->getClicks(floor($_GET['clicksNavID']))[0]->count);
    }

    /**
     * 检测id值
     */
    private function _checkId(){
        // nav值过滤
        if (empty($_GET['id']) || !is_numeric($_GET['id']) || validate::checkLength($_GET['id'],1,false)) {
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