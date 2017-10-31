<?php
// 自定义SESSION数据库存储类
// php.ini中: session.save_handler = user

class MemSession {
  // memcache实例
  public static $mem;
  // 最大生存时间
  public static $maxlifetime;

  // 开启 , 传参 pdo对象;
  public static function start(Memcache $mem){
    // 当前数据库
    self::$mem = $mem;
    // 从php.ini配置文件中读取 maxlifetime
    self::$maxlifetime = ini_get("session.gc_maxlifetime");

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
    $data = self::$mem->get($sid);
    if(empty($data)){
      $data = '';
    }
    return $data;
  }
  // 写入
  public static  function write($sid, $data){
    echo 'session write ... <br>';
    self::$mem->set($sid, $data, MEMCACHE_COMPRESSED, self::$maxlifetime);
  }
  // 销毁
  public static function destroy($sid){
    echo 'session destroy ... <br>';
    self::$mem->delete($sid, 0);
  }
  // 回收垃圾
  public static function gc($maxlifetime){
    echo 'session gc ... <br>';
    return true;
  }
}

// 使用demo
$mem = new Memcache();
// 添加memcache服务器
$mem -> addServer('localhost', 11211);
$mem -> addServer('192.168.1.109', 11211);


MemSession::start($mem);

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