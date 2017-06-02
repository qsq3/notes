<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');

关于: 根目录下新建文件: phpinfo.php  phpinfo();

Loaded Configuration File为安装目录

输出语句:
（1）echo"helloworld！";---echo命令   能够输出一个以上的字符串,数字, 输出布尔值true为1, false为空;
（2）print();输出语句，是函数，有返回值。输出成功返回1，失败返回0。 只能输出一个字符串，并始终返回 1
（3）printf();格式化输出字符串。例：printf("%d,%f",12,12.3); 
（4）sprintf();格式化拼接字符串，不是输出语句，只能将字符串拼接。 
（5）print_r();输出数组、对象等复合数据类型
如果你只想输出静态文件，那么echo()和print()都可以，但是据说echo()在效率上快些，因为它什么也不返回，但print()则不同，如果成功输出，则会返回1；但是如果你想把一个动态数据推入到一个原本是静态的文本中，则你得使用printf()．sprintf()函数与printf()相同，但它将输出放入到一个字符串中，而不是直接输出到浏览器．

一、echo
echo() 实际上不是一个函数，是php语句，因此您无需对其使用括号。不过，如果您希望向 echo() 传递一个以上的参数，那么使用括号会发生解析错误。而且echo是返回void的，并不返回值，所以不能使用它来赋值。
例子：
$a = echo("xshell"); // 错误！不能用来赋值
echo "xshell"; // xshell
echo ("xshell"); // xshell
echo ("xshell","net"); //发生错误，有括号不能传递多个参数
echo "xshell"," net"," is", " web"; // 不用括号的时候可以用逗号隔开多个值， 会输出 xshell net is web
echo "xshell is
good
web."; // 不管是否换行，最终显示都是为一行 xshell is good web.
echo "$fistname net"; // 如果 $firstname = "xshell", 则会输出 xshell net.
echo '$firstname net'; // 由于使用单引号，所以不会输出$firstname的值，而是输出 $firstname net
?>
二、print
print() 和 echo() 用法一样，但是echo速度会比print快一点点。实际上它也不是一个函数，因此您无需对其使用括号。不过，如果您希望向print() 传递一个以上的参数，那么使用括号会发生解析错误。注意print总是返回1的，这个和echo不一样，也就是可以使用print来赋值，不过没有实际意义。
例子：
$a = print("xshell"); // 这个是允许的
echo $a; // $a的值是1
?>
三、print_r 函数
print_r函数打印关于变量的易于理解的信息。
语法：mixed print_r ( mixed $expression [, bool return ] )
如果变量是string , integer or float , 将会直接输出其值，如果变量是一个数组，则会输出一个格式化后的数组，便于阅读，也就是有key和value对应的那种格式。对于object对象类同。print_r有两个参数，第一个是变量，第二个可设为true，如果设为true，则会返回字符串，否则返回布尔值TRUE。
例子：
$a="xshell";
$c = print_r($a);
echo $c; // $c的值是TRUE
$c = print_r($a, ture);
echo $c; // $c的值是字符串xshell
?>
四、printf函数
printf函数返回一个格式化后的字符串。
语法：printf(format,arg1,arg2,arg++)
参数 format 是转换的格式，以百分比符号 (“%”) 开始到转换字符结束。下面是可能的 format 值：
* %% – 返回百分比符号
* %b – 二进制数
* %c – 依照 ASCII 值的字符
* %d – 带符号十进制数
* %e – 可续计数法（比如 1.5e+3）
* %u – 无符号十进制数
* %f – 浮点数(local settings aware)
* %F – 浮点数(not local settings aware)
* %o – 八进制数
* %s – 字符串
* %x – 十六进制数（小写字母）
* %X – 十六进制数（大写字母）
arg1, arg2, arg++ 等参数将插入到主字符串中的百分号 (%) 符号处。该函数是逐步执行的，在第一个 % 符号中，插入 arg1，在第二个 % 符号处，插入 arg2，依此类推。如果 % 符号多于 arg 参数，则您必须使用占位符。占位符被插入 % 符号之后，由数字和 “$” 组成。可使用数字指定显示的参数，详情请看例子。
例子：
printf("My name is %s %s。","xshell", "net"); // My name is xshell net。
printf("My name is %1$s %1$s","xshell", "net"); // 在s前添加1$或2$.....表示后面的参数显示的位置，此行输出 My name is Ricky Ricky因为只显示第一个参数两次。
printf("My name is %2$s %1$s","xshell", "net"); // My name is net xshell
?>
五、sprintf函数
此函数使用方法和printf一样，唯一不同的就是该函数把格式化的字符串写写入一个变量中，而不是输出来。
例子：
sprintf("My name is %1$s %1$s","xshell", "net"); //你会发现没有任何东西输出的。
$out = sprintf("My name is %1$s %2$s","xshell", "net");
echo $out; //输出 My name is xshell net
?>
六、var_dump函数
功能: 输出变量的内容、类型或字符串的内容、类型、长度。常用来调试。
$a=100;
var_dump($a); //int(100)
$a=100.356;
var_dump($a); //float(100.356)
?>



第一个程序
        <script>alert("客户端时间"+ (new Date()))</script>
	    <h2>
            <?php echo"服务器端时间" .date("Y-m-d H:i:s"); ?>
        </h2>
纯php文件中不加php结束符是一个好习惯, 防止意外空格注入

功能执行语句,后面必须加分号;结束符前一句可不加
    echo "aaa";

结构定义语句,后面一定不要加分号;
if(){}
while(true){}
function demo(){}

注释:
// 单行   # 单行 脚本注释
/*  */ 多行
/**   */ 文档注释
注释写在代码上面或右边, 不要写在下面

空行规范:
一个空行:
    两个函数声明之间;
    函数内局部变量和第一条语句之间;
    注释之前;
    一个函数的两个逻辑代码段;

二个空行:
    一个源文件的两个代码段;
    两个类的声明;

php的四种标记:

    普通:   <?php 
                echo "111"; 
                $str = "111";
            ?>

    短标签(short_open_tag 需配置打开;会发生冲突): 
        <? echo "222"; ?>   <?=$str ?>  

    asp方式: <%
                echo "我们交个朋友<br/>";
            %>

    script格式: <script language="php">
                    echo "不行";
                </script>

变量的声明:
	弱类型; $ 开头; = 两边空格; 见名知意; 驼峰命名;
	不能以数字开头; 不能有运算符号; 可能使用关键字(前置$); 只有变量名和常量名区分大小写;
	只有变量才有地址(引用);

PHP对大小写敏感问题的处理比较乱，写代码时可能偶尔出问题，所以这里总结一下。
http://blog.sina.com.cn/s/blog_65f387740100jy70.html
但我不是鼓励大家去用这些规则。推荐大家始终坚持“大小写敏感”，遵循统一的代码规范。
1. 变量名区分大小写
1 <?php
2 $abc = 'abcd';
3 echo $abc; //输出 'abcd'
4 echo $aBc; //无输出
5 echo $ABC; //无输出
2. 常量名默认区分大小写，通常都写为大写
（但没找到能改变这个默认的配置项，求解）
1 <?php
2 define("ABC","Hello World");
3 echo ABC; //输出 Hello World
4 echo abc; //输出 abc
3. php.ini配置项指令区分大小写
如 file_uploads = 1 不能写成 File_uploads = 1
3. 函数名、方法名、类名不区分大小写
但推荐使用与定义时相同的名字
1 <?php
2 function show(){
3 echo "Hello World";
4 }
5 show(); //输出 Hello World 推荐写法
6 SHOW(); //输出 Hello World
1 <?php
2 class cls{
3 static function func(){
4 echo "hello world";
5 }
6 }
7
8 Cls::FunC(); //输出hello world
4. 魔术常量不区分大小写，推荐大写
包括：__LINE__、__FILE__、__DIR__、__FUNCTION__、__CLASS__、__METHOD__、__NAMESPACE__。

1 <?php
2 echo __line__; //输出 2
3 echo __LINE__; //输出 3
5. NULL、TRUE、FALSE不区分大小写

01 <?php
02 $a = null;
03 $b = NULL;
04
05 $c = true;
06 $d = TRUE;
07
08 $e = false;
09 $f = FALSE;
10
11 var_dump($a == $b); //输出 boolean true
12 var_dump($c == $d); //输出 boolean true
13 var_dump($e == $f); //输出 boolean true 

<?php	
	$name = "名字";
	$age = 20;
	$a = $b = $c = 10;

//常用方法:
	var_dump($a); //输出指定变量的值和类型;
	unset($a) ;//释放指定变量;
	var_dump(isset($a)); //检测变量是否设置; //bool(false)
	var_dump(empty($a));//检测变量是否为空;//bool(true) //empty检测0,null,空字符串,未声明的变量都为true;
?>

可变变量:
<?php 

	$hello = "world";

	//把变量值作为变量名;可多层; 必须$$在一起;
	$$hello = "你好";

	echo $world;
?>

引用变量: 
	取址符号 & ,返回指定变量的地址;
	格式 $b = &$a;
	1.只有变量才有地址(引用);
	2.如果两个变量是引用关系,一个变量发生变化,另一个的值也会发生变化;
		但如果给其中一个变量新的引用,则改变引用关系(相当于把别名变量中保存的地址改变了)
	3.在使用unset函数时,如果有引用关系,只是解除引用关系;(相当于把别名变量中保存的地址改变了)
<?php
	$a = 10;
	$b = &$a;
	$a = 11;

	//unset($b);
	
	echo($b);

	if(isset($b)){
		echo "存在";
	} else {
		echo "不存在";
	}

?>

变量的八种类型:
	四种标量(基本)类型:
		布尔值(boolean)(bool),
            为false的其他类型: 
            boolean: false; int: 0; float: 0, 0.00...; string: "","0"; array: []; PHP4以下的空对象; NULL;
            其他均为true;
            true + false === 1;

        整型(integer)(int), 最大长度 -2^31 ~ (2^31-1);超出变为float类型;

        浮点型(float) / (double) /(real), 最大值2^64;双精度;
            科学计数法: 3e+5;
            近似数;
            
        字符串(string);
            1. 1个或多个字符都为字符串;
            2. 声明一个字符串必须使用单/双引号;
            3. 没有长度限制;
            4. 单/双引号可以互相嵌套;
            5. 可以使用转义字符\;

            PHP中单双引号的区别:
            1. 双引号中可以解析变量,需要特殊符号隔开; 单引号不行;
            2. 双引号中可以使用转义字符; 单引号不行(只能转义单引号和\);
            3. 转义字符: \r\n   \t  \\  \$ \" 
                \[0-7]{1,3} //(正则,匹配八进制) 
                \x[0-9A-Fa-f]{1,2} //(正则,匹配十六进制) 
            4. 单引号效率较高,双引号功能较强;
            
            定界符号: <<<
            1. 使用<<<小于号, 开始位置要紧挨=号(不能空格,直接回车,后面也不能跟其他字符),结束位置要顶格(不能空格):
            2. 定界符内默认支持双引号功能, 可以使用转义符号;
            3. 使用''在开始定界符中,将支持双引号的功能,改成了支持单引号的功能;

               $str =<<<hello
            this is a  demo
            this is a  "de \n mo"
            this is a  demo
hello;

	两种复合类型:
		数组(array),
        对象(object);

	两种特殊类型:
		资源(resource),
        空值(null);


<?php
	
	echo "以下为4种标量类型<br/>";
	$var = true;
	$var = "123";
	//$var = 10.01;
	//$var = 10.0;

    echo ord($var); //输出第一个字符对应的ascII码
	var_dump($var);
	echo "<br/>";

	echo "以下为2种复合类型<br/>";

	$var = array('1',"3","2");
	class Demo {
		var $one = 10;
		var $two = 20;
	}
	$var = new Demo;

	var_dump($var);

	echo "以下为2种特殊类型<br/>";

	$var = mysqli_connect("localhost","root","root");
    if($var){
        echo "真,连接成功";
    } else {
        echo "假,连接失败";
    }

    echo "<br/>";
	var_dump($var);
	echo "<br/>";
	
	$var = null;
	var_dump($var);
	echo "<br/>";

    
    //整型和浮点型
    $a = 10;
    $b = 010; //八进制;
    //mkdir("/user/hello", 0755); //创建目录,0755为八进制,为linux下给所属用户可读可执行权限;
    $c = 0xDD; //十六进制  //颜色十六进制;
    echo $a;
    echo "<br/>";
    echo $b;
    echo "<br/>";
    echo $c;
    echo "<br/>";
    //输出都为十进制
    
    //科学计数法
    $a = 3E5; 
    var_dump($a);
    echo "<br/>";

    $a = '这是一个 "demo"';
    echo $a;

    echo "这是一个 $a <br/>" ; //嵌套变量;

    echo "这是一个{$a}后面无空格<br/>" ; //嵌套变量;{}包裹

    两种复合类型:
		数组(array),
        对象(object);

	两种特殊类型:
		资源(resource),
        空值(null);

//1.数组:
    $arr = array(1,2,3);
    $arr2 = array(
        "foo" => "bar",
        12 => true
    );
    echo $arr;
    echo $arr2;

//2.对象:
    class Person {
      var $name1 = '张三';
      var $sex = 'male';

      function say() {
        
      }

      function eat() {
      
      }
    }
    
    $person = new Person();

//3.  资源
    $file = fopen("test.txt","r");

    echo fread($file);

    fclose($file);

//4. null = unset(); 被赋值为null的变量,尚未赋值的变量,被unset()销毁的变量;


//5. 伪类型(只是在注释中起说明作用)
    mixed: 说明一个参数可以接受多种不同的(但并不必须是所有的)类型.
    number : 说明一个参数可以是 integer 或 float;
    callback: 有些诸如call_user_function() 或 usort()的函数接受用户自定义的函数作为一个参数. callback函数不仅可以是一个简单的函数,他还可以是一个对象的方法包括静态类的方法;

    一个php函数用函数名字符串来传递. 可以传递任何内置的或者用户自定义的函数,除了array(), echo(), empty(), eval(), exit(), isset(), list(), print() 和unset().


数据类型之间的转换:

一. 强制转换:
    var_dump();
    getType(变量);
    1. setType(变量, 类型);
    2. 在变量使用时,前面加上类型符号;
    3. 类型值转换:intval(),floatval(),strval();转换成对应类型值
    4. 类型转换:
        布尔值(boolean)(bool);
        整型(integer)(int)
        浮点型(float) (double) (real),
        字符串(string),
        数组(array),
        对象(object);
        资源类型不能转换
        //注意:在括号内允许有空格和制表符,为了将一个变量还原为字符串,还可以将变量放置在双引号中;
        //任何数据类型可转换为数组,结果是,该变量成了数组的第一个下标的属性值;
        $a = 114;
        $b = (array) $a;
        echo $b[0]; // 114;
        //任何数据类型可转换为对象,结果是,该变量成了对象的scalar的属性值;
        $b = (object) $a;
        print $b->scalar; // 114;

    <?php
        $a = '10';
        setType($a, 'int');
        echo "$a <br/>";
        echo getType($a);

        $b = (float)$a;
        echo getType($b);


    ?>


二. 自动转换:
    整型超过最大值 --> 浮点型float;
    布尔型与NULL -->浮点型float;
    布尔型与NULL -->整型Integer;
    字符串string -->浮点型float;
    字符串string -->整型Integer;
    <?php
        $a = '10';
        $b = 3;
        $c = $a + $b;
        var_dump($c); //int(13);

        $a = 'hello world';
        $b = true;
        $c = $a + $b;
        var_dump($c); //int(1);
        
        echo true; //1
        echo false; // 空

    ?>

判断类型(返回布尔值):
    is_bool() 判断布尔型;
    is_int(),is_integer(),is_long() 判断整型;
    is_float(),is_double(),is_real() 判断浮点型;
    is_string() 字符串;
    is_array() 数组
    is_object() 对象
    is_resource() 资源类型
    is_null() null
    is_scalar() 标量
    is_numberic() 判断数字类型和数字字符串;
    is_callable() 判断是否有效函数名
函数(返回布尔值): bool settype(mixed var,string type) 将变量var的类型设置为type, 并根据是否转换成功来返回一个布尔值;

