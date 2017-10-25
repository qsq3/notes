<?php
一些MYSQL的常用命令。
一、连接MYSQL。 
格式： mysql -h主机地址 -u用户名 －p用户密码 
1、例1：连接到本机上的MYSQL。 
首先在打开DOS窗口，然后进入目录 mysqlbin，再键入命令mysql -uroot -p，回车后提示你输密码，如果刚安装好MYSQL，超级用户root是没有密码的，故直接回车即可进入到MYSQL中了，MYSQL的提示符是：mysql>; 
2、例2：连接到远程主机上的MYSQL。假设远程主机的IP为：110.110.110.110，用户名为root,密码为abcd123。则键入以下命令： 
mysql -h110.110.110.110 -uroot -pabcd123 
（注:u与root可以不用加空格，其它也一样） 
3、退出MYSQL命令： exit （回车） 
二、修改密码。 
格式：mysqladmin -u用户名 -p旧密码 password 新密码 
1、例1：给root加个密码ab12。首先在DOS下进入目录mysqlbin，然后键入以下命令 
mysqladmin -uroot -password ab12 
注：因为开始时root没有密码，所以-p旧密码一项就可以省略了。 
2、例2：再将root的密码改为djg345。 
mysqladmin -uroot -pab12 password djg345 
三、增加新用户。（注意：和上面不同，下面的因为是MYSQL环境中的命令，所以后面都带一个分号作为命令结束符） 
格式：grant select on 数据库.* to 用户名@登录主机 identified by "密码" 
例1、增加一个用户test1密码为abc，让他可以在任何主机上登录，并对所有数据库有查询、插入、修改、删除的权限。首先用以root用户连入MYSQL，然后键入以下命令： 
grant select,insert,update,delete on *.* to test1@"%" Identified by "abc"; 
但例1增加的用户是十分危险的，你想如某个人知道test1的密码，那么他就可以在internet上的任何一台电脑上登录你的mysql数据库并对你的数据可以为所欲为了，解决办法见例2。 
例2、 增加一个用户test2密码为abc,让他只可以在localhost上登录，并可以对数据库mydb进行查询、插入、修改、删除的操作 （localhost指本地主机，即MYSQL数据库所在的那台主机），这样用户即使用知道test2的密码，他也无法从internet上直接访问数据 库，只能通过MYSQL主机上的web页来访问了。 
grant select,insert,update,delete on mydb.* to test2@localhost identified by "abc"; 
如果你不想test2有密码，可以再打一个命令将密码消掉。 
grant select,insert,update,delete on mydb.* to test2@localhost identified by ""; 

4.创建一个可以从任何地方连接服务器的一个完全的超级用户，但是必须使用一个口令something做这个
GRANT ALL PRIVILEGES ON *.* TO monty@localhost IDENTIFIED BY 'something' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON *.* TO monty@"%" IDENTIFIED BY 'something' WITH GRANT OPTION;

5.删除授权：
REVOKE ALL PRIVILEGES ON *.* FROM root@"%";
USE mysql;
DELETE FROM user WHERE User="root" and Host="%";
FLUSH PRIVILEGES;

6. 创建一个用户custom在特定客户端weiqiong.com登录，可访问特定数据库bankaccount
mysql> GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP ON bankaccount.*
TO custom@weiqiong.com IDENTIFIED BY 'stupid';

7.重命名表:
ALTER TABLE t1 RENAME t2;

为了改变列a，从INTEGER改为TINYINT NOT NULL(名字一样)，
并且改变列b，从CHAR(10)改为CHAR(20)，同时重命名它，从b改为c:
ALTER TABLE t2 MODIFY a TINYINT NOT NULL, CHANGE b c CHAR(20);

增加一个新TIMESTAMP列，名为d：
ALTER TABLE t2 ADD d TIMESTAMP;

在列d上增加一个索引，并且使列a为主键：
ALTER TABLE t2 ADD INDEX (d), ADD PRIMARY KEY (a);

删除列c：
ALTER TABLE t2 DROP COLUMN c;

增加一个新的AUTO_INCREMENT整数列，命名为c：
ALTER TABLE t2 ADD c INT UNSIGNED NOT NULL AUTO_INCREMENT,ADD INDEX (c);
注意，我们索引了c，因为AUTO_INCREMENT柱必须被索引，并且另外我们声明c为NOT NULL，
因为索引了的列不能是NULL。


6.改变某几行:
UPDATE t1 SET user=weiqiong,password=weiqiong;

7.使用name列的头10个字符创建一个索引:
CREATE INDEX part_of_name ON customer (name(10));

8.删除记录:
DELETE FROM t1 WHERE C>10;


(下篇) 
在上篇我们讲了登录、增加用户、密码更改等问题。下篇我们来看看MYSQL中有关数据库方面的操作。注意：你必须首先登录到MYSQL中，以下操作都是在MYSQL的提示符下进行的，而且每个命令以分号结束。 

一、操作技巧 
1、如果你打命令时，回车后发现忘记加分号，你无须重打一遍命令，只要打个分号回车就可以了。也就是说你可以把一个完整的命令分成几行来打，完后用分号作结束标志就OK。 
2、你可以使用光标上下键调出以前的命令。但以前我用过的一个MYSQL旧版本不支持。我现在用的是mysql-3.23.27-beta-win。

二、显示命令 
1、显示数据库列表。 
show databases; 
刚开始时才两个数据库：mysql和test。mysql库很重要它里面有MYSQL的系统信息，我们改密码和新增用户，实际上就是用这个库进行操作。 
2、显示库中的数据表： 
use mysql； ／／打开库，学过FOXBASE的一定不会陌生吧 
show tables; 
3、显示数据表的结构： 
describe 表名; 
4、建库： 
create database 库名; 
5、建表： 
use 库名； 
create table 表名 (字段设定列表)； 
6、删库和删表: 
drop database 库名; 
drop table 表名； 
7、将表中记录清空： 
delete from 表名; 
8、显示表中的记录： 
select * from 表名; 

三、一个建库和建表以及插入数据的实例 
drop database if exists school; //如果存在SCHOOL则删除 
create database school; //建立库SCHOOL 
use school; //打开库SCHOOL 
create table teacher //建立表TEACHER 
( 
id int(3) auto_increment not null primary key, 
name char(10) not null, 
address varchar(50) default 深圳, 
year date 
); //建表结束 
//以下为插入字段 
insert into teacher valuess(,glchengang,深圳一中,1976-10-10); 
insert into teacher valuess(,jack,深圳一中,1975-12-23); 

注： 在建表中
（1）将ID设为长度为3的数字字段:int(3)并让它每个记录自动加一:auto_increment并不能为空:not null而且让他成为主字段primary key
（2）将NAME设为长度为10的字符字段
（3）将ADDRESS设为长度50的字符字段，而且缺省值为深圳。varchar和char有什么区别 呢，只有等以后的文章再说了。 
（4）将YEAR设为日期字段。 
如果你在mysql提示符键入上面的命令也可以，但不方便调试。你可以将以上命令原样写入一个文本文件中假设为school.sql，然后复制到c:下，并在DOS状态进入目录mysqlbin，然后键入以下命令： 
mysql -uroot -p密码 < c:school.sql 
如果成功，空出一行无任何显示；如有错误，会有提示。（以上命令已经调试，你只要将//的注释去掉即可使用）。 

四、将文本数据转到数据库中 
1、文本数据应符合的格式：字段数据之间用tab键隔开，null值用n来代替. 
例： 
rose    深圳二中    1976-10-10 
mike    深圳一中    1975-12-23 
2、数据传入命令 load data local infile "文件名" into table 表名; 
注意：你最好将文件复制到mysqlbin目录下，并且要先用use命令打表所在的库 。 

五、备份数据库：（命令在DOS的mysqlbin目录下执行） 

导出表
mysqldump --opt school>;school.bbb 
注释:将数据库school备份到school.bbb文件，school.bbb是一个文本文件，文件名任取，打开看看你会有新发现。 
mysqldump --opt school teacher student > school.teacher.student.sql
注释：将数据库school中的teacher表和student表备份到school.teacher.student.sql文
件，school.teacher.student.sql是一个文本文件，文件名任取，打开看看你会有新发现。

导入表
mysql
mysql>create database school;
mysql>use school;
mysql>source school.sql;
(或将school.sql换为school.teacher.sql / school.teacher.student.sql)

导出数据库
mysqldump --databases db1 db2 > db1.db2.sql
注释：将数据库dbl和db2备份到db1.db2.sql文件，db1.db2.sql是一个文本文件，文件名
任取，打开看看你会有新发现。
(举个例子：
mysqldump -h host -u user -p pass --databases dbname > file.dump
就是把host上的以名字user，口令pass的数据库dbname导入到文件file.dump中。)

导入数据库
mysql < db1.db2.sql

复制数据库
mysqldump --all-databases > all-databases.sql
注释：将所有数据库备份到all-databases.sql文件，all-databases.sql是一个文本文件，
文件名任取。

导入数据库
mysql
mysql>drop database a;
mysql>drop database b;
mysql>drop database c;
...
mysql>source all-databases.sql; (或exit退出mysql后 mysql < all-databases.sql)


后 记：其实MYSQL的对数据库的操作与其它的SQL类数据库大同小异，您最好找本将SQL的书看看。我在这里只介绍一些基本的，其实我也就只懂这些了，呵 呵。最好的MYSQL教程还是“晏子“译的“MYSQL中文参考手册“不仅免费每个相关网站都有下载，而且它是最权威的。可惜不是象"HP4中文手册"那样是chm的格式，在查找函数命令的时候不太方便

一、资料定义 ｄｄｌ（data definition language) 
资料定语言是指对资料的格式和形态下定义的语言，他是每个资料库要建立时候时首先要面对的，举凡资料分哪些表格关系、表格内的有什麽栏位主键、表格和表格之间互相参考的关系等等，都是在开始的时候所必须规划好的。

１、建表格：
create table table_name( 
column1 datatype [not null] [not null primary key], 
column2 datatype [not null],
...）
说明：　
datatype --是资料的格式，详见表。
nut null --可不可以允许资料有空的（尚未有资料填入）。
primary key --是本表的主键。

２、更改表格　
alter table table_name 
add column column_name datatype 
说明：增加一个栏位（没有删除某个栏位的语法。
alter table table_name
add primary key (column_name)
说明：更改表得的定义把某个栏位设为主键。
alter table table_name
drop primary key (column_name)
说明：把主键的定义删除。

３、建立索引　
create index index_name on table_name (column_name)
说明：对某个表格的栏位建立索引以增加查询时的速度。

４、删除　
drop table_name
drop index_name



二、的资料形态 datatypes
smallint
16 位元的整数。
interger
32 位元的整数。
decimal(p,s)
p 精确值和 s 大小的十进位整数，精确值p是指全部有几个数(digits)大小值，s是指小数
点後有几位数。如果没有特别指定，则系统会设为 p=5; s=0 。 
float
32位元的实数。
double
64位元的实数。
char(n)
n 长度的字串，n不能超过 254。
varchar(n)
长度不固定且其最大长度为 n 的字串，n不能超过 4000。
graphic(n)
和 char(n) 一样，不过其单位是两个字元 double-bytes， n不能超过127。这个形态是为
了支援两个字元长度的字体，例如中文字。
vargraphic(n)
可变长度且其最大长度为 n 的双字元字串，n不能超过 2000。
date
包含了 年份、月份、日期。
time
包含了 小时、分钟、秒。
timestamp
包含了 年、月、日、时、分、秒、千分之一秒。

三、资料操作 ｄｍｌ （data manipulation language)
资料定义好之後接下来的就是资料的操作。资料的操作不外乎增加资料（insert)、查询资料（query）、更改资料（update) 、删除资料（delete）四种模式，以下分 别介绍他们的语法：

１、增加资料：
insert into table_name (column1,column2,...)
values ( value1,value2, ...)
说明：
1.若没有指定column 系统则会按表格内的栏位顺序填入资料。
2.栏位的资料形态和所填入的资料必须吻合。
3.table_name 也可以是景观 view_name。

insert into table_name (column1,column2,...)
select columnx,columny,... from another_table
说明：也可以经过一个子查询（subquery）把别的表格的资料填入。

２、查询资料：
基本查询
select column1,columns2,...
from table_name
说明：把table_name 的特定栏位资料全部列出来
select *
from table_name
where column1 = xxx 
[and column2 >; yyy] [or column3 <>; zzz]
说明：
1.'*'表示全部的栏位都列出来。
2.where 之後是接条件式，把符合条件的资料列出来。

select column1,column2
from table_name
order by column2 [desc]
说明：order by 是指定以某个栏位做排序，[desc]是指从大到小排列，若没有指明，则是从小到大
排列

组合查询
组合查询是指所查询得资料来源并不只有单一的表格，而是联合一个以上的
表格才能够得到结果的。
select *
from table1,table2
where table1.colum1=table2.column1
说明：
1.查询两个表格中其中 column1 值相同的资料。
2.当然两个表格相互比较的栏位，其资料形态必须相同。
3.一个复杂的查询其动用到的表格可能会很多个。

整合性的查询：
select count (*) 
from table_name
where column_name = xxx
说明：
查询符合条件的资料共有几笔。
select sum(column1)
from table_name
说明：
1.计算出总和，所选的栏位必须是可数的数字形态。
2.除此以外还有 avg() 是计算平均、max()、min()计算最大最小值的整合性查询。
select column1,avg(column2)
from table_name
group by column1
having avg(column2) >; xxx
说明：
1.group by: 以column1 为一组计算 column2 的平均值必须和 avg、sum等整合性查询的关键字
一起使用。 
2.having : 必须和 group by 一起使用作为整合性的限制。

复合性的查询
select *
from table_name1
where exists (
select *
from table_name2
where conditions )
说明：
1.where 的 conditions 可以是另外一个的 query。
2.exists 在此是指存在与否。
select *
from table_name1
where column1 in (
select column1 
from table_name2
where conditions )
说明：　
1. in 後面接的是一个集合，表示column1 存在集合里面。
2. select 出来的资料形态必须符合 column1。 

其他查询
select *
from table_name1
where column1 like 'x%' 
说明：like 必须和後面的'x%' 相呼应表示以 x为开头的字串。
select *
from table_name1
where column1 in ('xxx','yyy',..)
说明：in 後面接的是一个集合，表示column1 存在集合里面。
select *
from table_name1
where column1 between xx and yy
说明：between 表示 column1 的值介於 xx 和 yy 之间。 

３、更改资料：
update table_name
set column1='xxx'
where conditoins
说明：
1.更改某个栏位设定其值为'xxx'。
2.conditions 是所要符合的条件、若没有 where 则整个 table 的那个栏位都会全部被更改。

４、删除资料：
delete from table_name
where conditions
说明：删除符合条件的资料。

说明：关于where条件后面如果包含有日期的比较，不同数据库有不同的表达式。具体如下：
(1)如果是access数据库，则为：where mydate>;#2000-01-01# 
(2)如果是oracle数据库，则为：where mydate>;cast('2000-01-01' as date)
或：where mydate>;to_date('2000-01-01','yyyy-mm-dd')
在delphi中写成：
thedate='2000-01-01';
query1.sql.add('select * from abc where mydate>;cast('+''''+thedate+''''+' as date)'); 

如果比较日期时间型，则为：
where mydatetime>;to_date('2000-01-01 10:00:01','yyyy-mm-dd hh24:mi:ss')

如何恢复MYSQL的ROOT口令 
如果你忘记了你的MYSQL的root口令的话，你可以通过下面的过程恢复。
  1. 向mysqld server 发送kill命令关掉mysqld server(不是 kill -9),存放进程ID的文件通常在MYSQL的数据库所在的目录中。
      kill `cat /mysql-data-directory/hostname.pid`
     你必须是UNIX的root用户或者是你所运行的SERVER上的同等用户，才能执行这个操作。
  2. 使用`--skip-grant-tables' 参数来启动 mysqld。
  3. 使用`mysql -h hostname mysql'命令登录到mysqld server ，用grant命令改变口令。你也可以这样做：`mysqladmin -h hostname -u user password 'new password''。
（其实也可以用use mysql; update user set password =password('yourpass') where user='root'　来做到。）
  4. 载入权限表： 'mysqladmin -h hostname flush-privileges' ，或者使用 SQL 命令'FLUSH PRIVILEGES'。（当然，在这里，你也可以重启mysqld。）
MySQL默认的数据文件存储目录为/var/lib/mysql。假如要把目录移到/home/data下需要进行下面几1、home目录下建立data目录
　　cd /home
　　mkdir data
　　2、把MySQL服务进程停掉： 
　　mysqladmin -u root -p shutdown
　　3、把/var/lib/mysql整个目录移到/home/data
　　mv /var/lib/mysql　/home/data/
　　这样就把MySQL的数据文件移动到了/home/data/mysql下
　　4、找到my.cnf配置文件
　　如果/etc/目录下没有my.cnf配置文件，请到/usr/share/mysql/下找到*.cnf文件，拷贝其中一个到/etc/并改名为my.cnf)中。命令如下：
　　 [root@test1 mysql]# cp /usr/share/mysql/my-medium.cnf　/etc/my.cnf
　　5、编辑MySQL的配置文件/etc/my.cnf
　　为保证MySQL能够正常工作，需要指明mysql.sock文件的产生位置。 修改socket=/var/lib/mysql/mysql.sock一行中等号右边的值为：/home/mysql/mysql.sock 。操作如下：
　　 vi　 my.cnf　　　 (用vi工具编辑my.cnf文件，找到下列数据修改之)
　　 # The MySQL server
　　　 [mysqld]
　　　 port　　　= 3306
　　　#socket　 = /var/lib/mysql/mysql.sock（原内容，为了更稳妥用“#”注释此行）
　　　 socket　 = /home/data/mysql/mysql.sock　　　（加上此行）
　　6、修改MySQL启动脚本/etc/rc.d/init.d/mysql
　　最后，需要修改MySQL启动脚本/etc/rc.d/init.d/mysql，把其中datadir=/var/lib/mysql一行中，等号右边的路径改成你现在的实际存放路径：home/data/mysql。
　　[root@test1 etc]# vi　/etc/rc.d/init.d/mysql
　　#datadir=/var/lib/mysql　　　　（注释此行）
　　datadir=/home/data/mysql　　 （加上此行）
　　7、重新启动MySQL服务
　　/etc/rc.d/init.d/mysql　start
　　或用reboot命令重启Linux
　　如果工作正常移动就成功了，否则对照前面的7步再检查一下。
MySQL简介


　　MySQL是一个广受Linux社区人们喜爱的半商业的数据库。 MySQL是可运行在大多数的Linux平台(i386，Sparc，etc)，以及少许非Linux甚至非Unix平台。

1、许可费用　

　 　MySQL的普及很大程度上源于它的宽松，除了略显不寻常的许可费用。MySQL的价格随平台和安装方式变化。MySQL的Windows版本（NT和 9X）在任何情况下都不免费，而任何Unix变种（包括Linux）的MySQL如果由用户自己或系统管理员而不是第三方安装则是免费的，第三方案庄则必 须付许可费。

2、价格

平台 安装方式 价格 
Windows NT,9X 任何 200美元 
Unix或Linux 自行安装 免费 
Unix或Linux 第三方安装 200美元 
　 需要一个应用组件 200美元 

　　可以得到多种支持合同，内容太多不再罗列，最新报价可咨询MySQL站点。

3、安装

　 　可以在MySQL站点上获得大多数主要的软件包格式（RPM、DBE、TGZ），客户端库和各种语言“包装”（Wrapper）可以分开的RPM格式获 得。RPM格式的安装没有多大麻烦，并且无需初始配置。在rc3.d（以RedHat RPM为例）生成一个初始脚本，故MySQL守护进程在多用户模式下重启时被启动运行。MySQL的守护进程（mysqld）消耗很少的内存（在运行 RedHat 5.1的奔腾133上，每个守护进程使用500K内存和另外4M共享内存的开销）并在只有在执行真正的查询时才装载到处理器上，这意味着对小型数据库来 说，MySQL可以相当轻松地使用而不会对其他系统功能有太大的影响。

4、数据类型

　　字段支持大量数据类型是件好事。通常的整数、浮点数、字符串和数字均以多种长度表示，并支持变长的BLOB（Binary Large OBject）类型。对整数字段由自动增量选项，日期时间字段也能很好的表示。

　 　MySQL与大多数其他数据库系统不同的是提供两个相对不常用的字段类型：ENUM和SET。ENUM是一个枚举类型，非常类适于Pascal语言的枚 举类型，它允许程序员看到类似于'red'、'green'、'blue'的字段值，而MySQL只将这些值存储为一个字节。SET也是从Pascal借用 的，它也是一个枚举类型，但一个单独字段一次可存储多个值，这种存储多个枚举值的能力也许不会给你一些印象（并可能威胁第三范式定义），但正确使用SET 和CONTAINS关键字可以省去很多表连接，能获得很好的性能提高。

5、SQL兼容性

　　MySQL包含一些与SQL 标准不同的转变，他们的大多数被设计成是对SQL语言脚本语言的不足的一种补偿。然而,另一些扩展确实使 MySQL与众不同，例如,LINK子句搜索是自动地忽略大小写的。MySQL 也允许用户自定义的SQL函数，换句话说，一个程序员可以编写一个函数然后集成到MySQL中，并且其表现的与任何基本函数如SUM()或AVG ()没有什么不同。函数必须被编译道一个共享库文件中(.so文件)，然后用一个LOAD FUNCTION命令装载。

　　它也缺乏一些常 用的SQL功能，没有子选择(在查询中的查询)。视图(View)也没了。当然大多数子查询可以用简单的连接(join)子句重写，但有时用两个嵌套的查 询思考问题比一个大连接容易。同样，视图仅仅为程序员隐蔽where子句，但这正是程序员们期望的另一种便利。

6、存储过程和触发器

　　MySQL没有一种存储过程(Stored Procedure)语言，这是对习惯于企业级数据库的程序员的最大限制。多语句SQL命令必须通过客户方代码来协调，这种情形是借助于相当健全的查询语言和赋予客户端锁定和解锁表的能力，这样才允许的多语句运行。

7、参考完整性（Referential Integrity-RI）

　 　MySQL的主要的缺陷之一是缺乏标准的RI机制；然而，MySQL的创造者也不是对其用户的愿望置若罔闻，并且提供了一些解决办法。其中之一是支持唯 一索引。Rule限制的缺乏(在给钉字段域上的一种固定的范围限制)通过大量的数据类型来补偿。不简单地提供检查约束(一个字段相对于同一行的另一个字段 的之值的限制)、外部关键字和经常与RI相关的“级联删除”功能。有趣的是，当不支持这些功能时，SQL分析器容忍这些语句的句法。这样做目的是易于移植 数据库到MySQL中。这是一个很好的尝试，并且它确实未来支持该功能留下方便之门；然而,那些没有仔细阅读文档的的人可能误以为这些功能实际上是存在 的。

7、安全性

　　自始至终我对MySQL最大的抱怨是其安全系统，它唯一的缺点是复杂而非标准，另外只有到调用 mysqladmin来重读用户权限时才发生改变。通常的SQL GRANT/REVOKE 语句到最近的版本才被支持，但是至少他们现在有了。 MySQL的编写者广泛地记载了其特定的安全性系统，但是它确实需要一条可能是别无它法的学习过程。

8、备份和恢复、数据导入/导出

　 　强制参考一致性的缺乏显著地简化备份和恢复，单靠数据导入/导出就可完美复制这一功能。LOAD DATA INFILE命令给了数据导入很大的灵活性。SELECT INTO命令实现了数据导出的相等功能。另外，既然MySQL不使用原始的分区，所有的数据库数据能用一个文件系统备份保存。数据库活动能被记载。与通常 的数据库日志不同(存储记录变化或在记录映像之前/之后), MySQL记载实际的SQL语句。这允许数据库被恢复到失败前的那一点，但是不允许提交(commit)和回卷(rollback)操作.


9、连接性
　 　MySQL客户库是客户/服务器结构的C语言库，它意味着一个客户能查询驻留在另一台机器的一个数据库。然而MySQL真正的强项处于该库中的语言“包 装器(wrapper)”， Perl、Pathon和PHP只是一部分。Apache的Web服务器也有许多模块例如目录存取文件等允许各种各样的Apache配置信息(例如目录存 取文件)使用MySQL，应用程序接口简单、一致并且相但完整。另外、多平台ODBC驱动程序可自由获得。

10、未来

　　MySQL的开发继续以快速进行着。事实上，开发步伐对大多数开放源代码是一种挑战。本文提到的几个抱怨中有很多新功能正在解决，然而，我将不对还没确实存在的特征做评价。开发者们向我表明了在未来的开发中把增加查询功能和提高查询速度作为最高优先级。

11、总结
　 　Mysql是数据库领域的中间派。它缺乏一个全功能数据库的大多数主要特征，但是又有比类似Xbase记录存储引擎更多的特征。它象企业级RDBMS那 样需要一个积极的服务者守护程序，但是不能象他们那样消费资源。查询语言允许复杂的连接(join)查询，但是所有的参考完整必须由程序员强制保证。

　　MySQL在Linux世界里找到一个位置－提供简洁和速度，同时仍然提供足够的功能使程序员高兴。数据库程序员将喜欢其查询功能和广泛的客户库，数据库管理员会觉得系统缺乏主要数据库功能，他们会发觉它对简单数据库(在不能保证购买大牌数据库时)是有价值的。
 