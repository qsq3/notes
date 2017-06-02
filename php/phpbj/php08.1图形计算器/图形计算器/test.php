<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>简单图形计算器</title>
    </head>
    <body>
        <center>
            <h1>简单图形计算器</h1>
            <a href="test.php?action=rect">矩形</a> ||
            <a href="test.php?action=triangle">三角形</a> 
        </center>
        <hr />
        <?php
            
            error_reporting(E_ALL & ~E_NOTICE);

            function __autoload($classname){
                include strtolower($classname).".class.php";
            }

            if(!empty($_GET['action'])){
                //1. 创建形状对象
                $classname = ucfirst($_GET['action']);
                $shape = new $classname($_POST);

                //2. 调用界面view
                $shape -> view();

                //3. 提交表单,验证计算
                if(isset($_POST['submit'])){
                    if($shape -> verify ($_POST)){
                    echo $shape -> name.'的面积: '.$shape -> area().'<br>';
                    echo $shape -> name.'的周长: '.$shape -> girth().'<br>';
                    }
                }
            }else{
                echo "请选择图形";
            }
        ?>
    </body>
</html>