<?php
错误报告和设置级别
    语法错误
    运行错误
    逻辑错误
    
    Notice 
    Warning 
    Fatal Error

    是否开启输出错误报告: ini_set('display_errors','On');
    设置级别 error_reporting(E_ALL & ~E_NOTICE);

error_reporting 错误级别变量对照表
数字	常量	说明
1	E_ERROR	致命错误，脚本执行中断，就是脚本中有不可识别的东西出现 
举例： Error：Invalid parameters. Invalid parameter name
2	E_WARNING	部分代码出错，但不影响整体运行 
举例： Warning: require_once(E:/include/config_base.php)
4	E_PARSE 	字符、变量或结束的地方写规范有误
举例：  Parse error: syntax error, unexpected $end in
8 	 E_NOTICE	一般通知，如变量未定义等
举例：  Notice: Undefined variable: p in E:\web\index.php on line 17
16 	E_CORE_ERROR	PHP进程在启动时，发生了致命性错误 
举例：  暂无
32 	E_CORE_WARNING	在PHP启动时警告(非致命性错误)
举例：  暂无
64	E_COMPILE_ERROR	编译时致命性错误
举例：  暂无
128	E_COMPILE_WARNING	编译时警告级错误
举例：  暂无
256	E_USER_ERROR 	用户自定义的错误消息
举例：  暂无
512	E_USER_WARNING	用户自定义的警告消息
举例：  暂无
1024	E_USER_NOTICE 	用户自定义的提醒消息
举例：  暂无
2047	E_ALL	以上所有的报错信息，但不包括E_STRICT的报错信息
举例：  暂无
2048	E_STRICT	编码标准化警告，允许PHP建议如何修改代码以确保最佳的互操作性向前兼容性。

自定义错误报告处理函数:
<?php
    error_reporting(0);
    set_error_handler("myerror"); //使用后 error_reporting 失效;
    $mess = '';
    function myerror($error_type,$error_message,$error_file,$error_line){
        global $mess;
        $mess .= "错误发生:<br>级别类型为: {$error_type}<br> 错误消息为: {$error_message}<br> 所在文件为: {$error_file}<br> 行号为: <font color='red'>{$error_line}</font><br><br>";
    }

    echo $b;
    echo "11111提示级别<br>";
    getType();
    echo "22222运行错误,警告级别<br>";
    //get_Type();
    echo "333333语法错误,致命级别<br>";

    echo "--------------------------------------<br>";
    echo $mess;
    
自定义一个错误: trigger_error("自定义一个语法错误",E_USER_ERROR);

设置错误报告日志:
php.ini中设置: log_errors = On , 
php脚本中设置 error_log(); 写到错误日志中去,根据环境设置默认写入位置不同, 
    wamp写到apache的错误日志, xampp写到php的错误日志php_error_log.txt;
    通过 php.ini设置 error_log = "D:/xampps/php/logs/php_error_log.txt" 可指定写入位置;
或者
ini_set("display_errors",'On');
ini_get();

异常处理
    try{
        throw new Exception("错误消息");
    } catch(MYException1 $e) {
        echo $e->getMessage().'<br>';//接收并输出消息

        try{
            throw new Exception("错误消息");
        } catch(Exception $e) {
            echo $e->getMessage().'<br>';//接收并输出消息
        }

    } catch(MYException2 $e) {
        echo $e->getMessage().'<br>';//接收并输出消息
    } catch(Exception $e) {
        echo $e->getMessage().'<br>';//接收并输出消息
    }

自定义异常类
    1.自定义的异常类,必须是系统类 Exception 的子类
    2.重写构造方法, 一定要调用下父类的被覆盖的构造方法;
    
    class MyException {
        function __construct($str){
            parent::__construct($str);
        }

        function myFn(){
        
        }
    }
