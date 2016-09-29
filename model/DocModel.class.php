<?php
/**
 * 导航实体类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-06 09:05:42
 * @version 1.0
 */

class DocModel extends Model{

    private $_documents = [];               // 文章列表
    private $_hasDocument = false;          // 导航中(包括子导航)是否有文章
    private $_documentCount = 0;            // 文章数量
    private $_navChilds = '';               // (子)导航

    /**
     * 添加一篇文档
     * @param string $author  作者
     * @param string $color   标题颜色
     * @param string $comment 是否允许评论
     * @param string $count   浏览次数
     * @param string $info    内容摘要
     * @param string $keyword 关键字
     * @param string $limit   权限
     * @param string $nav     所在栏目
     * @param string $sort    文档排序[置顶]
     * @param string $source  文章来源
     * @param string $tag     标签
     * @param string $title   标题
     * @param string $front   头条
     * @param string $rec     推荐
     * @param string $bold    加粗
     * @param string $skip    跳转
     */
    public function addDoc($author,$color,$comment,$count,$info,$keyword,$limit,$nav,$sort,$source,$tag,$title,$front,$rec,$bold,$skip,$thumbnail,$content,$gold){

        // 处理attr字段
        $attr = '';
        if ($front != '0') {
            $attr .= 'front,';
        }
        if ($rec != '0') {
            $attr .= 'rec,';
        }
        if ($bold != '0') {
            $attr .= 'bold,';
        }
        if ($skip != '0') {
            $attr .= 'skip,';
        }
        if (strlen($attr) == 0) {
            $attr = 'none,';
        }
        $attr = substr($attr,0,strlen($attr)-1);

        // 处理content字段
        $content = (empty(trim($content)) ? null : addslashes(htmlspecialchars(trim($content))));
        if ($content === null) Tool::alertExit('请填写文章内容');

        // 处理thumbnail字段
        $thumbnail = preg_replace('/\\\\/','/',$thumbnail);

        // 定义返回信息
        $this->_info = 'add document error...';

        // 组织sql语句
        $this->_sql = " insert into
                            cms_doc(author,color,comment,count,info,keyword,limits,nav,sort,source,tag,title,attr,date,thumbnail,content)
                        values
                            ('{$author}','{$color}','{$comment}','{$count}','{$info}','{$keyword}','{$limit}','{$nav}','{$sort}','{$source}','{$tag}','{$title}','{$attr}','".date('Y-m-d H:i:s',time())."','{$thumbnail}','{$content}')
                        ;";

        // 执行sql并获取信息
        $resultStr = parent::ADU();

        return $resultStr;

    }


    public function updateDoc($author,$color,$comment,$count,$info,$keyword,$limit,$nav,$sort,$source,$tag,$title,$front,$rec,$bold,$skip,$thumbnail,$content,$gold,$id){

        // 处理attr字段
        $attr = '';
        if ($front != '0') {
            $attr .= 'front,';
        }
        if ($rec != '0') {
            $attr .= 'rec,';
        }
        if ($bold != '0') {
            $attr .= 'bold,';
        }
        if ($skip != '0') {
            $attr .= 'skip,';
        }
        if (strlen($attr) == 0) {
            $attr = 'none,';
        }
        $attr = substr($attr,0,strlen($attr)-1);

        // 处理content字段
        $content = (empty(trim($content)) ? null : addslashes(htmlspecialchars(trim($content))));
        if ($content === null) Tool::alertExit('请填写文章内容');

        // 处理thumbnail字段
        $thumbnail = preg_replace('/\\\\/','/',$thumbnail);

        // 定义返回信息
        $this->_info = 'udpate document error...';

        // 组织sql语句
        $this->_sql = " update
                            cms_doc
                        set
                            author='{$author}',color='{$color}',comment='{$comment}',count='{$count}',info='{$info}',keyword='{$keyword}',limits='{$limit}',nav='{$nav}',sort='{$sort}',source='{$source}',tag='{$tag}',title='{$title}',attr='{$attr}',date='".date('Y-m-d H:i:s',time())."',thumbnail='{$thumbnail}',content='{$content}' 
                        where 
                            id={$id}
                        ;";

        // 执行sql并获取信息
        $resultStr = parent::ADU();

        return $resultStr;

    }

    public function deleteDoc($id){

        $this->_info = 'delete document error...';

        // 组织sql语句
        $this->_sql = " delete from 
                            cms_doc
                        where 
                            id={$id}
                        ;";

        // 执行sql并获取信息
        return parent::ADU();

    }

    /**
     * 更新点击量
     * @param  string $id document id
     */
    public function updateClicks($id){
        // 组织sql语句
        $this->_sql = " update 
                            cms_doc
                        set 
                            count=count+1
                        where 
                            id={$id}
                        ;";

        // 执行sql
        parent::ADU();
    }

    /**
     * 获取点击量
     * @param  string $id document id
     */
    public function getClicks($id){
        // 组织sql语句
        $this->_sql = " select  
                            count 
                        from  
                            cms_doc
                        where 
                            id={$id}
                        ;";

        // 执行sql
        return parent::selectAll();
    }

    /**
     * 检测该导航是否有文章
     * @param  string $nav  nav id
     * @return int          affected rows
     */
    public function checkNavDoc($nav){

        return ($this->_documentCount>0 ? true : false);

    }

    /**
     * 获取文章模块 [标题/缩略图/日期/点击量/内容摘要]
     * @param  string $nav nav id
     * @return object      result
     */
    public function getDocModule($nav,$page){

        // 组织sql语句
        $this->_sql = "select
                            id,title,thumbnail,date,count,info,nav
                        from 
                            cms_doc
                        where
                            nav in (".$this->_navChilds.")
                        limit
                            ".($page-1).",".FRONT_PAGE_COUNT."
                        ;";

        // 获取文章
        if (!!$this->_documents = parent::selectAll()) {
            
            foreach ($this->_documents as $key => $value) {
                
                // 获取nav_name
                $this->_sql = "select
                                    nav_name
                                from 
                                    cms_nav
                                where
                                    id=".$value->nav."
                                ;";

                $this->_documents[$key]->nav_name = parent::selectAll()[0]->nav_name;

            }

            return $this->_documents;

        }else{

            return false;

        }

    }


    public function getListDocCount($nav,&$navModel){

        // 获取所有(子)导航id值
        $this->_getNavChilds($nav,$navModel);

        // 处理_navChilds值
        $this->_navChilds = substr($this->_navChilds,0,strlen($this->_navChilds)-1);

        // 生成nav值数组
        $navArr = explode(',',$this->_navChilds);

        // 遍历所有(子)导航id值,获取该导航下的所有文章
        foreach ($navArr as $value) {

            // 组织sql语句
            $this->_sql = "select
                                id
                            from 
                                cms_doc
                            where
                                nav={$value}
                            ;";

            parent::selectAll();

            $this->_documentCount += (int)$this->_affectedRows;

        }

        return $this->_documentCount;

    }

    /**
     * 获取所有子导航id
     * @param  string $nav       nav id
     * @param  object &$navModel Model
     */
    private function _getNavChilds($nav,&$navModel){

        // 存入导航id数组
        $this->_navChilds .= $nav.',';

        // 获取子导航
        if (!!$navArr = $navModel->getAllChildNav($nav)) {
            foreach ($navArr as $value) {
                $this->_getNavChilds($value->id,$navModel);
            }
        }
        
    }

    /**
     * 获取前台显示的文章内容
     * @param  string $id document id
     * @return mixed     result array or FALSE
     */
    public function getDocDetail($id){

        // 检测该文章阅读权限
        # code...

        // 组织sql语句
        $this->_sql = "select
                            d.info,d.title,d.tag,d.thumbnail,d.source,d.author,d.content,d.color,d.date,d.attr,d.comment,d.count,d.gold,d.limits,n.nav_name,n.id
                        from 
                            cms_doc d,cms_nav n
                        where
                            d.nav=n.id and d.id={$id}
                        ;";

        return parent::selectAll();

    }


    public function getUpdateDocInfo($id){

        // 组织sql语句
        $this->_sql = " select 
                            id,author,color,comment,count,info,keyword,limits,nav,sort,source,tag,title,attr,date,thumbnail,content,gold 
                        from 
                            cms_doc 
                        where 
                            id={$id} 
                        ;";

        // 执行sql并获取信息
        return parent::selectAll();

    }


// =====================================================

    /**
     * 查询导航信息条数
     * @return object 结果对象
     */
    public function getDocCount(){

        // 组织sql语句
        $this->_sql = "select 
                            id
                         from 
                            cms_doc
                            ;";

        // 执行sql
        parent::selectAll();
        return $this->_affectedRows;

    }

    /**
     * 查询导航数据
     * @return object 结果对象
     */
    public function getDoc($current,$navID=null){

        $navFilter = '';

        if (!empty($navID)) {
            $navFilter .= ' AND d.nav='.$navID;            
        }

        // 组织sql语句
        $this->_sql = "select 
                            d.id,d.title,d.attr,n.nav_name,d.count,d.date
                         from 
                            cms_nav n,cms_doc d
                         where
                            n.id=d.nav".$navFilter."
                         order by
                            id asc
                         limit
                            ".$current.",".PAGE_COUNT."
                            ;";

        // 返回结果数组
        return parent::selectAll();

    }


}