<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');

// 登录demo
// SQL
/*
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

 */
// 判断未登录
if( !(isset($_COOKIE['isLogin']) && $_COOKIE['isLogin'] == 1 ) && (empty($_GET['action']) || $_GET['action'] != 'login') ){
  echo "用户未登录,请选择登录";
  echo '<script type="text/javascript" charset="utf-8"> setTimeout(function(){window.location.href = "/test.php?action=login"},3000)</script>';
  exit;

  //登录
} else if( isset($_GET['action']) && $_GET['action'] == 'login') {
  // 提交查询数据库
  if(isset($_POST['dosubmit'])){
    print_r($_POST);
    $pdo = new PDO('mysql:host=localhost;dbname=login','root', 'root');
    $sql = "select id, username, allow_1, allow_2, allow_3 from user where username=? and password=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array( $_POST['username'], md5($_POST['password']) ));
    if($stmt->rowCount() > 0){
      list($id, $username, $allow_1, $allow_2, $allow_3) = $stmt->fetch(PDO::FETCH_NUM);
      $expire = time()+24*60*60;
      setCookie('uid', $id, $expire, '/');
      setCookie('username', $username, $expire, '/');
      setCookie('allow_1', $allow_1, $expire, '/');
      setCookie('allow_2', $allow_2, $expire, '/');
      setCookie('allow_3', $allow_3, $expire, '/');
      setCookie('isLogin', 1, $expire, '/'); // 设置一个登录判断的标记
      echo '<script type="text/javascript" charset="utf-8"> setTimeout(function(){window.location.href = "/test.php" },3000)</script>';
    }else{
      echo "登录失败";
      echo '<script type="text/javascript" charset="utf-8"> setTimeout(function(){window.location.href = window.location.href},3000)</script>';
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
    $expire = time() - 3600;
    setCookie('uid', '', $expire, '/');
    setCookie('username', '', $expire, '/');
    setCookie('allow_1', '', $expire, '/');
    setCookie('allow_2', '', $expire, '/');
    setCookie('allow_3', '', $expire, '/');
    setCookie('isLogin', '', $expire, '/'); // 设置一个登录判断的标记
    echo '<script type="text/javascript" charset="utf-8"> setTimeout(function(){ window.location.href = "/test.php?action=login" },3000)</script>';
    // 显示主界面
} else if( isset($_COOKIE['isLogin']) && $_COOKIE['isLogin'] == 1 ){
  echo $_COOKIE["username"]."已登录"."<a href='/test.php?action=logout' >退出</a>";
  if($_COOKIE["allow_2"] == 1){
    echo "你有权限2";
  }
}