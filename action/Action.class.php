<?php
/**
 * 控制器基类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-08 10:02:46
 * @version $Id$
 */

class Action {
    
    public $_tpl;
    protected $_model;

    protected function __construct(&$_tpl,&$_model){
        
        $this->_tpl = $_tpl;
        $this->_model = $_model;

    }

}