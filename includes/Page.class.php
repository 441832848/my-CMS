<?php
/**
 * 分页类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-11 10:14:26
 * @version 1.0
 */

class Page {
    
    // 结果集条数
    public $count;
    // 当前页码
    public $currentPage;
    // 总页数
    public $pageCountTotal;
    // limit值
    public $limit;

    /**
     * 获取结果总条数
     * @param int $count 结果集条数
     */
    public function __construct($count){
        if (is_numeric($count) && $count>=0) {
            $this->count = $count;
        }else{
            exit('error: ~101 result count parameter error');
        }
    }

    /**
     * 设置相应值
     */
    public function count($pageType='admin'){

        // 获取每页显示条数
        if (strtolower($pageType) == 'admin') {
            $pageCount = PAGE_COUNT;
        }else if (strtolower($pageType) == 'front') {
            $pageCount = FRONT_PAGE_COUNT;
        }else{
            exit('error: ~201 page count parameter error');
        }

        // 计算总页数
        $this->pageCountTotal = ceil($this->count/$pageCount);

        // 如果请求的页码大于总页数,就到第一页
        if ($this->currentPage>$this->pageCountTotal || $this->currentPage<=0) {
            $this->currentPage = 1;
            $this->limit = 0;
        }else{
            $this->limit = ($this->currentPage-1)*$pageCount;
        }

    }



}