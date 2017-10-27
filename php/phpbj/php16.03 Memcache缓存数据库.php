<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
  // 创建 Memcache 对象
  $mem = new Memcache;

  // 连接服务端
  $host = 'localhost';
  $port = '11211';
  $timeout = 1;
  // $mem->connect($host, $port, $timeout); // 返回布尔值

  // 分布式连接
  $host2 = "192.168.1.109";
  $persistent = true; // bool 是否持久化连接
  $weight = 1; // int 权重
  $mem -> addServer($host, $port);
  $mem -> addServer($host2, $port);

  // 清空
  // $mem->flush();
  // 先尝试从memcache中获取数据
  $sql = "SELECT id, name, balance FROM users ORDER BY id";
  $key = md5($sql); // 以md5(sql)语句为key
  $data = $mem->get($key);
  $expire = 1;
  // 数据库连接
  if(empty($data)){
    try{
      $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "root");
    } catch ( PDOException $e){
      echo "数据库连接失败: ".$e->getMessage();
    }
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();
    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    $mem->set($key,$data,MEMCACHE_COMPRESSED,$expire);
    echo $key."从数据库获取并存入memcache<br>";
  }

  //显示数据
  echo "<pre>";
  print_r($data);
  echo "</pre>";

  // 关闭连接
  $mem->close();
