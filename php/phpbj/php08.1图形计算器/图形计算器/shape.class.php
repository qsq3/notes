<?php
    /** 形状的抽象类 **/
    abstract class Shape{
        public $name;

        abstract function area();
        abstract function girth();
        abstract function view();
        abstract function verify($arr);

    }