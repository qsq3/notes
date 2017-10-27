<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');

// Cookie 保存
$value = time()+24*60*60;
$expire = $value; // 过期时间
setcookie("username",$value, $expire);
// 设置数组, 最好指定key, 否则会覆盖;
setcookie("arr[0]", $value, $expire);
setcookie("arr[1]", $value, $expire);
setcookie("arr[name]", $value, $expire);

echo $value;
echo "<br>------<br>";

// 删除, 设置为过期即可
setcookie("arr[1]", "", time()-3600);

// 读取
print_r($_COOKIE);
echo "<br>------<br>";

// 注意: 在加载页面时,服务器先读取浏览器请求头中的Cookie进 $_COOKIE, 在运行脚本写入
var_dump($value == $_COOKIE['username']); // false
echo "<br>------<br>";
echo "<hr>";
