<?php
    //设置字符集
    header("Content-Type:text/html;charset=utf-8");

    //忽略提示错误
    error_reporting("E_ALL ^ E_NOTICE");//error_reporting("E_ALL & ~E_NOTICE");

    //设置时区
    date_default_timezone_set("PRC");

    //分页显示数量
    $pagenum = 15;