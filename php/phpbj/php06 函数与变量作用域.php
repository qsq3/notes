<?php
    echo "1 <br/>";
    $str = '';
    function table ($rows = 10 , $cols = 10 ,$color = 'red'){
        $str .= '<table border="1" width="800" align="center">';
        $str .= '<caption><h1>表格</h1></caption>';

        for($i=0; $i<$cols; $i++){

            $bg = ($i%2) ? $color : '';
            $str .=  '<tr bgcolor="'.$bg.'">';

            for($j=0; $j<$rows; $j++){
                $str .=  '<td>'.($i*$rows + $j).'</td>';
            }
            $str .=  '</tr>';
        }
        $str .=  '</table>';

        return $str;
        
    }
    if(function_exists('table')){
        echo '存在';
    }else{
        echo '不存在';
    }

    // 在文件中输出(没有则创建文件)
    file_put_contents('test.html' ,  table(6,8));


//变量
0.   9个 超全局数组:
      1. $_GET;
      2. $_POST;
1. 内部变量: 函数的参数也是内部变量;
2. 全局变量 : global $a , $b ; global申明后指向最顶层的全局变量;
3. 静态变量:  static $a = 0; 在同一个函数多次调用中共享; 一般用于统计一个脚本中某个函数的调用次数;
5. 和JS不一样 ,PHP 中变量默认是局部的, 函数默认是全局的(但是父函数必须先运行过,使子函数处于内存中)
eg:
    $a = 1;
    function a (){
        $a = 2;
        function b(){
            global $a;
            echo $a; // 1
        }
    }
    a(); //不执行a()就会报错;
    b(); 

4. 常规函数的参数:
    /**
    * 功能: 发送一份电子邮件
    * @param string $to 电子邮件收件人
    * @param string $subject 电子邮件的主题
    * @param string $message 邮件的内容
    * @return bool 返回发送成功与否的布尔值
    */
    bool mail  ( string $to  , string $subject  , string $message  [, string $additional_headers  [, string $additional_parameters  ]] )

5. 伪类型函数的参数:
   伪类型(只是在注释中起说明作用)
    mixed: 说明一个参数可以接受多种不同的(但并不必须是所有的)类型.
    number : 说明一个参数可以是 integer 或 float;
    callback: 有些诸如call_user_function() 或 usort()的函数接受用户自定义的函数作为一个参数. callback函数不仅可以是一个简单的函数,他还可以是一个对象的方法包括静态类的方法;

6. 引用参数:
    $a = 10;
    $b = &$a;
    1. 只有在内存中的变量才有地址;
    2. 有引用的关系的两个变量,相当于两个是一个;
    3. 如果在函数说明中, 有 & 出现, 说明这是一个引用参数, 在调用传参时, 必须传一个变量;
        function demo (&$a){
            $a++;
        }
        demo(20); //错误
        demo($b); //正确

7. 默认参数: 注意, 默认值参数 需列在 没有默认值参数 的后面;
8. 可变个数参数的函数: 
    func_get_args(); //返回参数的数组,array类型
    func_num_args(); //返回参数的总个数,int类型;
    func_get_arg();//接收一个数字参数,返回指定位置的func_get_args()的参数
    
    eg:
    function demo(){
        $arr = func_get_args();
        $sum = 0;
        
        for ($i=0; $i<count($arr); $i++){
            $sum +=$arr[$i];
        }
        /*
        for ($i=0; $i<func_num_args(); $i++){
            $sum += func_get_arg($i);
        }
        */
        return $sum;
    }
    echo demo(1,2,3,4,5).'<br/>';

9. 变量函数: 
    /**
    *如果将一个函数名称(string),给一个变量(string),然后再这个变量后加上括号,就会调用这个变量值对应的函数;
    *
    */
    function add($a, $b){
        return $a + $b;
    }
    $var = "add";
    echo $var(1,2);

10. 回调函数,系统函数: callback
    /**
    * 在使用一个函数时,如果传一个变量,不能解决问题, 就需要出将一个过程传入盜函数中,改变函数的执行行为;
    * 在函数调用时, 在参数中穿的不是一个变量或值,而是一个函数,这就是回调函数;
    * 如果一个函数的参数数量是变长时, 就不能直接调用这个函数;需借助 call_user_func_array 方法;
    * mixed  call_user_func_array  ( callable  $callback  , array $param_arr  ) ;
    */
    $arr = array(1,7,5,3,8,4,9);
    $arr = array('aaa','aaaaaa','aaaaaaaaaaaa','a','aaaaaaaaaaaaaaa','aaaaa');
    //sort($arr);
    function mycom($a,$b){
        return (strlen($a)>strlen($b)) ? 1 : -1 ;
    }
    usort($arr,'mycom');
    print_r($arr); //print_r用于输出数组
    
eg2:
    function demo($num, $fn){
        for($i=0; $i<$num; $i++){
            //if($fn($i))  //变量函数方式 ,注意,$fn 只支持 函数名称的字符串格式;
            if(call_user_func_array($fn,array($i)))
            continue;
            echo $i.'<br/>';
        }
    }
    
    function test($i){
        //if(preg_match('/3/',$i)) //匹配正则
        if($i == strrev($i)) //回文
            return true;
        return false;
    }
    
    demo(500,'test');

    class Filter{
        function one($i){ //非静态方法需创建对象来调用
            if($i%3 == 0){
                return true;
            } else {
                return false;
            }
        }
        static function two ($i){  //静态方法需用类名来调用
            if (preg_match('/3/',$i)){
                    return true;
            } else {
                return false;
            }
        }
    }
//    $filter = new Filter(); 
//    $filter->one();  //非静态方法需创建对象来调用
//    Filter::two();   //静态方法需用类名来调用
    demo(500,array(new Filter(), 'one'));  //非静态方法需创建对象来调用
    demo(500,array("Filter", "two")); //静态方法需用类名来调用
    
    demo(500, function(){  //匿名函数可直接当作参数使用;5.3后新增;
        return false;
    })

11. 递归函数:
<?php
    $dirname="./hfwl";
    
    function fordir($dirname){
        //打开目录资源;
        $dir = opendir($dirname);

        $file = readdir($dir);
        $file = readdir($dir);

        //读取目录资源
        while( $file = readdir($dir)){
            $file = $dirname."/".$file; 
            if(is_dir($file)){
                echo "这是目录: {$file} 的 递增部分 ↓<br/>";
                fordir($file);
                echo "这是目录: {$file} 的 回归部分 ↑<br/>";
            }
            else{
                echo "文件: {$file}<br/>";
            }
        }

        //关闭目录资源;
        closedir($dir);
    }

    fordir($dirname);

12. 加载自定义的函数库 ,
        include 会执行文件; 
        include_once 只加载一次; 
        require 即使在if语句内为假的情况也会载入;
        require_once;
        当处理失败时, include 产生一个警告, 而 require 产生一个致命错误;

    include "function.inc.php";
    include("function.inc.php");

13 匿名函数与闭包 ,php 5.3版本以后 ,Closure(闭包)类的 对象 , 关键字use;
    闭包函数返回时,其内部变量处于激活状态,函数所在栈区依然保留,不会被释放;
    1. 闭包外层是个函数;
    2. 闭包内部都有函数;
    3. 闭包会 return 内部函数;
    4. 闭包返回的函数内部不能有 return 了, 因为这样会结束函数;
    5. 执行闭包后, 闭包的内部变量会存在, 而闭包的内部函数的内部变量不会存在;
    
    应用场景:
    1. 保护内部变量安全;
    2. 在内存中维持一个变量;
    $fn = function(){}; //匿名函数需要加分号, 因为是赋值;
    var_dump($fn);//对象类型; object(Closure)#1 (0) { }

    <?php
    function demo (){
        $a = 10;
        $b = 20;

        $one = function($str) use($a, &$b) {
            $a++;
            $b++;
            echo "$str <br>";
            echo "$a <br>"; //11
            echo "$b <br>"; //21
        };

        $one ('hello');
        echo "--- $a <br>"; //10
        echo "--- $b <br>"; //21

        return $one;
    }
    $var = demo();

    $var('你好1');
    $var('你好2');
    $var('你好3');

    