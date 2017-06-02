零. 数据查询
--在DDL中，创建、删除、修改使用create、drop、alter关键字
--数据库的创建
create database school
--删除数据库
drop database school


--创建表
create table TblClass
(
     cid int identity(1,1) primary key not null,
     cName nvarchar(10) not null,
     cDescription nvarchar(100) default('这是一个热血沸腾的班级')
)


--查询表
select * from TblClass
--删除表
drop table TblClass
--增加约束
alter table tblclass
add constraint CK_CName check (len(cName)>2)
--修改列类型
alter table tblclass
alter column cDescription nvarchar(1000)
--添加列
alter table tblclass
add aa int
--删除列
alter table tblclass
drop column aa

--DML一:插入语句
--标准的插入语句
insert into tblclass(cname,cdescription) values('黑马八','好黑呀')

--变形1:插入部分列,要求将所有非空列都写出来
insert into tblclass(cname) values('java一')

--变形2:插入所有列,活略列名部分,要求是除了标识列以后都插入数据
insert into tblclass values('java二','好扎呀')

--强制为标识列插入数据
set identity_insert tblclass on
insert into tblclass(cid,cname) values(100,'android一')

--关闭手动插入标识列
set identity_insert tblclass off

--插入一个单引号
insert into tblclass(cname) values('a''二')

--强制存储中文
insert into tblclass(cname) values(N'aa三')
insert into tblclass(cname) values(N'张三jj')

select * from tblclass

--DML二:修改语句
--格式一:修改所有行
update tblclass set cDescription='欢迎'

--格式二:修改指定行,加where子句
update tblclass set cname='黑马七',cDescription='已毕业,就业情况还可以' where cid=101
update tblclass set cname='java一',cDescription='在校生,应聘中' where cid=1
select * from tblclass

--DML三:删除语句
--格式一:删除指定条件的行
delete from tblclass where cname='aa三'
delete from tblclass where cname='张三aa'

--格式二:无条件删除,会删除所有行
delete from tblclass
--清空
truncate table tblclass
--基本格式
select * from tblclass
--对于列进行限制
--格式一：取指定列
select cid,cname from TblClass
select cname from TblClass
--格式二：为列起别名as
select cid as 编号,cname 名称,描述=cdescription from TblClass
select cid as 序号,cname 姓名,描述=cdescription from TblClass

--对于行进行限制
--关键字top：表示取前n的数据
select top 3 * from TblClass
select top 2 percent * from TblClass  百分之二的程序
--关键字distinct：消除重复项
select cdescription from TblClass
select distinct cdescription from TblClass
select * from TblClass
select distinct cName from TblClass


--where子句
--查询编号大于5的班级
select * from TblClass
where cid>5

--比较运算符：> < >= <= <> !=
--查询班级编号在5至8之间的班级信息
select * from TblClass
where cid>5 and cid<8--逻辑运算符：and(&&) or(||) not(!)
--查询班级编号在5至8之间并且描述信息的字符个数大于3的班级信息
select * from TblClass
where cid>5 and cid<8 and LEN(cDescription)>3

--查询班级编号在5至8之间或描述信息的字符个数大于3的班级信息
select * from TblClass
where (cid>5 and cid<8) or (LEN(cDescription)>3)--运算符优先级
--not的优先级最高，仅次于小括号

--取范围，表示在一个连续的范围内between ... and ...[5,8]
select * from TblClass
where cid between 2 and 8
--=============
select * from TblClass
where (cid between 2 and 8) and (LEN(cDescription)>3)
--in：取范围，表示一个不连续的范围

--查询编号为1,4,8的班级
select * from TblClass
where cid=1 or cid=3 or cid=8

计算两个日期之间相差*年*月*天
--测试数据：1996-06-09，2015-12-1
--如果日期差值大于30天，并且大于12个月，则输出相差年数月数天数
select datediff (year,'1996-6-9','2015-12-1'),
     datediff (month,'1996-6-09','2015-12-1')%12,
     datediff(day,'1996-6-9','2015-12-1')%30




--===============================
select * from TblClass
where cid in(1,2,8)
--模糊查询：like _：任意一个字符 %：任意多个字符
--[]：显示一个连续区间 ^：放在[]中表示非
select * from TblClass
where cDescription like '%赵剑雨%'
--查询在描述中以'黑'开头并且是2个字符的信息
select * from TblClass
where cDescription like '黑_'

--查询描述中包含'%'的班级，转义：使用[]括起来
select * from TblClass
where cDescription like '%[%]%'

--[4-7]表示4,5,6,7
--[4,7]表示4,7
--[47]表示4,7
--查询描述中包含4-7的信息
update TblClass set cDescription=cDescription+CAST(cid as CHAR(1))
select * from TblClass
where cDescription like '%[4-7]'

--查询描述中不包含4-7的信息
select * from TblClass
where cDescription like '%[^4-7]'



--插入空的信息
insert into TblClass values('赵武44',null)
--空值判断is [not] null
select * from TblClass
where cDescription is not null
--函数isnull:判断值是否为空，如果为空，不显示null而给一个默认值
--注此代码不是改实际的数据，局限于显示是的一个提示
select cid,cName,ISNULL(cDescription,'暂未开班') from TblClass
--============================================
--order by 子句排序子句 asc升序 desc降序
select * from TblClass
--order by cid[ asc]--按cid升序排列
--order by cid desc
order by cid desc,cName asc--可以按照多列排序
--============================================
--分组子句group by ... having ...
--聚合函数
--聚合：把多行合并成一行
--use ItCastCn
select * from tblscore
--找出英语成绩的最高分
select MAX(tenglish) from tblscore
--找出数学成绩的最低分
select MIN(tmath) from tblscore
--查询英语的平均成绩
select AVG(tenglish) from tblscore
--求数学成绩的总和
select SUM(tmath) from tblscore
--求参加考试的人数
select count(*) from tblscore
select COUNT(*) from tblstudent
select * from tblscore
-=================================================
--分组：统计各班人数
--出现分组中的列，可以出现在查询结果中，其它的列不可以与聚合函数一起出现在结果中
select tsclassid,COUNT(*) as 人数 from tblstudent
group by tsclassid
 

--做选择having：在分组后，对结果集进行筛选
--查找出班级人数大于5的班级信息
select tsclassid,COUNT(*) as 人数 from tblstudent
group by tsclassid having COUNT(*)>5
--综合语句练习
select distinct top 1 tsclassid,COUNT(*) AS 人数,avg(tsage) as 平均年龄
from tblstudent
where tsGender='男'
group by tsclassid having tsclassid>3
order by 平均年龄 desc
--作业：学生表操作

select * from tblstudent

--=======================================================
--查询所有女生的信息

--查询班级为3的男生信息
select * from
--查询姓'张'的男学生
select * from tblstudent where cName like '张_'
--找出各个城市的人数及城市名称

--找出各班中最多人的城市名称


--查询所有英语及格的学生姓名、年龄及成绩
--1：结果数据：姓名tblstudent.tsname，年龄sblstudent.tsage，成绩tblscore.tenglish
--2：条件：英语成绩>60 、
】
--3：需要使用连接查询，使用内连接，关系：tblstudent.tsid=tblscore.tsid
create table TBlStudent
(
     tsid int identity(1,1) primary key not null,
     tsname nvarchar(10) not null,
     tsage nvarchar(4) not null,
     tenglish nvarchar(4) not null
)
--删除tenglish 列
alter table TblStudent drop column tenglish
select * from TblStudent
insert into TblStudent (tsname,tsage) values ('张三','19')
insert into TblStudent (tsname,tsage) values ('李四','20')

create table TblScore
(
     tsid int identity(1,1) primary key not null,
     tenglish nvarchar(4) not null
)
select * from TblScore
insert into TblScore(tenglish)values('60')
insert into TblScore(tenglish)values('70')

select tsname,tsage,tenglish
from TblStudent
inner join TblScore on TblStudent.tSId=TblScore.tSId
where tEnglish>50

--查询所有没有参加考试的学生的姓名
--1、结果集：姓名tblstudent.tsname
--2、条件：学生编号不在tblscore表中出现 not in()
select tsname from TblStudent
where tSId not in(select tSId from TblScore)
--=======================================================

--分组使用多个属性
--查询：每个班级的各地区有多少人
select tSClassId,tSAddress,COUNT(*)
from TblStudent
group by tSAddress,tSClassId

----找出各班中最多人的城市名称
--1、结果集：班级编号tsclassid,城市名称tsaddress
--2、条件：各班级：group by tsclassid,tsaddress
select tsclassid,COUNT(*)
from TblStudent
group by tSClassId
-==============================================================
--计算出各员工的工龄：强调，给2年的员工发奖金
select *
from TblEmployee
where DATEDIFF(DAY,EmpJoinDate,GETDATE())+1>=730

--计算两个日期之间相差*年*月*天
select * from TblStudent
--求两个日期之间差“*年*月*天”
--设定:一个月按30天算

--测试数据一：2012-12-31，2013-1-1
--如果日期差值小于30天,则直接输出相差天数
select DATEDIFF(day,'2012-12-31','2013-1-1')

--测试数据二：2012-10-14，2013-3-12
--如果日期差值大于30天,并且小于12个月,则输出相差月数及天数
select DATEDIFF(DAY,'2012-10-14','2013-3-12')/30,
     DATEDIFF(DAY,'2012-10-14','2013-3-12')%30

--测试数据三：1994-02-03,2013-10-13
--如果日期差值大于30天，并且大于12个月，则输出相差年数月数天数
select DATEDIFF(DAY,'1994-02-03','2013-10-13')/360,
     DATEDIFF(DAY,'1994-02-03','2013-10-13')%360/30,
     DATEDIFF(DAY,'1994-02-03','2013-10-13')%30

select DATEDIFF(YEAR,'1994-2-3','2013-10-13'),
     DATEDIFF(MONTH,'1994-2-3','2013-10-13')%12,
     DATEDIFF(DAY,'1994-2-3','2013-10-13')%30


--=========================================================

select * from TblClass
--===============类型转换函数
--cast(值as 类型)
update TblClass set cDescription=cDescription +cast( cid as CHAR(2 ))
update TblClass set cDescription=cDescription +'100'
select CAST ('123.456' as float )
--convert(目标类型, 值[,format])
select CONVERT (float, '123.456')
--格式化
select CONVERT (decimal( 10,2 ),'123.456789123')
select CONVERT (float, '123.456',1 )
select '2013-10-12' --2013/10/12
select convert (datetime, '2013-10-12')
--将日期转为字符串，可以进行格式化处理
select CONVERT (varchar( 10),getdate (),102)
select CONVERT (varchar( 50),getdate ())
--10 12 2013  2:17PM
--============================
--字符串函数
select UPPER ('abc中国 ')
select * from TblClass
select LEN (cdescription) from TblClass --输出字符串的长度
--注意：没有trim函数
--字符串截取：left,right,substring
--下标从开始
select SUBSTRING ('abcdef中国 ',3 ,5)
--=======================
--日期时间函数
select GETDATE ()
--增加时间
select DATEADD (YEAR, 5,GETDATE ())
select DATEADD (month, 5,getdate ())
--两个时间做差
select DATEDIFF (YEAR, '2013-1-1','2012-12-31' )
select DATEDIFF (DAY, '2012-5-1','2012-12-31' )
--取日期中的某一部分
select * from Employee
select DATEPART (DAYOFYEAR, edate) from Employee
select YEAR (edate) from Employee
select DATEPART (Hour, GETDATE())


--查询每天的数据总和如果没有数据就自动补
select getdate lefr join sum() on table .date= getdate
select month (a. OrderDate),sum (b. UnitPrice)
--select 表数据left jion (select 当前月份的天数 )
from Orders a left join Orderdetails b on b. OrderId=a .OrderID group by month(a .orderDate)
select convart(varchar (10),dateadd(DD ,number,datename(YY ,getdate())+datenane (MM,getdate())+'01' ),23) AS DeliveryDate from master.. sql_values where type='p' AND number <DAY (dateadd( MM,1 ,getdate())- DAY(getdate ()))
