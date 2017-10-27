<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
1.HTTP协议和web本质
  HTTP超文本传输协议(应用层), 基于 TCP/IP(传输层), 了解OSI七层模型, SOCKET网络编程, TCP面向连接协议,UDP数据报协议

2. 请求: 
  1. 一个请求行: GET, POST, DELETE, PUT 等请求方式, 请求资源名称, HTTP协议版本等 
    eg: GET /index.php HTTP/1.1
  2. 若干请求头: 主机信息及客户端环境信息: 请求地址,浏览器信息,cookie等, 
  3. 换行
  4. 请求正文
3. 响应: 
  1.响应行: 状态码, 服务器处理结果 
    eg: HTTP/1.1 200 OK
  2.若干响应头: header('Content-Type:text/html;charset=utf-8');
  3.换行
  4.响应正文: 
4. HTTP1.1 在一个TCP连接上可以创送多个HTTTP请求和响应

HTTP消息头（请求和响应共性）
使用消息头，可以实现HTTP客户机与服务器之间的条件请求和应答，消息头相当于服务器和浏览器之间的一些暗号指令。
每个消息头包含一个头字段名称，然后依次是冒号、空格、值、回车和换行符
  如： Accept-Encoding: gzip, deflate
消息头字段名是不区分大小写的，但习惯上讲每个单词的第一个字母大写。
整个消息头部分中的各行消息头可按任何顺序排列。
消息头又可分为通用信息头、请求头、响应头、实体头等四类
许多请求头字段都允许客户端在值部分指定多个可接受的选项，多个选项之间以逗号分隔。
有些头字段可以出现多次，例如，响应消息中可以包含有多个”Warning”头字段。


HTTP请求的细节——请求行
请求行
格式：请求方式 资源路径 HTTP版本号<CRLF>
举例：GET /temp.php HTTP/1.1
请求方式：GET、POST、HEAD、OPTIONS、DELETE、TRACE、PUT
用户如没有设置，默认情况下浏览器向服务器发送的都是get请求，例如在浏览器直接输地址访问，点超链接访问等都是get，用户如想把请求方式改为post，可通过更改表单的提交方式实现。
不管POST或GET，都用于向服务器请求某个WEB资源，这两种方式的区别主要表现在数据传递上。
GET方式
如请求方式为GET方式，则可以在请求的URL地址后以?的形式带上交给服务器的数据，多个数据之间以&进行分隔，例如：
GET /mail/1.html?name=abc&password=xyz HTTP/1.1
GET方式的特点：在URL地址后附带的参数是有限制的，其数据容量通常不能超过1K。
POST方式
如请求方式为POST方式，则可以在请求的正文内容中向服务器发送数据，Post方式的特点：传送的数据量无限制。

HTTP请求的细节——请求头
请求头字段用于客户端在请求消息中向服务器传递附加信息，主要包括客户端可以接受的数据类型(MIME类型)、压缩方法、语言以及发出请求的超链接所属页面的URL地址等信息。
常用请求头：
Accept:浏览器可接受的MIME类型 
Accept-Charset: 浏览器通过这个头告诉服务器，它支持哪种字符集
Accept-Encoding:浏览器能够进行解码的数据编码方式，比如gzip 
Accept-Language:浏览器所希望的语言种类，当服务器能够提供一种以上的语言版本时要用到。 可以在浏览器中进行设置。
Host:初始URL中的主机和端口 
Referer:包含一个URL，用户从该URL代表的页面出发访问当前请求的页面 
Content-tType:内容类型
If-Modified-Since: Wed, 02 Feb 2011 12:04:56 GMT利用这个头与服务器的文件进行比对，如果一致，则从缓存中直接读取文件。
User-Agent:浏览器类型.
Content-Length:表示请求消息正文的长度 
Connection:表示是否需要持久连接。如果服务器看到这里的值为“Keep -Alive”，或者看到请求使用的是HTTP 1.1（HTTP 1.1默认进行持久连接 
Cookie:这是最重要的请求头信息之一 
Date：Date: Mon, 22 Aug 2013 01:55:39 GMT请求时间GMT

HTTP响应的细节——状态行
状态行
  格式： HTTP版本号　状态码　原因叙述<CRLF>
  举例：HTTP/1.1 200 OK
状态码用于表示服务器对请求的各种不同处理结果和状态，它是一个三位的十进制数。响应状态码分为5类，使用最高位为1到5来进行分类如下所示：

HTTP响应的细节——常用状态码
200(正常)
表示一切正常，返回的是正常请求结果
302/307(临时重定向)
指出被请求的文档已被临时移动到别处，此文档的新的URL在Location响应头中给出。
304(未修改)
表示客户机缓存的版本是最新的，客户机可以继续使用它，无需到服务器请求。
404(找不到)
服务器上不存在客户机所请求的资源。
500(服务器内部错误)
服务器端的程序发生错误

HTTP响应细节——常用响应头
响应头字段用于向客户端传递附加信息
常用响应头
Location: http://www.brophp.com/index.php指示新的资源的位置
Server:apache 指示服务器的类型
Content-Encoding: gzip服务器发送的数据采用的编码类型
Content-Length: 80 告诉浏览器正文的长度
Content-Language: zh-cn服务发送的文本的语言
Content-Type: text/html; charset=utf-8服务器发送的内容的MIME类型
Last-Modified: Tue, 11 Jul 2013 18:23:51 GMT文件的最后修改时间
Refresh: 1;url=http://www.brophp.com指示客户端刷新频率。单位是秒
Content-Disposition: attachment; filename=aaa.zip指示客户端下载文件
Set-Cookie:SS=Q0=5Lb_nQ; path=/search服务器端发送的Cookie
Expires: -1
Cache-Control: no-cache (1.1)  
Pragma: no-cache   (1.0)
Connection: close/Keep-Alive   
Date: Tue, 11 Jul 2000 18:23:51 GMT

会话控制
变量:
  1. 页面变量 page
  2. url传递 $_GET
  3. 会话级别 session
  4. 全局变量 global