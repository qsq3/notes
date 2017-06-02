<?php
    //三角形模块
    class Triangle extends Shape{
        private $side1;
        private $side2;
        private $side3;

        function __construct($arr = array()){
            $this->name = '三角形';
            if(!empty($arr)){
                $this->side1 = $arr['side1'];
                $this->side2 = $arr['side2'];
                $this->side3 = $arr['side3'];
            }
        }

        function area (){
            $p = $this->girth()/2;
            return sqrt($p*($p-$this->side1)*($p-$this->side2)*($p-$this->side3));
        }
        function girth (){
            return $this->side1 + $this->side2 + $this->side3;
        }
        function view (){
            $form = '<form action = "test.php?action=triangle" method="post">';
            $form.= $this->name.'的边一是: <input type="text" name="side1" value="'.$_POST["side1"].'" /><br>';
            $form.= $this->name.'的边二是: <input type="text" name="side2" value="'.$_POST["side2"].'" /><br>';
            $form.= $this->name.'的边三是: <input type="text" name="side3" value="'.$_POST["side3"].'" /><br>';
            $form.= '<input type="submit" name="submit" value="提交" /><br>';
            $form.= '</form>';
            echo $form;
        }
        function verify ($arr){
            $mark = true;
            if($arr['side1']<=0){
                $mark = false;
                echo $this->name."的side1不能小于或等于零<br>";
            }
            if($arr['side2']<=0){
                $mark = false;
                echo $this->name."的side2不能小于或等于零<br>";
            }
            if($arr['side3']<=0){
                $mark = false;
                echo $this->name."的side3不能小于或等于零<br>";
            }
            if(( ($arr['side1']+$arr['side2']) <= $arr['side3'] ) || ( ($arr['side1']+$arr['side3']) <= $arr['side2'] ) || ( ($arr['side2']+$arr['side3']) <= $arr['side1'] )){
                $mark = false;
                echo $this->name."的两边之和要大于第三边<br>";
            }
            return $mark;
        }
        
    }