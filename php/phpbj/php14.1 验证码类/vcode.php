<?php
    header('Content-Type:text/html;charset=utf-8');
    date_default_timezone_set('PRC');
    
    //开启session
    session_start();
    include 'vcode.class.php';
    //构造方法
    $vcode = new Vcode(120,40,6);
    //将验证码保存到服务器
    $_SESSION['vcode'] = $vcode -> getcode();
    //将验证码图片输出
    $vcode -> outimg();
?>