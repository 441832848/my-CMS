<?php
    /**
    *   模版解析类
    */
    class Parser{
        
        private $_tpl;

        public function __construct($_tplFile){

            // 判断文件是否可读
            if(!$this->_tpl = file_get_contents($_tplFile)){
                exit('error: 模版文件读取错误');
            }

        }

        /* 解析普通变量 */
        private function _parVar(){

            $_mode2 = '/\{\$(\w+)(\-\>\w+)\}/';
            if(preg_match($_mode2,$this->_tpl)){
                $this->_tpl = preg_replace($_mode2,'<?php if(isset($this->_vars[\'\\1\']\\2)) echo $this->_vars[\'\\1\']\\2;?>',$this->_tpl);
            }

            $_mode = '/\{\$(\w+)\}/';
            if(preg_match($_mode,$this->_tpl)){
                $this->_tpl = preg_replace($_mode,'<?php if(isset($this->_vars[\'\\1\'])) echo $this->_vars[\'\\1\'];?>',$this->_tpl);
                return false;
            }
        }

        /* 解析if语句 */
        private function _parIf(){
            $_if = '/\{if\s+\$(\w+)\}/';
            $_ifEnd = '/\{\/if\}/';
            $_else = '/\{else\}/';
            if (preg_match($_if,$this->_tpl)) {
                if (preg_match($_ifEnd,$this->_tpl)) {
                    $this->_tpl = preg_replace($_if,'<?php if(!empty($this->_vars[\'\\1\']) && !!$this->_vars[\'\\1\']){ ?>',$this->_tpl);
                    $this->_tpl = preg_replace($_ifEnd,'<?php } ?>',$this->_tpl);
                    if (preg_match($_else,$this->_tpl)) {
                        $this->_tpl = preg_replace($_else,'<?php }else{ ?>',$this->_tpl);
                    }
                }else{
                    exit('error: if语句错误');
                }
            }

        }

        /* 解析注释 */
        private function _parCommon(){
            if (preg_match('/\{#\}/',$this->_tpl)) {
                $this->_tpl = preg_replace('/\{#\}(.*)\{#\}/','<?php /* \1 */ ?>',$this->_tpl);
            }
        }

        /* 解析foreach语句 */
        private function _parForeach(){
            $_foreach = '/\{foreach\s+\$(\w+)\((\w+),(\w+)\)\}/';
            $_foreachEnd = '/\{\/foreach\}/';
            $_foreachVar = '/\{@(\w+)(\-\>\w+)*\}/';

            if (preg_match($_foreach,$this->_tpl)) {
                if (preg_match($_foreachEnd,$this->_tpl)) {
                    if (preg_match($_foreachVar,$this->_tpl)) {
                        $this->_tpl = preg_replace($_foreachVar,'<?php echo $\1\2; ?>',$this->_tpl);
                    }
                    $this->_tpl = preg_replace($_foreach,"<?php foreach(\$this->_vars['\\1'] as \$\\2 => \$\\3){ ?>",$this->_tpl);
                    $this->_tpl = preg_replace($_foreachEnd,'<?php } ?>',$this->_tpl);

                }else{
                    exit('error: foreach语句错误');
                }
            }
        }

        /* 解析include语句 */
        private function _parInclude(){

            $_include = '/\{include\s+file=(\"|\')([\w\.\-\/]+)(\"|\')\}/';

            if (preg_match_all($_include,$this->_tpl,$_file)) {

                // 遍历获取文件名
                foreach ($_file[2] as $value) {
                    if (!file_exists(ROOT_PATH.'/templates/'.$value)) {
                        exit('error: include语句错误'.ROOT_PATH.'/templates/'.$value);
                    }
                    // 判断文件是否是html或tpl文件
                    if (substr($value,strrpos($value,'.')+1) == 'html') {
                        $this->_tpl = preg_replace($_include,'<?php require_once("../templates/\\2"); ?>',$this->_tpl);
                        return true;
                    }else if (substr($value,strrpos($value,'.')+1) != 'tpl') {
                        exit('error: 文件类型错误');
                    }
                    $this->_tpl = preg_replace($_include,'<?php $this->_display("\\2"); ?>',$this->_tpl);

                }
            }

        }


        /* 解析系统变量 */
        private function _parConfig(){
            $_config = '/<!--\s{0,3}\{(\w+)\}\s{0,3}-->/';

            if (preg_match($_config,$this->_tpl)) {
                $this->_tpl = preg_replace($_config,'<?php echo $this->_config[\'\\1\']; ?>',$this->_tpl);
            }
        }


        /* 操作模版文件 */
        public function _compile($_parFile){

            // 解析模版文件
            if ($this->_parInclude()) {
                $this->_parse($_parFile);
                return false;
            }
            $this->_parVar();
            $this->_parIf();
            $this->_parCommon();
            $this->_parForeach();
            $this->_parConfig();

            // 生成编译文件
            $this->_parse($_parFile);

        }

        /**
         * 生成编译文件
         * @param  string $_parFile 编译文件路径
         */
        private function _parse($_parFile){
            // 生成编译文件
            if (!file_put_contents($_parFile, $this->_tpl)){
                exit('error: 生成编译文件错误');
            }
        }



    }