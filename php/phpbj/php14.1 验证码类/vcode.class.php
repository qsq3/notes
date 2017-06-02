<?php
    class Vcode{
        private $width;  //宽
        private $height; //高
        private $num;  //数量
        private $code; //验证码
        private $img; //图片资源

        //构造方法
        function __construct($width, $height, $num){
            $this->width = $width;
            $this->height = $height;
            $this->num = $num;
            $this->code = $this->createcode();
        }

        
        //获取验证码字符串,保存到服务器
        function getcode(){
            return $this->code;
        }
        
        //输出验证码图像
        function outimg(){
            //创建背景
            $this -> createbg();
            //画字
            $this -> outstring();
            //干扰元素
            $this -> setdisturbcolor();
            //输出图像
            $this -> printimg();

        }

        //创建背景
        private function createbg(){
            //创建图像资源
            $this -> img = imagecreatetruecolor($this -> width, $this -> height) or die( '无法创建 GD库 图像文件' );
            //设置随机背景色
            $bgcolor = imagecolorallocate($this -> img, rand(200, 255),rand(200, 255),rand(200, 255));
            //填充背景色
            imagefill($this -> img, 0, 0, $bgcolor);
            //画边框
            imagerectangle($this -> img, 0, 0, $this -> width -1, $this -> height -1, imagecolorallocate($this -> img, 0, 0, 0));
        }

        //画字
        private function outstring(){
            for ($i=0; $i<$this -> num; $i ++){
                $fontsize = rand(4, 5);
                $color = imagecolorallocate($this -> img, rand(0, 155),rand(0, 155),rand(0, 155));
                $x = $this->width / $this->num * $i+ 3;
                $y = rand(0, $this->height - imagefontheight ($fontsize) - 3);
                imagechar($this -> img, $fontsize, $x, $y, $this->code[$i],$color);
            }
        }

        //干扰元素
        private function setdisturbcolor(){
            //加上随机点
            for($i=0; $i<100; $i++){
                imagesetpixel($this->img,rand(1, $this-> width - 2),rand(1, $this->height - 2),imagecolorallocate($this -> img, rand(0, 255),rand(0, 255),rand(0, 255)));
            }
            
            //随机线条
            //for($i=0; $i < $this->num; $i++){imageline($this->img,rand(1, $this-> width - 2),rand(1, $this->height - 2),rand(1, $this-> width - 2),rand(1, $this->height - 2),imagecolorallocate($this -> img, rand(0, 255),rand(0, 255),rand(0, 255)));}

            //随机弧线
            for($i=0; $i < $this->num ; $i++){
                imagearc($this->img,rand(-10, $this-> width + 10),rand(-10, $this->height),rand(20, $this-> width),rand(1, $this->height /2),rand(0, 50), rand(200, 360),imagecolorallocate($this -> img, rand(0, 255),rand(0, 255),rand(0, 255)));
            }
        }
        
        //输出图像
        private function printimg(){
            // 处理输出
             if( imagetypes () &  IMG_GIF )
            {
                 // 针对 GIF
                 header ( 'Content-Type: image/gif' );

                 imagegif ( $this -> img );
            }
            elseif( function_exists ( 'imagejpeg' ))
            {
                 // 针对 JPEG
                 header ( 'Content-Type: image/jpeg' );

                 imagejpeg ( $this -> img ,  NULL ,  100 );
            }
            elseif( imagetypes () &  IMG_PNG )
            {
                 // 针对 PNG
                 header ( 'Content-Type: image/png' );

                 imagepng ( $this -> img );
            }
            elseif( function_exists ( 'imagewbmp' ))
            {
                 // 针对 WBMP
                 header ( 'Content-Type: image/vnd.wap.wbmp' );

                 imagewbmp ( $this -> img );
            }
            else
            {
                 imagedestroy ( $this -> img );

                die( 'No image support in this PHP server' );
            }

        }

        //生成验证码字符串
        private function createcode(){
            $codes='0123456789abcdefghijkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVWXY';
            $code = '';
            for ($i=0; $i<$this->num; $i++){
                $code .= $codes{rand(0,strlen($codes)-1)};
            }
            return $code;
        }
        
        //析构方法, 自动销毁图像资源
        function __destruct(){
            imagedestroy( $this -> img);
        }
    }