<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');

// 登录demo
// SQL
/*
mysql -h localhost -uroot -proot
show databases;
create database if not exists login;
use login;
show tables;

// 创建用户表
create table IF NOT EXISTS user(
  id int not null auto_increment,
  username varchar(50) not null default '',
  password char(32) not null default '',
  email varchar(80) not null default '',
  allow_1 smallint not null default 0,
  allow_2 smallint not null default 0,
  allow_3 smallint not null default 0,
  primary key(id)
);

desc user;

insert into user(username, password, email, allow_1, allow_2, allow_3) values('meizi', md5('meizi'), 'mz@qq.com', 0, 1, 1);
insert into user(username, password, email, allow_1, allow_2, allow_3) values('admin', md5('admin'), 'admin@qq.com', 0, 1, 1);

// 创建邮件表
create table if not exists email(
  id int not null auto_increment,
  uid int not null default 0,
  title varchar(80) not null default '',
  ptime int not null default 0,
  mbody text,
  primary key(id)
);

insert into email(uid, title, ptime, mbody) values(1,'1111111111', 123456781,'1111111110000');
insert into email(uid, title, ptime, mbody) values(2,'222222222222', 123456782,'222222222200000000');
insert into email(uid, title, ptime, mbody) values(1,'3333333333', 123456783,'33333300000000000000');
insert into email(uid, title, ptime, mbody) values(2,'44444444', 123456784,'444444444400000000000');
insert into email(uid, title, ptime, mbody) values(1,'555555555', 123456785,'5555550000000000000');
 */

// 配置文件
const DSN = 'mysql:host=localhost;dbname=login';
const DBUSER = 'root';
const DBPW = 'root';

// 基础文件
// 开启session
$sid = !empty($_GET[session_name()])? $_GET[session_name()] : '';
if($sid != ''){
  session_id($sid);
}
session_start();

//

// 判断未登录且不是登录页时跳转登录页
if( !(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == 1 ) && (empty($_GET['action']) || $_GET['action'] != 'login') ){
  echo "用户未登录,请选择登录";
  echo '<script type="text/javascript" charset="utf-8"> setTimeout(function(){window.location.href = "/test.php?action=login"},3000)</script>';
  exit;

  //登录页
} else if( isset($_GET['action']) && $_GET['action'] == 'login') {
  // 提交查询数据库
  if(isset($_POST['dosubmit'])){
    // print_r($_POST);
    try{
      $pdo = new PDO( DSN, DBUSER, DBPW );
      $sql = "select id, username, allow_1, allow_2, allow_3 from user where username=? and password=?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array( $_POST['username'], md5($_POST['password']) ));
      if($stmt->rowCount() > 0){
        // 将用户信息一次性放到session中
        $_SESSION = $stmt->fetch(PDO::FETCH_ASSOC);
        // 添加登录标记
        $_SESSION['isLogin'] = 1;
        echo "{$_SESSION['username']}登录成功";
        echo '<script type="text/javascript" charset="utf-8"> setTimeout(function(){window.location.href = "/test.php" },3000)</script>';
      }else{
        echo "登录失败,用户名密码不匹配";
        echo '<script type="text/javascript" charset="utf-8"> setTimeout(function(){location.href = location.href},3000)</script>';
      }
    } catch (PDOException $e){
      echo "ERROR: ".$e->getMessage();
    }
  }else{
  echo <<<'EOT'
<h2>请登录</h2>
<form action="" method="post" accept-charset="utf-8">
  用户名 <input type="text" name="username" />
  密 码 : <input type="password" name="password" />
  <input type="submit" name="dosubmit" value="登录" />
</form>
EOT;
  }
exit;

// 登出
} else if( isset($_GET['action']) && $_GET['action'] == 'logout') {
    echo "再见, {$_SESSION['username']}";
    // 销毁session三步
    $_SESSION = array();
    if(isset($_COOKIE[session_name()])){
      setCookie(session_name(), '', time()-3600, '/');
    }
    session_destroy();
    // 跳转
    echo '<script type="text/javascript" charset="utf-8"> setTimeout(function(){ window.location.href = "/test.php?action=login" },3000)</script>';

// 显示主界面
} else if( isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == 1 ){
  echo "{$_SESSION['username']}已登录 <br/> <a href='/test.php?action=logout' >退出</a><br/>";
  if($_SESSION["allow_1"] == 1){
    echo "你有权限1<br/>";
  }
  if($_SESSION["allow_2"] == 1){
    echo "你有权限2<br/>";
  }
  if($_SESSION["allow_3"] == 1){
    echo "你有权限3<br/>";
  }

  // 邮件列表
  try{
    $pdo = new PDO( DSN, DBUSER, DBPW );
    $sql = "select id, uid, title, ptime, mbody from email where uid=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array( $_SESSION['id'] ));
    $emailNum = $stmt->rowCount();
    if($emailNum > 0){
      echo "您有{$emailNum}封邮件";
      $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
      print_r($emails);
    }else{
      echo "没有邮件";
    }
  } catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
  }
}