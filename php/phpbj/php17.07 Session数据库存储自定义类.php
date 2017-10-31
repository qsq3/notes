<?php
// 自定义SESSION数据库存储类
// php.ini中: session.save_handler = user
/* SQL分析
  存储信息: 表名: session 建议使用内存表
  1. 记录 session id; sid
  2. 修改时间;  utime
  3. session数据 sdata
  4. ip 用户ip : uip
  5. user_agent 用户浏览器 : uagent

  SQL 语句
  use test;
  create table if not exists session(
    sid char(32) not null default '',
    utime int not null default 0,
    sdata text,
    uip char(15) not null default '',
    uagent varchar(200) not null default '',
    index session_sid(sid)
  );
 */

class DBSession {
  // 存放数据库
  public static $pdo;
  // 当前时间
  public static $ctime;
  // 最大生存时间
  public static $maxlifetime;
  // 用户当前ip
  public static $uip;
  // 用户当前客户端
  public static $uagent;
  

  // 开启 , 传参 pdo对象;
  public static function start(PDO $pdo){
    // 当前数据库
    self::$pdo = $pdo;
    self::$ctime = time();
    // 从php.ini配置文件中读取 maxlifetime
    self::$maxlifetime = ini_get("session.gc_maxlifetime");
    //获取IP
    self::$uip = !(empty($_SERVER['HTTP_CLIENT_IP'])) ? $_SERVER['HTTP_CLIENT_IP'] : 
      !(empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] :
      !(empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';
    // 验证IP是否合法
    self::$uip = filter_var(self::$uip, FILTER_VALIDATE_IP) ? self::$uip : '';
    // 获取客户端信息
    self::$uagent = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

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
    $sql = "select * from session where sid = ?";
    $stmt = self::$pdo -> prepare($sql);
    $stmt -> execute(array( $sid ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // 如果没有会话信息
    if(!$result){
      return '';
    // 如果超出时间,销毁session
    } else if($result['utime'] + self::$maxlifetime < self::$ctime){
      self::destroy($sid);
      return '';
    // 如果IP改变
    } else if($result['uip'] != self::$uip){
      self::destroy($sid);
      return '';
    // 如果浏览器改变
    } else if($result['uagent'] != self::$uagent){
      self::destroy($sid);
      return '';
    } else {
      return $result['sdata'];
    }
    
  }
  // 写入
  public static  function write($sid, $data){
    echo 'session write ... <br>';
    if(!empty($data)){
      // 判断是否已有
      $sql = "select * from session where sid = ?";
      $stmt = self::$pdo -> prepare($sql);
      $stmt -> execute(array( $sid ));
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result){
        // 有则更新
        // 且数据不一致或时间间隔30秒才更新
        if($result['sdata'] != $data || $result['utime']+30 < self::$ctime){
          $sql = "update session set sdata=?, utime=? where sid = ?";
          $stmt = self::$pdo -> prepare($sql);
          $stmt ->execute(array($data, self::$ctime, $sid));
        }
      }else{
        // 无则插入
        $sql = "insert into session(sid, sdata, utime, uip, uagent) values(?,?,?,?,?)";
        $stmt = self::$pdo -> prepare($sql);
        $stmt -> execute(array( $sid, $data, self::$ctime, self::$uip, self::$uagent ));
      }
    }
  }
  // 销毁
  public static function destroy($sid){
    echo 'session destroy ... <br>';
    $sql = "delete * from session where sid = ?";
    $stmt = self::$pdo -> prepare($sql);
    $stmt -> execute(array( $sid ));
  }
  // 回收垃圾
  public static function gc($maxlifetime){
    echo 'session gc ... <br>';
    $sql = "delete * from session where utime < ?";
    $stmt = self::$pdo -> prepare($sql);
    $stmt -> execute(array( self::$ctime - self::$maxlifetime ));
  }
}

// 使用demo
// // 配置文件
const DSN = 'mysql:host=localhost;dbname=test';
const DBUSER = 'root';
const DBPW = 'root';
try{
  $pdo = new PDO( DSN, DBUSER, DBPW );
} catch( PDOException $e){
  echo '数据库连接失败 '.$e->getMessage();
}
DBSession::start($pdo);

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