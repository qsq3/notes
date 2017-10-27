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
  $mem -> addServer($host1, $port);
  $mem -> addServer($host2, $port);

    // 清空
    $mem->flush();

    // 数据 参数
    $key1 = "key1"; // key
    $value = "this is a memcache test!!!"; //数据
    $flag = MEMCACHE_COMPRESSED; //是否压缩
    $expire = 60*60*24; //过期时间, 秒数(最大30天) 或 (大于30天)unix时间戳;0 为永不过期
    // 存储字符串
    $mem->add($key1, $value, $flag, $expire);
    // 存储数组
    $key2 = 'key2';
    $mem->add($key2, array(111,array('aaa','bbb')), $flag, 0);

    //存储对象
    $key3 = 'key3';
    class Test{
      public $a = 1;
      public $b = 3;
    }
    $mem->add($key3, "It's key3", $flag, 0);
    // 读取
    var_dump( $mem->get($key3));
    echo "<br>";
    //修改key3
    $mem->set( $key3, new Test(), $flag, 1000);

    // 以数组方式一次读取多个
    var_dump( $mem->get(array( $key1, $key2 , $key3 )));
    echo "<br>";

    // 删除
    $timeout = 100; //超时,单位秒  并不是延迟
    $mem -> delete($key1, $timeout); // 键名, 最大超时时间
    echo "key1删除后:<br>";
    var_dump($mem->get($key1));

    $mem->flush();
    // 关闭连接
    $mem->close();
