<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
// memcache 内存转缓存 
0. 1.4.4, 64版本在win7 64位下telnet操作有问题 ; 1.2.5 32位正常
1. 下载文件解压 D:\Tools\memcached
2. 配置环境变量 PATH: D:\Tools\memcached
3. 安装 memcached -d install
4. 开启 memcached -d start
5. 卸载 memcached -d uninstall
6. 启动memcache常用参数
  -p <num> 设置端口号(默认11211)
  -U <num> UDP监听端口(默认11211, 0 为关闭)
  -I <ip地址> 绑定地址(默认:所有都允许,内外网或本机更换IP,有安全隐患,若设置为 127.0.0.1 就只能本机访问)
  -d 独立进程运行
  -h 帮助
    memcached -d start 启动服务
             ... restart 重启服务
             ... stop|shutdown 关闭
             ... install 安装
             ... uninstall 卸载
  -u <username> 绑定username
  -m <num> 允许最大内存(默认64MB)
  -P <file> 将PID写入文件<file>,可使得后边进行快速进程终止,须与-d 一起使用
  -M 内存耗尽时返回错误,而不是删除项
  -c 最大同时连接数, 默认1024
  -f 块大小增长因子, 默认1.25
  -n 最小分配空间, key + value + flags 默认48

部分指令在windows下失效
eg:
cmd
memcached -d stop
memcached -m 256 -p 11222 -d start
telnet localhost 11211
7. 查看端口 netstat -a 默认端口号 11211
8. 开启win7 telnet , 使用telnet连接

客户端命令:
  stats 状态信息
  add   增,添加数据
  set   改,替换数据,若不存在则添加
  get   查,获取数据
  delete 删,
  flush_all 清空数据
  quit  退出
错误提示
  ERROR : 普通错误信息, 比如指令错误
  CLIENT_ERROR <错误信息> : 客户端错误
  SERVER_ERROR <错误信息> : 服务器错误

数据管理命令
  格式: <命令> <键> <标记> <有效期> <数据长度>
  <命令>: add set(别名: replace) delete get
  <键>: key, 是发送过来指令的key内容
  <标记>: flags , 是调用set指令保存数据时候的flags标记, int 类型
  <有效期>: 是数据在服务器上的有效期限, 单位为秒, 0 则永久有效
  <数据长度>: block data 块数据长度, 一般在这个长度结束以后下一行跟着block data 数据内容
  发送完数据之后, 客户端一般等待服务端返回, 服务端的返回为: STORED 数据保存成功, NOT_STORED 数据保存失败,原因: key已存在

  eg: cmd命令
      add <键> <标记> <有效期> <数据长度>
      <数据> 
      get <键>
      delete <键> 1.2.5 32位有问题
      add  test1 1 0 5
      12345
遍历 stats items 遍历item行
     stats cachedump 3 0 , 3表示item后面的数字, 0表示显示数量全部, 改为1则为1条

memcache 项目名: memcache , 而其守护进程和编译后的可执行exe文件名为 memcached
而在php扩展库中, memcache 和 memcached 是两套扩展库, memcache类基于原生php开发, memcached基于libmemcache库开发
memcache 更稳定, memcached 更快但更新麻烦

php安装扩展memcache库: 
   1. 下载 memcache php5.4 版本扩展库 :  php_memcache.dll
   2. 复制到D:\Tools\phpStudy\php\php-5.4.45\ext
   3. 修改 php.ini文件, 添加扩展配置 extension=php_memcache.dll
   4. 重启服务, 查看 http://www.bj.com/phpinfo.php 

安全:
  1. 内网访问
    memcached -d -m 1024 -u root -! 192.168.0.10 -p 11211 -c 1024 start
  2. 设置防火墙
    iptables -F
    iptables -P INPUT DROP
    iptables -A INPUT -p tcp -s 192.168.0.10 --dport 11211 -j ACCEPT
    iptables -A INPUT -p udp -s 192.168.0.10 --dport 11211 -j ACCEPT
