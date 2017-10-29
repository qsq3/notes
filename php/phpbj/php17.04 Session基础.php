<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
// 0. session 信息 在服务端是以 sessionId文件名的临时文件形式保存的, 客户端将sessionId保存在cookie或url中;
$sid = !empty($_GET[session_name()])? $_GET[session_name()] : '';
if($sid != ''){
  session_id($sid);
}
// 1.开启会话 , 并向客户端发送sessionId保存在cookie中为PHPSESSID, 属于响应头信息, 页面信息不能设置在此函数前面, 并同时触发垃圾回收机制 php.ini 中 gc 相关配置
session_start();

// 使用$_SESSION全局数组读写
print_r($_SESSION);
$_SESSION['username'] = 'test';
$_SESSION['age'] = '18';
$_SESSION['array'] = array('email'=>'123@QQ.COM');
echo '<br>';
echo session_name(); // PHPSESSID
echo '<br>';
echo session_id();
echo '<br>';
// 客户端
echo $_COOKIE['PHPSESSID'];
echo '<br>';

/*
// 删除 session 首先也要开启session
// session_start();

// 单个
unset($_SESSION['username']);

// 全部
// 1.清空内存
$_SESSION = array();
// 2.删除客户端中cookie的PHPSESSID
if( isset($_COOKIE[session_name()]) ){
setCookie(session_name(), '', time()-3600, '/');
}
// 3.彻底销毁文件
session_destroy();
*/
?>

<a href="/test.php?<?php echo session_name()."=".session_id() ?>">手动跳转sessionid链接</a>
<a href="/test.php?<?php echo SID ?>">SID常量跳转sessionid链接</a>
<div>
在使用Linux系统做服务器时， 在编辑PHP时， 如果使用了—enable-trans-sid配置选项， 和运行时选项session.use_trans_sid都被激活， 在客户端禁用cookie时， 相对的url将被自动修改为包含sessionid, 如果没有配置， 或使用windows系统作为服务器时， 可以使用常量SID.  
建议使用Linux并配置好。
</div>