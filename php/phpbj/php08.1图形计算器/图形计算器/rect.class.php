<?php
/** 矩形类, 继承抽象类**/
    class Rect extends Shape{
        private $width;
        private $height;

        function __construct($arr = array()){
            $this->name = '矩形';
            if(!empty($arr)){
                $this->width = $arr['width'];
                $this->height = $arr['height'];
            }
        }

        function area (){
            return $this->width * $this->height;
        }
        function girth (){
            return 2*($this->width + $this->height);
        }
        function view (){
            $form = '<form action = "test.php?action=rect" method="post">';
            $form.= $this->name.'的宽度是: <input type="text" name="width" value="'.$_POST["width"].'" /><br>';
            $form.= $this->name.'的高度是: <input type="text" name="height" value="'.$_POST["height"].'" /><br>';
            $form.= '<input type="submit" name="submit" value="提交" /><br>';
            $form.= '</form>';
            echo $form;
        }
        function verify ($arr){
            $mark = true;
            if($arr['width']<=0){
                $mark = false;
                echo $this->name."的宽度不能小于或等于零<br>";
            }
            if($arr['height']<=0){
                $mark = false;
                echo $this->name."的高度不能小于或等于零<br>";
            }
            return $mark;
        }
        
    }