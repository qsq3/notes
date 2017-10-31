<?php
  /*
  
  一.半官方模版引擎smarty
  1. 下载: www.smarty.net
    https://github.com/smarty-php/smarty/releases/tag/v3.1.30
  2. 复制 libs 文件夹到项目目录
  3. 引用 Smarty.class.php
  */ 
  // 使用
  header('Content-Type:text/html;charset=utf-8');
  date_default_timezone_set('PRC');

  // 当前目录路径
  define("ROOT", str_replace("\\", "/", dirname(__FILE__)));

  // 
  include ROOT."/libs/smarty/Smarty.class.php";
  $smarty = new Smarty;
  // smart3.0 设置目录
  $smarty->setTemplateDir(ROOT.'/php18.0.1/template2');
  $smarty->setCompileDir(ROOT.'/php18.0.1/template2_c');
  // 定界符
  $smarty->left_delimiter = '<{';
  $smarty->right_delimiter = '}>';
  // 允许定界符内部空格
  $smarty->auto_literal = false;

  // 查询数据库获得数据
    // 连接数据库 include "conn.class.php";
    const DSN = 'mysql:host=localhost;dbname=login';
    const DBUSER = 'root';
    const DBPW = 'root';
    try{
      $pdo = new PDO( DSN, DBUSER, DBPW );
    } catch( PDOException $e){
      echo '数据库连接失败 '.$e->getMessage();
    }
    // 获得数据
    $sql = "select * from user where id = ?";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(array( 1 ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(empty($result)){
      die("数据库中无数据");
    }
  // 获取变量
    $tit = $result['username'];
    $con = $result['email'];

    // 获得数据
    $sql = "select username, email, allow_1 from user order by id";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(empty($result)){
      die("数据库中无数据");
    }

  //2. 向模版中分配变量
  $smarty->assign("title", $tit);
  $smarty->assign("content", $con);
  $smarty->assign("users", $result);

  //3. 加载指定的模版, 并显示
  $smarty->display("template.tpl");