<?php
/**
 * 文件上传类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-26 10:08:33
 * @version 1.0
 */

class uploadFile {
    
    private $_fileFieldName;
    public  $fileName;
    public  $realFileName;
    private $_tmpFileName;
    private $_maxFileSize;
    private $_error;
    private $_imageSuffix;
    private $_uploadFileDir;
    private $_imageTypes = ['image/jpeg','image/pjpeg','image/png','image/x-png','image/gif'];
    private $_imageSuffixs = ['png','gif','jpg'];

    function __construct($fileName,$fileMaxSize=null){
        
        // 初始化参数
        $this->_getParameter($fileName,(empty($fileMaxSize)?(empty($_POST['MAX_FILE_SIZE'])?null:$_POST['MAX_FILE_SIZE']):$fileMaxSize));

        // 检测文件上传错误
        $this->_checkUploadFileError();

        // 检测文件类型
        $this->_checkFileType();

        // 检测接收文件的主目录和子目录是否可用
        $this->_checkUploadDir();

        // 更改上传文件的文件名
        $this->_getFileName();

        // 移动文件
        $this->_moveFile();


    }

    /**
     * 初始化参数
     * @param  string $fileName    文件字段名
     * @param  string $maxFileSize 文件最大值
     */
    private function _getParameter($fileName,$maxFileSize){

        // 获取文件字段名
        if (empty($fileName) || !is_string($fileName)) {
            Tool::alertExit('error: -101 非法操作');
        }
        $this->_fileFieldName = $fileName;

        // 获取前端设置的文件大小值
        if (empty($maxFileSize) || !is_numeric($maxFileSize) || $maxFileSize<=0) {
            Tool::alertExit('error: -102 文件大小超过服务器限制');
        }
        $this->_maxFileSize = $maxFileSize/1024;

        // 获取error值
        if (empty($_FILES[$this->_fileFieldName])) {
            Tool::alertExit('error: -103 请上传文件');
        }
        $this->_error = $_FILES[$this->_fileFieldName]['error'];

    }

    /**
     * 检测文件上传是否出错
     */
    private function _checkUploadFileError(){

        switch ($this->_error) {

            case '0':
                
                break;
                
            case '1':
                Tool::alertExit('error: -201 文件大小超过服务器限制');
                break;
                
            case '2':
                Tool::alertExit('error: -202 文件大小超过 '.$this->_maxFileSize.'k');
                break;
                
            case '3':
                Tool::alertExit('error: -203 文件上传失败，请重新上传');
                break;

            case '4':
                Tool::alertExit('error: -204 请上传文件');
                break;
            
            default:
                Tool::alertExit('error: -205 未知错误');
                break;
        }

    }

    /**
     * 检测文件类型
     */
    private function _checkFileType(){

        // 检测文件后缀
        $fileNameArr = explode('.',$_FILES[$this->_fileFieldName]['name']);
        $this->_imageSuffix = end($fileNameArr);
        if (!in_array($this->_imageSuffix,$this->_imageSuffixs)) {
            Tool::alertExit('error: -301 文件后缀名错误');
        }

        // 检测文件类型
        if (!in_array($_FILES[$this->_fileFieldName]['type'],$this->_imageTypes)) {
            Tool::alertExit('error: -302 文件类型错误');
        }

    }

    /**
     * 检测存放文件的主目录和子目录是否存在
     */
    private function _checkUploadDir(){

        // 主目录
        if (!is_dir(UPLOAD_DIR) || !is_writeable(UPLOAD_DIR)) {
            if (!mkdir(UPLOAD_DIR)) {
                Tool::alertExit('error: -401 服务器内部错误');
            }
        }

        // 子目录
        $this->_uploadFileDir = UPLOAD_DIR.date('Ymd');
        if (!is_dir($this->_uploadFileDir) || !is_writeable($this->_uploadFileDir)) {
            if (!mkdir($this->_uploadFileDir)) {
                Tool::alertExit('error: -402 服务器内部错误');
            }
        }

    }

    /**
     * 更改文件名
     */
    private function _getFileName(){

        // 生成文件名
        $this->fileName = $this->_uploadFileDir.'/'.date('YmdHis').mt_rand(1000,9999).'.'.$this->_imageSuffix;
        // 递归防止重复
        if (file_exists($this->fileName)) {
            $this->_getFileName();
        }

    }


    private function _moveFile(){

        // 获取临时文件路径
        $this->_tmpFileName = $_FILES[$this->_fileFieldName]['tmp_name'];
        
        if (is_uploaded_file($this->_tmpFileName)) {
            // 移动文件
            if(!move_uploaded_file($this->_tmpFileName, $this->fileName)){
                Tool::alertExit('error: -502 文件上传失败');
            }

            // 获取文件主目录格式的路径
            preg_match('/'.addslashes(preg_replace('/\//','\\\\',dirname(dirname($_SERVER['SCRIPT_NAME'])))).'(.)*/',$this->fileName,$arr);
            $this->realFileName = $arr[0];
        }else{
            Tool::alertExit('error: -501 临时文件不存在');
        }

    }






}