<?php
/**
 * 管理员等级业务流程控制器类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-07 19:41:27
 * @version 1.1
 *          新增分页
 */

class LevelAction extends Action {

    private $_page;

    public function __construct(&$tpl){

        // 获取模版和模型
        parent::__construct($tpl,new LevelModel());

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

        if (!empty($_POST['action'])) {

            // 正则匹配防注入未写...

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


    }

    /**
     * 添加操作
     */
    private function add(){
        if ($_POST['level'] >= 7) {
            exit('该等级不可在此添加....');
        }

        // 数据验证
        $this->checkDate();

        // 判断是否重复添加同等级和名称的值
        if ($this->_model->selectOne($_POST['level'],$_POST['level_name']) === 'success') {
            exit('添加的等级和等级名称不能重复');   
        }

        exit($this->_model->addLevel($_POST['level'],$_POST['level_name'],$_POST['level_info']));
    }

    /**
     * 删除操作
     */
    private function delete(){
        if ($_POST['level'] >= 7) {
            exit("该等级不可删除...");
        }

        // 防止误删等级
        if ($this->_model->selectExist($_POST['level']) === 'success') {
            exit('该等级已被占用，不可删除');
        }

        exit($this->_model->deleteLevel($_POST['level'],$_POST['level_name']));
    }

    /**
     * 修改操作
     */
    private function update(){
        if ($_POST['old_level'] == 'admin') {
            exit("admin 不可修改...");
        }

        // 数据验证
        $this->checkDate();

        exit($this->_model->updateLevel($_POST['old_level'],$_POST['old_level_name'],$_POST['level'],$_POST['level_name'],$_POST['level_info']));
    }

    /**
     * 解析
     */
    private function show(){

        // 注入管理员等级信息
        $this->_tpl->assign('levelInfo',$this->_model->getLevel($this->_page->limit));

        // 注入当前页码和每页显示的条数和总页数
        $this->_tpl->assign('currentPage',$this->_page->currentPage);
        $this->_tpl->assign('pageCount',PAGE_COUNT);
        $this->_tpl->assign('pageCountTotal',$this->_page->pageCountTotal);

    }

    private function checkDate(){

        // 不得为空
        if (Validate::checkNull($_POST['level']) || Validate::checkNull($_POST['level_name']) || Validate::checkNull($_POST['level_info'])) {
            exit('您还有未填写的表单项');
        }

        // 不得有特殊字符
        if (Validate::checkChars($_POST['level']) || Validate::checkChars($_POST['level_name']) || Validate::checkChars($_POST['level_info'])) {
            exit('您填写的表单项含有特殊字符');
        }

        // 等级必须是0~2
        if (!is_numeric($_POST['level']) || Validate::checkLength($_POST['level'],2,true)) {
            exit('等级必须是0~2');
        }

        // 称号不得小于2位,不得大于20位
        if (Validate::checkLength($_POST['level_name'],2,false) || Validate::checkLength($_POST['level_name'],20,true)) {
            exit('称号不得小于2位,不得大于20位');
        }

        // 等级信息不得大于200字节
        if (Validate::checkLength($_POST['level_info'],200,true)) {
            exit('等级信息不得大于200字节');
        }

    }

    /**
     * 初始化分页
     */
    private function _pageInit(){

        // 实例化分页类
        $this->_page = new Page($this->_model->getLevelCount());

        // 设置当前页
        $this->_page->currentPage = (empty($_GET['page']) || !is_numeric($_GET['page'])) ? 1:$_GET['page'];

        // 计算相应值
        $this->_page->count();

    }




}