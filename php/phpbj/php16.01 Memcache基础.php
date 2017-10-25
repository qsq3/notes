<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
/* memcache 内存转缓存  */
1. 下载文件解压 D:\Tools\memcached
2. 配置环境变量 PATH: D:\Tools\memcached
3. 安装 memcached -d install
4. 开启 memcached -d start
5. 卸载 memcached -d uninstall
6. 查看端口 netstat -a 默认端口号 11211
7. 开启win7 telnet , 使用telnet连接
8. 退出 quit;
9. 启动memcache常用参数
  -p <num> 设置端口号(默认11211)
  -U <num> UDP监听端口(默认11211, 0 为关闭)
  -I <ip地址> 绑定地址(默认:所有都允许,内外网或本机更换IP,有安全隐患,若设置为 127.0.0.1 就只能本机访问)
  -d 独立进程运行
    memcached -d start 启动服务
             ... restart 重启服务
             ... stop|shutdown 关闭
             ... install 安装
             ... uninstall 卸载
             