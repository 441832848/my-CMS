<?php
/**
 * 验证码类
 * @authors Sc (hellosc@qq.com)
 * @date    2016-08-14 09:04:49
 * @version 1.0
 */

class ValidateCode {
    
    // 验证码字符
    private $_char = 'qwertyupasdfghkzxcvbnmQWERTYUPASDFGHKZXCVBNM23456789';
    private $_validateCode = '';
    private $_width = 120;
    private $_height = 40;
    private $_imagePath = '';

    /**
     * 生成验证码
     * @param string    $imagePath  path
     * @param int       $width      width
     * @param int       $height     height
     */
    function __construct($imagePath=null,$width=null,$height=null){

        // 初始化配置
        $this->_init($imagePath,$width,$height);

        // 生成验证码
        $this->_createValidateCode();

    }

    /**
     * 初始化配置
     * @param  string   $imagePath  path
     * @param  int      $width      width
     * @param  int      $height     height
     */
    private function _init($imagePath,$width,$height){

        // 初始化验证码尺寸
        if (is_int($width) && is_int($height) && $width>0 && $height>0) {
            $this->_width = $width;
            $this->_height = $height;
        }
        
        // 初始化验证码图片路径
        if (is_string($imagePath) && file_exists($imagePath)) {
            $this->_imagePath = $imagePath;
        }else{
            $this->_imagePath = ROOT_PATH.'\\images\\vc.png';
        }

    }

    /**
     * 生成验证码
     */
    private function _createValidateCode(){

        // 生成字符串
        $this->_createCode();

        // 写入session
        $this->_inputSession();

        // 生成图片
        $this->_createValidateImage();

    }

    /**
     * 生成字符串
     */
    private function _createCode(){

        // 生成字符串
        for ($code=0; $code < 4; $code++) { 
            $this->_validateCode .= $this->_char[mt_rand(0,strlen($this->_char)-1)];
        }

    }

    /**
     * 生成图片
     */
    private function _createValidateImage(){

        // 创建
        $image = imagecreatetruecolor($this->_width,$this->_height);
        $imageBackgroundColor = imagecolorallocate($image, mt_rand(210,233), mt_rand(210,233), mt_rand(210,233));

        // 填充底色
        imagefill($image,0,0,$imageBackgroundColor);

        // 干扰点
        for ($pixel=0; $pixel < 130; $pixel++) { 
            imagesetpixel($image, mt_rand(0,$this->_width), mt_rand(0,$this->_height), imagecolorallocate($image,mt_rand(0,200),mt_rand(0,200),mt_rand(0,200)));
        }
        
        // 干扰线
        for ($line=0; $line < 20; $line++) { 
            imageline($image, mt_rand(0,$this->_width), mt_rand(0,$this->_height), mt_rand(0,$this->_width), mt_rand(0,$this->_height), imagecolorallocate($image, mt_rand(100,200), mt_rand(100,200), mt_rand(100,200)));
        }

        // 字符串
        for ($str=0; $str < 4; $str++) { 
            imagettftext($image,
                        floor($this->_height*0.6),mt_rand(-30,30),
                        floor($this->_height*0.65)*$str+($this->_width-floor($this->_height*0.65)*4 > 0 ? $this->_width-floor($this->_height*0.65)*4 : 0),
                        mt_rand(floor($this->_height*0.6),$this->_height*0.9),
                        imagecolorallocate($image,mt_rand(50,200),mt_rand(50,200),mt_rand(50,200)),
                        'C:\Windows\Fonts\msyh.ttf',
                        $this->_validateCode[$str]);
        }

        // 生成图片
        imagepng($image,$this->_imagePath);

        // 清理图片
        imagedestroy($image);

    }

    /**
     * 写入session
     */
    private function _inputSession(){

        // 尝试开启session
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // 写入session
        $_SESSION['validateCode'] = $this->_validateCode;

    }

    /**
     * 输出验证码
     */
    public function loadImage(){
        header('Content-type:image/png');
        $img = imagecreatefrompng($this->_imagePath);
        imagepng($img);
    }

}