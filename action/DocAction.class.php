<?php
/**
 * 文档业务流程控制器类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-07 19:41:27
 * @version 1.3
 *          新增add和update的数据验证
 *          新增分页
 *          新增前端部分
 */

class DocAction extends Action {

    private $_page;
    private $_navID;

    public function __construct(&$tpl){

        // 获取模版和模型
        parent::__construct($tpl,new DocModel());

        // 业务流程控制器
        $this->action();

        // 初始化分页功能
        $this->_pageInit();

        // 解析
        $this->show();

    }

    /**
     * 操作处理函数
     * @return [type] [description]
     */
    private function action(){

        // 具体CURD操作业务流程
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

        // 导航筛选
        if (!empty($_GET['navID'])) {
            // 过滤
            $this->_checkNavID($_GET['navID']);
            $this->_navID = floor($_GET['navID']);
        }

        // 返回文章信息[后台修改文章]
        if (isset($_GET['updateDoc'])) {
            // 过滤
            $this->_checkNavID($_GET['updateDoc']);
            exit($this->_getUpdateDocInfo());
        }

    }

    /**
     * 添加操作
     */
    private function add(){

        // 数据验证
        $this->validate('add');


        exit($this->_model->addDoc(
                $_POST['author'],
                $_POST['color'],
                $_POST['comment'],
                $_POST['count'],
                $_POST['info'],
                $_POST['keyword'],
                $_POST['limit'],
                $_POST['nav'],
                $_POST['sort'],
                $_POST['source'],
                $_POST['tag'],
                $_POST['title'],
                $_POST['front'],
                $_POST['rec'],
                $_POST['bold'],
                $_POST['skip'],
                $_POST['thumbnail'],
                $_POST['content'],
                $_POST['gold']
            ));

    }

    /**
     * 删除操作
     */
    private function delete(){
        if ($_POST['id'] == 8) {
            exit("该文章用于测试,不可删除...");
        }
        // 数据验证
        $this->validate('delete');
        exit($this->_model->deleteDoc(floor($_POST['id'])));
    }

    /**
     * 修改操作
     */
    private function update(){
        
        // 数据验证
        $this->validate('add');
        exit($this->_model->updateDoc(
                $_POST['author'],
                $_POST['color'],
                $_POST['comment'],
                $_POST['count'],
                $_POST['info'],
                $_POST['keyword'],
                $_POST['limit'],
                $_POST['nav'],
                $_POST['sort'],
                $_POST['source'],
                $_POST['tag'],
                $_POST['title'],
                $_POST['front'],
                $_POST['rec'],
                $_POST['bold'],
                $_POST['skip'],
                $_POST['thumbnail'],
                $_POST['content'],
                $_POST['gold'],
                $_POST['id']
            ));
    }

    /**
     * 解析
     */
    private function show(){

        // 注入管理员信息
        $this->_tpl->assign('docInfo',$this->_model->getDoc($this->_page->limit,$this->_navID));

        // 注入nav筛选值
        $this->_tpl->assign('navID',$this->_navID);

        // 注入当前页码和每页显示的条数和总页数
        $this->_tpl->assign('currentPage',$this->_page->currentPage);
        $this->_tpl->assign('pageCount',PAGE_COUNT);
        $this->_tpl->assign('pageCountTotal',$this->_page->pageCountTotal);

        // 注入主导航(栏目)
        $this->_tpl->assign('docOptions',$this->_getDocFrontNavOptions());

    }


    /**
     * 数据检测类
     */
    private function validate($mode){

        switch ($mode) {
            case 'add':

                // 处理复选框值
                $_POST['front'] = empty($_POST['front'])?0:$_POST['front'];
                $_POST['rec'] = empty($_POST['rec'])?0:$_POST['rec'];
                $_POST['bold'] = empty($_POST['bold'])?0:$_POST['bold'];
                $_POST['skip'] = empty($_POST['skip'])?0:$_POST['skip'];

                // 检测数据是否完整提交
                if (
                    !isset($_POST['author']) ||
                    !isset($_POST['color']) ||
                    !isset($_POST['comment']) ||
                    !isset($_POST['count']) ||
                    !isset($_POST['info']) ||
                    !isset($_POST['keyword']) ||
                    !isset($_POST['limit']) ||
                    !isset($_POST['nav']) ||
                    !isset($_POST['sort']) ||
                    !isset($_POST['source']) ||
                    !isset($_POST['tag']) ||
                    !isset($_POST['title']) ||
                    !isset($_POST['thumbnail']) ||
                    !isset($_POST['content']) ||
                    !isset($_POST['front']) ||
                    !isset($_POST['rec']) ||
                    !isset($_POST['bold']) ||
                    !isset($_POST['skip'])
                    ) {
                    exit('*101 你还有未填写的表单项');
                }

                $dataArray = [
                        $_POST['author'],
                        $_POST['color'],
                        $_POST['comment'],
                        $_POST['count'],
                        $_POST['info'],
                        $_POST['keyword'],
                        $_POST['limit'],
                        $_POST['nav'],
                        $_POST['sort'],
                        $_POST['source'],
                        $_POST['tag'],
                        $_POST['title'],
                        $_POST['thumbnail'],
                        $_POST['content'],
                        $_POST['front'],
                        $_POST['rec'],
                        $_POST['bold'],
                        $_POST['skip']
                    ];

                // 检测数据值是否为空
                if (validate::checkNull($dataArray,1)) {
                    exit('*102 你还有未填写的表单项');
                }


                //////////////////
                // 检测各字段值是否符合要求 //
                //////////////////

                // author
                if (validate::checkLength($_POST['author'],10,true)) {
                    exit('*201 作者长度不得大于10字节');
                }
                // color
                if (validate::checkLength($_POST['color'],10,true)) {
                    exit('*202 颜色长度不得大于10字节');
                }
                // comment
                if (validate::checkLength($_POST['comment'],1,true)) {
                    exit('*203 评论选项数值错误');
                }
                // count
                if (!is_numeric($_POST['count']) || (int)$_POST['count']<0 || (int)$_POST['count']>=10000000) {
                    exit('*204 浏览次数数值错误');
                }
                // info
                if (validate::checkLength($_POST['info'],200,true)) {
                    exit('*205 内容摘要数值错误');
                }
                // keyword
                if (validate::checkLength($_POST['keyword'],30,true)) {
                    exit('*206 关键字数值错误');
                }
                // limit
                if (!is_numeric($_POST['limit']) || (int)$_POST['limit']<0 || (int)$_POST['limit']>=100000000000) {
                    exit('*207 阅读权限数值错误');
                }
                // nav
                if (!is_numeric($_POST['nav']) || (int)$_POST['nav']<0 || (int)$_POST['nav']>=10000000) {
                    exit('*208 栏目数值错误');
                }
                // sort
                if (!is_numeric($_POST['sort']) || (int)$_POST['sort']<0 || (int)$_POST['sort']>=1000) {
                    exit('*209 排序数值错误');
                }
                // source
                if (validate::checkLength($_POST['source'],20,true)) {
                    exit('*20A 内容来源数值错误');
                }
                // tag
                if (validate::checkLength($_POST['tag'],30,true)) {
                    exit('*20B 标签数值错误');
                }
                // title
                if (validate::checkLength($_POST['title'],50,true)) {
                    exit('*20C 标题数值错误');
                }
                // thumbnail
                if (validate::checkLength($_POST['thumbnail'],100,true)) {
                    exit('*20D 缩略图数值错误');
                }
                // gold
                if (!is_numeric($_POST['gold']) || (int)$_POST['gold']<0 || (int)$_POST['gold']>=100000) {
                    exit('*20E 缩略图数值错误');
                }
                // front
                if (validate::checkLength($_POST['front'],5,true)) {
                    exit('*20F 属性数值错误');
                }
                // rec
                if (validate::checkLength($_POST['rec'],3,true)) {
                    exit('*20G 属性数值错误');
                }
                // bold
                if (validate::checkLength($_POST['bold'],4,true)) {
                    exit('*20H 属性数值错误');
                }
                // skip
                if (validate::checkLength($_POST['skip'],4,true)) {
                    exit('*20I 属性数值错误');
                }
                break;

            case 'delete':
                if (!is_numeric($_POST['id']) || floor($_POST['id'])<0) {
                    exit('*301 文档id值有误');
                }
                break;
            
            default:
                Tool::alertExit('*401 未知操作');
                break;
        }

    }

    /**
     * 初始化分页
     */
    private function _pageInit(){

        // 实例化分页类
        $this->_page = new Page($this->_model->getDocCount());

        // 设置当前页
        $this->_page->currentPage = (empty($_GET['page']) || !is_numeric($_GET['page'])) ? 1:$_GET['page'];

        // 计算相应值
        $this->_page->count();

    }


    private function _getDocFrontNavOptions(){

        // 定义导航下拉菜单字符串
        $navSelectString = '';
        $indent = 0;

        // 实例化导航模型类
        $_nav = new NavModel();

        function getString(&$_nav,&$navSelectString,&$indent,$pid='0'){

            // 如果该导航没有子导航,就不输出
            if(!$res=$_nav->getAllChildNav($pid)){
                return false;
            }else{
                // 增加缩进
                $indent++;
                $optgroupIndent = '';
                foreach ($res as $v) {
                    // 检测每个导航是否有子导航
                    if($_nav->getAllChildNav($v->id)){
                        $navSelectString .= '<optgroup label="'.$v->nav_name.'">';
                        getString($_nav,$navSelectString,$indent,$v->id);
                        $navSelectString .= '</optgroup>'; 
                    }else{
                        // if ($pid==0) {
                        //     $navSelectString .= '<optgroup label="'.$v->nav_name.'"></optgroup>';
                        // }else{
                            $navSelectString .= '<option value="'.$v->id.'">'.$v->nav_name.'</option>';
                        // }
                    }
                }
                return true;
            }

        }

        getString($_nav,$navSelectString,$indent);

        $_nav = null;

        // 获取所有导航并进行字符串处理
        return '<select name="nav" required=""><option selected="" value="">请选择一个栏目类别</option>'.$navSelectString.'</select>';

    }

    /**
     * 检测ID值
     * @param  string $navID nav id
     */
    private function _checkNavID($navID){

        if (!is_numeric($navID) || floor($navID)<=0) {
            Tool::alert('test'.$navID);
            Tool::locationExit('./index.php');
        }

    }

    /**
     * 返回后台修改文章时的内容
     * @return string document information JSON string
     */
    private function _getUpdateDocInfo(){

        $info = $this->_model->getUpdateDocInfo(floor($_GET['updateDoc']));
        $info[0]->content = htmlspecialchars_decode(stripslashes($info[0]->content));
        if ($info && json_encode($info[0])) {
            return json_encode($info[0]);
        }else{
            return '{"_error":"null"}';
        }

    }


}