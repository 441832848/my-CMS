<?php
    /**
    *   模版类
    */
    class Templates{
        
        //创建变量数组
        public $_vars=[];
        public $_config=[];
        private $_cacheFileURIName=null;            // 缓存文件URI参数部分
        private $_isCache=false;                    // 记录是否开启缓冲区

        public function __construct(){

            if (!is_dir(TPL_DIR) || !is_dir(TPL_C_DIR) || !is_dir(CACHE_DIR)) {
                exit('error: 相关文件夹缺失,请手动添加');
            }

            // 判断是否开启缓冲区[后台页面不缓存] 
            if (IS_CACHE && Tool::checkCache()) {
                // 获取缓存文件URI部分
                $this->_cacheFileURIName = Tool::getURLRequest();
                $this->_isCache = true;
                ob_start();
            }

            /* 载入系统变量 */

            $_sxe = simplexml_load_file(ROOT_PATH.'/config/test.xml');
            $_taglib = $_sxe->taglib;

            foreach ($_taglib as $value) {
                $this->_config["$value->name"] = $value->value;
            }
            // print_r($this->_config);
            


        }


        public function _cache($_file){

            if ($this->_cacheFileURIName === null) {
                return false;
            }

            // 模版文件路径
            $_tplFile = TPL_DIR.$_file;

            if (!file_exists($_tplFile)) {
                exit('error: 模版文件不存在-1'.$_tplFile);
            }

            // 编译文件路径
            $_parFile = TPL_C_DIR.md5($_file).$_file.'.php';

            // 缓存文件路径
            $_caFile = CACHE_DIR.md5($_file).$_file.$this->_cacheFileURIName.'.html';
            
            // 这里增加了编译文件必须存在的条件
            // 如果设置开启缓冲区,并且再次载入页面,并且模版文件和编译文件都未被修改,就直接载入缓存文件
            if ($this->_isCache && file_exists($_caFile) && file_exists($_parFile) && filemtime($_tplFile)<filemtime($_caFile) && filemtime($_parFile)<filemtime($_caFile)) {
                ob_end_clean();
                echo '<script>console.log(\'load cache file ...\');</script>';
                include_once($_caFile);
                exit();
            }

        }


        /* 载入模版文件,生成编译文件 */
        public function _display($_file){


            // 模版文件路径
            $_tplFile = TPL_DIR.$_file;

            if (!file_exists($_tplFile)) {
                exit('error: 模版文件不存在-2');
            }

            // 编译文件路径
            $_parFile = TPL_C_DIR.md5($_file).$_file.'.php';

            // 缓存文件路径
            $_caFile = CACHE_DIR.md5($_file).$_file.$this->_cacheFileURIName.'.html';
            
            // 如果编译文件不存在或模版文件修改过,就进行编译操作,最终生成编译文件
            if (!file_exists($_parFile) || filemtime($_tplFile) > filemtime($_parFile)) {
                // //生成编译文件
                // file_put_contents($_parFile, file_get_contents($_tplFile));

                //引入模版解析类
                include_once(ROOT_PATH.'/includes/Parser.class.php');

                $_parser = new Parser($_tplFile);
                $_parser -> _compile($_parFile);

            }

            if (!file_exists($_parFile)) {
                exit('error: 编译文件不存在');
            }

            // 输出编译文件
            require_once($_parFile);
            
            // 如果设置开启缓冲区或GET请求中没有NC参数就就生成缓存文件
            if ($this->_isCache && $this->_cacheFileURIName!==null) {
                file_put_contents($_caFile,ob_get_contents());
            }
            

            // ob_end_clean();

        }


        /* 导入参数 */
        public function assign($_name,$_value){

            if (isset($this->_vars) && !empty($_name)) {
                $this->_vars[$_name] = $_value;

            }else{
                exit('error: 参数导入错误');
            }

        }
    }
