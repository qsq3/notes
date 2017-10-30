<?php
// 自定义文件存储SESSION类
// php.ini中: session.save_handler = user
class FileSession {
  // 存放路径
  private static $path;

  // 开启
  public static function start($path = "C:/Users/Administrator/Desktop/session_test/"){
    // 定义路径
    self::$path = $path;
    // 注册生命周期钩子
    session_set_save_handler(
      array(__CLASS__, "open"), // 表示 本类 的 open 方法
      array(__CLASS__, "close"),
      array(__CLASS__, "read"),
      array(__CLASS__, "write"),
      array(__CLASS__, "destroy"),
      array(__CLASS__, "gc")
    );
    // 开启session
    session_start();
  }

  private static function getFilename($sid){
    return self::$path."ss_".$sid;
  }

  // 开启
  public static function open( $path, $name){
    echo 'session open ... <br>';
    return true;
  }
  // 关闭
  public static function close(){
    echo 'session close ... <br>';
    return true;
  }
  // 读取
  public static  function read($sid){
    echo 'session read ... <br>';
    $filename = self::getFilename($sid);
    return @file_get_contents($filename);
  }
  // 写入
  public static  function write($sid, $data){
    echo 'session write ... <br>';
    $filename = self::getFilename($sid);
    return file_put_contents($filename, $data);
  }
  // 销毁
  public static function destroy($sid){
    $filename = self::getFilename($sid);
    echo 'session destroy ... <br>';
    return @unlink($filename);
  }
  // 回收垃圾
  public static function gc($maxlifetime){
    foreach(glob(self::getFilename('*')) as $file){
      echo $file.'<br>';
      // 只删除过期
      if( filemtime($file) + $maxlifetime < time()){
        unlink($file);
      }
    }
    echo 'session gc ... <br>';
  }
}

// 使用demo
FileSession::start();

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