<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
数据库分为 sql 和 nosql;
复习mysql
一 .MySQL结构:
    C/S: client/server
    MySQL: DBMS 数据库管理系统(Database Management System)
    默认端口 3306
    客户端: 服务器 -- 数据库 -- 数据表 -- (行/记录,列/字段)

    程序员要做的: 1. 为项目设计表 2. 使用SQL语句 其他都可以使用工具完成;
    
    MySQL的安装和启动

    Windows:  
        停止服务: net stop mysql
        启动: net strat mysql
        环境变量: 配置PATH : "D:\Tools\phpStudy\MySQL\bin"
        CMD : mysql -h localhost -uroot -proot

    Linux 
        启动: service mysqld start
        mysqladmin start
        /ect/init.d/mysql start (前面为mysql的安装路径)

        重启: service mysqld restart
        mysqladmin restart
        /ect/init.d/mysql restart (前面为mysql的安装路径)
        
        停止服务: service mysqld stop
        mysqladmin shutdown
        /ect/init.d/mysql    shutdown (前面为mysql的安装路径)
        netstat –na | findstr 3306 查看被监听的端口 , findstr用于查找后面的在端口是否存在

        在命令行中登陆MYSQL控制台 , 即使用 MYSQL COMMEND LINE TOOL
            语法格式 mysql –user=root –password=123456 db_name
                   或 mysql –uroot –p123456 db_name 注意：直接输入密码-p后面不能留有空格
            mysql -u 用户名 -p密码-h 服务器IP地址-P 服务器端MySQL端口号-D 数据库名
    
    和PHP整合

    MySQL的目录结构
        配置文件 my.ini  
        管理命令: bin/  知识点: 环境变量 PATH
        数据库资料: data/ 

        关键字:
        if not exists
        if exists
        查看配置文件的环境变量: show variables like 'time_zone';show variables like 'port';

        帮助的使用:
        ? contents;
        ? data type;
        ? int;
        ? create table;
        ? update;

二. 数据表的设计:
1. 数据表
2. 创建数据表的SQL语句模型
    DDL
    CREATE TABLE [IF NOT EXISTS]表名称(
        字段名1 列类型 [属性] [索引],
        字段名2 列类型 [属性] [索引],
        ...
        字段名n 列类型 [属性] [索引]
    ) [表类型] [表字符集];

    SQL语句不区分大小写, 表名就是文件名,windows不区分大小写, 但linux区分大小写;
    表名和字段名: 
        1. 一定要有意义
        2. 自己定义的名称最好都小写 
        3. SQL语句最好都大写
        

3. 数据值和列类型
    都是按空间大小来区分的

    1.数值型 
        整数型
            TINYINT 非常小的整型 1字节2^8 -128 ~ +127  无符号(unsigned) 0 ~ 255 
            SMALLINT 较小的整型   2字节2^16 -32768 ~ +32767  无符号(unsigned) 0 ~ 65535
            MEDIUMINT 中等大小的整型 3字节2^24
            INT 标准的整型  4字节 - 2^32
            BIGINT 大整数型    8字节  2^64

        浮点型, 小数点后会四舍五入,不能用于精确比较
            float(m,d) 4字节 m为总位数,d为小数点后位数; 
            duoble(m,d) 8字节 m为总位数,d为小数点后位数; 
            decimal(m,d) 定点数 m+2字节 m为总位数,d为小数点后位数; 定点数以字符串形式保存,小数点超出范围会有警告,能保存精确数值,用于货币等

    2.字符型, 单双引号,识别转义符 \ ,最大长度255 ,超过会截断
        char(m)  固定长度, 会自动去末尾空格;
        varchar(m) 可变长度, 所占字节数+1;

        test   文本数据, 保存文章,日记  长度2^16-1
            MEDIUMTEXT 长度2^24 -1
            LONGTEXT  长度2^32 -1

        blob   二进制数据, 保存压缩包,照片,音乐,电影,多媒体  长度2^16-1
            MEDIUMTEXT 长度2^24 -1
            LONGTEXT   长度2^32 -1
        
        ENUM    枚举  1或2个字节 ,一次只能用一个值
            ENUM('one','two','three','four')
        SET     集合  1,2,3,4,8个字节 , 一次可用多个集合中的值,用逗号分开
            SET('one','two','three','four')

    3.日期型
        DATE   YYYY-MM-DD
        TIME   hh:ii:ss
        DATETIME  YYYY-MM-DD hh:ii:ss
        TIMESTAMP YYYYMMDDhhiiss
        YEAR      YYYY
            create table test4(a date, b time, c datetime, d timestamp, e year);
            insert into test4 values('2001-12-03','121212','2013-12-11 09:09:09','20141109
075655','2015');
        不建议使用以上时间格式,用整数保存时间 int time();

    4.NULL

4. 数据字段属性
    1.  UNSIGNED 无符号, 让正符号空间增加一倍, 只能用在数值型
    2.  ZEROFILL 零填充, 自动前导用0补齐位数,自动 UNSIGNED, 只能用在数值型,
    3.  AUTO_INCREMENT 自增1,不允许重复,只能是整数型, NULL 0 留空情况也会自增1;每个表都最好有一个id字段,设为自增属性,配合索引属性使用;
    4.  NULL 和 NOT NULL; 默认值为空 NULL
        将来转为PHP程序数据时, 不确定转换具体数值, 建议创建表时,每个字段都不要插入空值, 使用 NOT NULL
    5.  DEFAULT 缺省值, 

        CREATE TABLE IF NOT EXISTS users(
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(30) NOT NULL DEFAULT '',
            height FLOAT(3,2) NOT NULL DEFAULT 0.00,
            sex ENUM('male','female','unknown') NOT NULL DEFAULT 'unknown',
            PRIMARY KEY (id)
        );

5. 索引 index 和 key 关键字是同义词;
    1. 主键索引 PRIMARY KEY 确定特定数据记录的位置; 不允许重复,不能为空; 索引名: primary; 最好为每一个数据表定义一个主键索引;一个表只能定义一个主键;
    2. 唯一索引 unique; 索引名:  字段名;
    3. 常规索引 索引名: 自定义;(分门别类), 降低增删改速度,提高查询速度, 用于需要根据数据 分组,查询, 排序的表, 可以单独使用, 也可以创建表时创建 
    4. 全文索引 fulltext类型, mysql5.6之前只能在MyISAM表类型上使用,只有在varchar , char, text文本字符串上使用,也可以多个数据列使用,并且不支持中文, 但有非官方开源项目支持中文;

        CREATE INDEX 索引名 ON 表名(字段名1,字段名2 ... );
        DROP INDEX 索引名 ON 表名;
        SHOW INDEX FROM 表名;
    eg:
        用alter关键字创建多个索引:
        ALTER TABLE tbl_feeds  
            ADD INDEX IX_Feeds_username (username),
            ADD INDEX IX_Feeds_userid (userid),
            ADD INDEX IX_Feeds_content (content)
        ;

        CREATE TABLE IF NOT EXISTS cart(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            number INT NOT NULL UNIQUE,
            uid INT NOT NULL,
            sid INT NOT NULL,
            bookname VARCHAR(30) NOT NULL,
            price DOUBLE NOT NULL,
            details TEXT NOT NULL,
            
            INDEX index_sid(sid),
            KEY index_uid(uid, number),
            FULLTEXT(details, bookname)
        );
        
        //普通查询,details全文索引字段名, php为要查找的关键字;
        SELECT * FROM cart WHERE details like '%php%'; 
        //利用全文索引查询 ,注意 details 和 bookname在同一个 FULLTEXT索引内;
        SELECT * FROM cart WHERE MATCH(details,bookname) AGAINST('php');

6. 数据表类型及存储位置
        MySQL有一个存储引擎概念, 可以针对不同需求选择最优的存储引擎;也叫数据表类型 ;
        
        显示支持的引擎类型: SHOW ENGINES;
        显示配置文件中默认表类型 show variables like 'table_type'; 
        注意: 一个库中可以用多种表类型
        创建表时选择类型;
        //CREATE TABLE 表名(字段名) TYPE = MyISAM;  //老版本,已不适用;
        CREATE TABLE 表名(字段名) ENGINE = InnoDB; //新版本

        主要 MyISAM 和 InnoDB

        MyISAM : 成熟稳定易于管理, 使用表格锁定机制,用于优化并发操作,
        代价是经常创建表之后需要使用命令来恢复更新机制所浪费的空间: OPTIMIZE TABLE 表名;强调快速读取操作;
        缺点: 一些功能不支持,比如外键;
        用于: “多读，少写”

        InnoDB : 采用表空间的概念,可以看成MyISAM的更新换代产品, 支持更多功能比如外键;
        缺点: 空间占用量比MyISAM大得多, 读取速度较慢;

        功能           MyISAM         InnoDB
        事务处理:       不支持           支持
        数据行锁定:     不支持           支持
        外键约束:       不支持           支持
        表空间占用:     相对小          相对大,最大2倍
        全文索引:       支持           MySQL5.6后支持,不支持默认值;
        存储文件内容: *.frm:表结构      *.frm:表结构 
                     *.MYD:表数据     *.idb:表索引和数据(MySQL5.6之前没这个文件)
                     *.MYI:表索引 

7. 默认字符集
        //字符集可在创建时指定,也可创建完后修改,但要注意不能通过修改数据库的字符集来直接修改已存放的数据内容;

        ASCII
        ISO-8859-1/Latin1 西欧字符集系列,常用于转码
        GB2312-80; 国标, 80年发布, 双字节定长,不推荐,
        GB13000.1-1993;   93年发布, 不推荐
        GBK; 汉字内码扩展规范 ,定长, 汉字双字节, 95年发布, 可以用
        GB18030-2005; 国标《信息技术 中文编码字符集》 , 2005年发布,不推荐;
        
        UNICODE系列:
        UTF-32  四字节
        USC-2   2字节 , 应用 windows2000
        UTF-16   2字节到4字节, java, windowsXP, windowsNT
        UTF-8    1字节到4字节, 变长, 汉字三字节 互联网,mysql,unix,linux广泛支持;推荐;
        在大量运算,汉字方面 GBK这种定长的更好, 但是同时需考虑客户端字符集转换损耗性能;
        
        MySQL服务器, 数据库, 数据表, 字段 都可以指定不同的字符集;
        显示支持的字符集: show character set; 
        //注意: UTF-8在数据库中的为UTF8;
        
        MySQL的字符集结构包括:
            字符集 :     定义MySQL存储字符串的方式;
            校对规则 :   定义比较字符串的规则方式;
                以其相关的字符集名开始,
                中间可加国家名,
                以_ci结尾表示大小写不敏感, 
                以_cs结尾表示大小写敏感,
                以_bin结尾表示二元,基于字符编码的值,大小写敏感, 二进制的比较;
            一对多的关系: 1个字符集可对应多个校对规则; 
        
        客户端与服务器交互时,三项字符集设置应该统一:
            character_set_client
            CHARACTOR_SET_CONNECTION
            CHARACTOR_SET_RESULTS
            set names 字符集, 同时修改以上三个值;


        通过 mysql 的 INFORMATION_SCHEMA信息数据库得到元数据
        //显示校对字符集: 
        DESC INFORMATION_SCHEMA.CHARACTER_SETS;
        //显示gbk对应的校对规则
        SHOW COLLATION LIKE 'gbk%';
        //显示服务器默认字符集
        SHOW VARIABLES LIKE 'CHARACTER_SET_SERVER';
        //显示服务器默认字符集校对规则
        SHOW VARIABLES LIKE 'COLLATION_SERVER';
        //创建指定字符集和校对规则的库;
        CREATE DATABASE demo DEFAULT CHARACTER SET UTF8 COLLATE UTF8_BIN;
        //创建指定字符集和校对规则的库,不指定则默认为库的, 一般没有必要;
        CREATE TABLE IF NOT EXISTS test(id int) ENGINE = InnoDB DEFAULT CHARACTER SET GBK COLLATE GBK_CHINESE_CI;
        //字段也可以设置,但是没有必要;
        //更改库的字符集 CHARACTER SET
        ALTER DATABASE CHARACTER SET GBK;
        //备份数据库;退出mysql后执行
        mysqldump -hlocalhost -uroot -p --default-character-set=gbk -d demo > D:/xampps/mysql/data/new_demo.sql
        //导入数据库,退出mysql后执行;
        mysql -hlocalhost -uroot -p test < D:/xampps/mysql/data/new_demo.sql

    8. 修改表  ? ALTER TABLE;
        
        ALTER TABLE test
        //添加字段
            ADD COLUMN name3 VARCHAR(30) NOT NULL DEFAULT '' AFTER id,
            ADD COLUMN name4 VARCHAR(30) NOT NULL DEFAULT '' FIRST;
        //删除字段
            DROP COLUMN name3
        //添加索引
            ADD INDEX index2 (name4)
        //修改字段属性,类型
            MODIFY name2 CHAR(3)
        //修改字段名和属性
            CHANGE name2 new_name2 CHAR(30)
        //修改表名
            RENAME AS test5;


9. 数据库中SQL语句操作 : 
        结构化查询语言(Structured Query Language)简称SQL
        DDL 数据定义语言, 其语句包括动词CREATE和DROP。 创建库,表
        DML 数据操作语言, 其语句包括动词INSERT，UPDATE和DELETE。它们分别用于添加，修改和删除表中的行。也称为动作查询语言。
        DQL 数据查询语言, 保留字SELECT是DQL（也是所有SQL）用得最多的动词，其他DQL常用的保留字有WHERE，ORDER BY，GROUP BY和HAVING。这些DQL保留字常与其他类型的SQL语句一起使用。
        DCL 数据控制语言, 更改权限,数据更改,它的语句通过GRANT或REVOKE获得许可，确定单个用户和用户组对数据库对象的访问。某些RDBMS可用GRANT或REVOKE控制对表单个列的访问。

语法:
    //条件可多个;可以使用运算符,字段当成变量,可使用逻辑运算符;
    增: insert into 表名[(字段列表)] values (值列表1) [,(值列表2)];
    
    删: delete from 表名 [where 条件] ; alter table 表名 drop column 字段名; 

    截断/清空表(不影响表结构): TRUNCATE 表名;
    
    改: update 表名 set 字段1="数值" [,字段2=concat('字符串',字段2)...] [where 条件]
    
    查: select 字段名 from 表名 [条件];
            all | distinct // 整行结果去重
    详解:
        select 字段名 [, 字段名2...]
    字段名格式:   [表名.]* | [表名.]字段名 [as 别名]  
    //1. 需要列出查询的字段
    //2. 别名的 as可省略, 用于: 多表查询两表字段冲突,和系统关键字冲突, 原字段包含特殊字符或符号 , 
    //3. 表也可以取别名;表取别名后,整条语句用到的地方都需使用该别名;
    //4. distinct 参数为整行去重复;
    //5. 在SQL语句中使用表达式的列(算术运算符,条件,逻辑运算符)
        from  表名(表的表达式) [,表名2...]
        
        //以下为可选条件
        where 条件
    // 1. where 可用在 delete, update, select 语句
    // 2. 逻辑运算符(多条件组合); && AND  ,  || OR , ! NOT
    // 3. 比较运算符 
            等于 = , <=>, <=> 和=运算符不同的是，可用于NULL值比较, 
            不等于 !=, <>, 
            >=, <=, > , <,
            is null,
            is not null,
            between 在某个范围内, where 字段名 between 值1 and 值2 , 包括值1和值2;
            not between , 也包括值1和值2;
            IN 在某个列表范围内, where 字段名 in ('值1','值2','值3' ...)
            
            //模糊查询:
            like 搜索某种模式 模糊查询符号: '%' 0个或多个任意字符;'_'  一个任意字符;
            not like
            REGEXP  正则 

        //多表查询(连接查询), 分为等值 和 非等值 等种类;
        //嵌套查询
        
        group by 分组查询

            //统计函数
            count() 总个数
            sum() 总和
            avg() 平均值
            max() 最大值
            min() 最小值

            having 分组条件

            SELECT column_name, aggregate_function(column_name)
            FROM table_name
            WHERE column_name operator value
            GROUP BY column_name
            HAVING aggregate_function(column_name) operator value
        
        8、Having与Where的区别
        where 子句的作用是在对查询结果进行分组前，将不符合where条件的行去掉，即在分组之前过滤数据，where条件中不能包含聚组函数，使用where条件过滤出特定的行。
        having 子句的作用是筛选满足条件的组，即在分组之后过滤数据，条件中经常包含聚组函数，使用having 条件过滤出特定的组，也可以使用多个分组标准进行分组。

        详见: http://www.cnblogs.com/rainman/archive/2013/05/01/3053703.html

        //排序方式
        order by 字段 ASC(正序, 默认) | DESC(倒序)

        limit 限制条件
            count 限制数量

        procedure

        into outfile

        for update

特殊符号:
' '   -- 单引号
" " --双引号
& -- 并且
||  -- 连接符
@ --定义变量
% -- 模糊查询符号,0个或多个任意字符;
*  -- 通配符
_  -- 模糊查询符号,一个任意字符
()  -- 括号 
--  --注释
   
eg:
    
 1. 设置环境变量, 设置mysql启动参数 my.ini —— skip-grant-tables。启动mysql时不启动grant-tables，授权表。有什么用呢？当然是忘记管理员密码后有用。

 2. 连接数据库: 运行cmd 输入mysql -u root -h localhost -p;  MYSQL 命令:mysql -h主机地址 -u用户名 -p密码 

 3. 查找用户表: select * from mysql.user\G; 

 4. 创建数据库: create database testphp;

 5. 显示数据库: show databases; (注意为复数)

 6. 切换默认数据库: use testphp;

 7. 显示数据表: show tables;

 8. 创建数据表: 
    create table if not exists carts(
        id int not null auto_increment,
        pid int not null default '0',
        name varchar(30) not null default '',
        desp text not null,
        primary key(id),
        index name(name,pid)
    ); 
    create table if not exists products(
        id int not null auto_increment,
        cid int not null default '0',
        name varchar(30) not null default '',
        num int not null default '0',
        price double(7,2) not null default '0.00',
        desp text,
        ptime int not null default '0',
        primary key(id),
        key pname(name,price)
    );

9.  查看表结构 desc carts;

10. 查看创建表的语句 show create table users;

11. 增: 插入表数据 
    //建议: 字段不加引号, 值都加引号, 插入数据时给字段列表;
    insert into carts(pid, name, desp)
    values
    ('11', 'book', 'its a book'),
    ('22', 'orange', 'its a fruit')
    ;

12. 删: delete from users where id=2;

13. 改: update users set username='wang5', age=25 where id = 1;

14. 查: 查找表数据,查并执行特殊反馈:
    SELECT DISTINCT pid, name new_name, age+10 AS age10 FROM carts WHERE age>20 && age<30 AND name like '%book%' OR uname REGEXP '^book';
    
    select concat(name,'的描述是' ,desp) from carts;

    多表连接查询:
    //字段冲突需用 表名.字段名 , 取得的rows是数值相乘; 表取别名后,整条语句用到的地方都需使用该别名;
    SELECT c.id, pid, cid, c.desp AS cartsDesp FROM carts c, products AS p WHERE c.id = p.cid AND c.pid = '11';

    单表连接查询: 
    SELECT a.id AS aid, b.id AS bid, a.pid apid , a.name AS aname, b.name AS bname, a.desp AS aDesp FROM carts a, carts b WHERE b.pid = 11  ORDER BY aname LIMIT 3;

    //嵌套查询(子查询)
    SELECT * FROM carts WHERE id IN(SELECT id FROM carts WHERE name LIKE 'b%' AND id < 6) ORDER BY id DESC LIMIT 1;

    //分组查询
    

16. 删除表 drop table users;
17. 删除库 drop database testphp;
18. 设置传输字符集: set names utf8;
19. 添加列/字段： alter table 表名 add column 字段名 类型
20. 删除列/字段： alter table 表名 drop column 字段名
21  查询后连接 select concat(t1,'#'), concat(t2, '#') from testtable;

//phpmyadmin

三. MYSQL的内置函数:
    函数可用于 UPDATE, DELETE, SELECT及其子句 where order by having
    可以将字段名作为变量使用, 变量值就是输出列的对应的每一行记录;

1. 字符串函数 
    //注意 ,在MySQL中, 字符串位置是从1算起的;
    1. CONCAT() 连接字符串;
    2. INSERT(str, x, n, insert_str); 将字符串str从x位置开始的n个字符长度,替换为insert_str
        eg: SELECT INSERT('abcdefg',2,3,'66666'); //a66666efg 
    3. LOWER(), UPPER(), 将传入的字符串的大小写转换;
    4. LEFT(str, n) , RIGTH(str, n) 分别返回字符串str 左右两边的n个字符, n为空的话则无返回值;
    5. LPAD(str, n, pad_str),RPAD(str, n, pad_str), 对字符串str两边填充或裁剪到总长度为n,填充素材为pad_str;
        eg: select 
            lpad('abc',6,'123456789'),  //123abc
            rpad('abc',6,'123456789'),  //abc123
            rpad('abc',9,'12');  //abc121212 素材长度不够则重复调用;
            lpad('abcdefg',3,'123456789'); //abc 裁剪
    6. TRIM(str) , LTRIM(str), RTRIM(str) 去除空格;
    7. REPLACE(str, old_substr, new_substr) 用 new_substr 替换掉 str 中的所有 old_substr;
    8. STRCMP(str1, str2) 按ASCII码比较, 如果str1 > str2 返回1, 相等返回0, 小于返回-1;
    9. SUBSTRING(str, x, n); 返回str第x位置起, 长度为n的字符串; 

2. 数值函数
    1. ABS(n): 绝对值
    2. CEIL(n) 向上舍入, FLOOR(n) 向下舍入
    3. ROUND(x, y) 返回x的四舍五入结果,保留y位小数, 没有y则不保留小数;
    4. TRUNCATE(x, y) 返回数字x的截断, 小数点后保留y位;
    5. MOD(x, y) 求模 x%y
    6. RAND() : 随机数 0-1, 包含0,不包含1;
    
3. 日期函数
    1. CURDATE() 返回当前日期;
    2. CURTIME() 返回当前时间;
    3. NOW() 返回日期和时间;
    4. UNIX_TIMESTAMP(); 返回unix时间戳; 
    5. FROM_UNIXTIME( unix时间戳 ); 返回 unix时间戳 所对应的时间;
        eg: 返回当前的时间戳所描述的时间  FROM_UNIXTIME(UNIX_TIMESTAMP(NOW()));
    6. 返回个别时间: //参数使用 NOW()返回的格式;   
        WEEK(NOW()) : 本年的第多少周; 
        YEAR(): 年份; 下略: 
        MONTH(); MONTHNAME();
        DAY();
        HOUR();
        MINUTE();
        SECOND();
    7. 自定义时间格式化 DATE_FORMAT(NOW(), '%Y年%m月%d日 %H时%i分%s秒');

4. 流程控制函数:
    1. IF(bool, x, y); 如果bool为真返回x,否则返回y
        eg: select if(salary>2000, 'high','low') from salary;
    2. IFNULL( x, y); 如果x不为空则返回x,否则返回y;
        eg: select id, salary,name, ifnull(name, '无名') from salary;
    3. CASE WHEN('条件1') THEN ('结果1') ... ELSE('默认结果');
        eg: SELECT *, CASE WHEN( salary< 2000 ) THEN ('低薪') WHEN( salary >=3000) THEN('高薪') ELSE('默认') END FROM SALARY;

5. 其他函数
    DATABASE(); 当前数据库命
    VERSION();  MySQL版本 
    USER();    当前用户
    INET_ATON(ip) 返回IP地址代表的网络字节序; eg: select INET_ATON('192.168.0.1'); //3232235521
    INET_NTOA() 返回网络字节序代表的IP地址  eg: select INET_NTOA('3232235521'); // 192.168.0.1
    PASSWORD() 将字符串加密 ,一般用于给 MySQL系统本身用户加密
    MD5() 加密,给应用层用户加密

四. 扩展库. Mysql, Mysqli 及PDO

