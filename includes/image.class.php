<?php
/**
 * 图像处理类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-09-03 09:25:05
 * @version 1.0
 */

class Image {
    
    public   $path;
    private  $_width;
    private  $_height;
    private  $_thumbWidth;
    private  $_thumbHeight;
    private  $_type;
    private  $_img;

    public function __construct($path,$size=[],$text=''){

        // 初始化参数
        $this->_getParameter($path,$size,$text);

        // 生成缩略图
        $this->_thumb($size);

        // 生成水印
        $this->_text($text);

        // 生成图像
        $this->_outputImage();

    }

    /**
     * 初始化参数
     * @param  string $path path
     */
    private function _getParameter($path,$size,$text){

        // 获取路径
        $this->path = $path;

        // 获取原图像尺寸
        $info = getimagesize($path);
        $this->_width  = $info[0];
        $this->_height = $info[1];

        // 获取缩略图尺寸
        list($this->_thumbWidth,$this->_thumbHeight) = $this->_getThumbSize($size);

        // 获取水印文字
        $this->_text = (empty($text) || !is_string($text))?'':$text;

        // 获取文件类型
        $this->_type = $this->_getImageType($info[2]);

        // 获取图像句柄
        $this->_img = $this->_getImageResource();

    }

    /**
     * 获取缩略图尺寸值
     * @param  array $size size info array
     * @return array       thumbnail image size array 
     */
    private function _getThumbSize($size){

        // 如果未设定尺寸值,就不生成缩略图
        if (empty($size)) {
            return [$this->_width,$this->_height];
        }

        // 判断是否传值
        if (!is_array($size) || empty($size['width']) || empty($size['height'])) {
            Tool::alertExit('error: !101 服务器内部出错');
        }

        // 判断尺寸值
        if ((!is_int($size['width']) && !is_int($size['height'])) || (is_int($size['width']) && $size['width']<=0) || (is_int($size['height']) && $size['height']<=0)) {
            Tool::alertExit('error: !102 服务器内部出错');
        }

        // 计算固定宽度或高度时的尺寸值
        if (is_int($size['width']) && !is_int($size['height'])) {
            $size['height'] = (int)ceil($this->_height*($size['width']/$this->_width));
        }else if(!is_int($size['width']) && is_int($size['height'])){
            $size['width'] = (int)ceil($this->_width*($size['height']/$this->_height));
        }

        return [$size['width'],$size['height']];

    }


    /**
     * 获取文件类型
     * @param  int      $param  image type
     * @return string           image type
     */
    private function _getImageType($param){

        switch ($param) {
            case 1:
                return 'gif';
                break;
            
            case 2:
                return 'jpeg';
                break;

            case 3:
                return 'png';
                break;

            default:
                Tool::alertExit('error: !201 本系统不支持该格式图片');
                break;
        }

    }

    /**
     * 获取图像句柄
     * @return resource image resource
     */
    private function _getImageResource(){

        $fun = 'imagecreatefrom'.$this->_type;
        if ($resource=$fun($this->path)) {
            return $resource;
        }else{
            Tool::alertExit('error: !301 图像获取失败');
        }
        
    }

    /**
     * 使用处理后的图像覆盖原图像
     */
    private function _outputImage(){

        $fun = 'image'.$this->_type;
        $fun($this->_img,$this->path);
        imagedestroy($this->_img);

    }

    /**
     * 生成缩略图
     */
    private function _thumb(){

        // Tool::alertExit('原图像尺寸:'.$this->_width.','.$this->_height.'\n缩略图尺寸:'.$this->_thumbWidth.','.$this->_thumbHeight);

        // 如果不需要生成缩略图就跳出
        if ($this->_width==$this->_thumbWidth && $this->_height==$this->_thumbHeight) {
            return false;
        }

        $thumbImage = imagecreatetruecolor($this->_thumbWidth,$this->_thumbHeight);

        if (!imagecopyresampled($thumbImage,$this->_img,0,0,0,0,$this->_thumbWidth,$this->_thumbHeight,$this->_width,$this->_height)) {
            Tool::alertExit('error: !401 缩略图生成失败');
        }

        $this->_img = $thumbImage;

    }

    /**
     * 添加水印
     * @param  string $text text
     */
    private function _text($text){

        // 如果没有设置水印内容就跳出
        if (empty($this->_text)) {
            return false;
        }

        $color = imagecolorallocate($this->_img, 244, 244, 244);
        imagettftext($this->_img, 12, 0, 12, $this->_thumbHeight-12, $color, 'C:\Windows\Fonts\msyh.ttf', $this->_text);

    }


}