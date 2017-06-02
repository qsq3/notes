<?php
    //面向对象: 封装,继承,多态; 
    //类: 
    class BoyFriend{
        //变量 成员属性 ,前面一定要有修饰词, var public static 等
        var $name = 'zhangsan';
        var $age = '24';

        //函数 成员方法, 修饰词可选;
        function doFan ($rou, $cai){
            return "做好饭菜了";    
        }

        function doJiawu(){
            return "做好家务";
        }
    }

    //完整语法:
    [修饰符] class 类名 [extends 父类] [implements 接口1 [,接口2 ...]] {
        //成员属性: 注意不能是带运算符的表达式,变量,方法或函数调用;而应是普通数值,常量,静态属性,数组的等;
        //常用属性修饰符 : public 公共, protected 受保护, private 私有, static 静态, var(过时,public的别名);
        [修饰符 $变量名 [= 默认值;]]
        
        //成员方法: 注意必须是和对象相关的操作; 两个方法使用到同一个变量时,把它声明为成员属性;
        //常用方法修饰符: public , protected, private, static, abstract, final;
        [[修饰符] function 方法名(参数...){
            [方法体;]
            [return 返回值;]
        }]
    } 
    
    public 公有修饰符，类中的成员将没有访问限制，所有的外部成员都可以访问（读和写）这个类成员(包括成员属性和成员方法)，在PHP5之前的所有版本中，PHP中类的成员都是public的, 而且在PHP5中如果类的成员没有指定成员访问修饰符，将被视为public 。

    private 私有修改符,被定义为private的成员，对于同一个类里的所有成员是可见的，即是没有访问限制；但对于该类的外部代码是不允许改变甚至读操作，对于该类的子类，也不能访问private修饰的成员。

    protected 保护成员修饰符,被修饰为protected的成员不能被该类的外部代码访问。但是对于该类的子类有访问权限，可以进行属性、方法的读及写操作,该子类的外部代码包括其的子类都不具有访问其属性和方法的权限。

    //特殊对象引用 $this 代表本对象的引用,只能在成员方法中使用;
    
    //对象成员方法 之 构造方法:
    1. 构造方法是对象创建完成后, 第一个 自动调用 的成员方法
    2. 方法名和类名相同(php4之前), 或者为 __construct (php5以后),同时存在时以__construct优先级为高
    3. 用来构造对象的实例属性 , 可以有参数,没有返回值;

    //对象成员方法 之 析构方法
    1. __construct , 对象释放时自动运行;
    2. 桟内存特点是后进先出, 因此最后调用的对象最先释放;
    3. 不能有参数,也没有返回值;

封装: 将一些 特殊方法 , 加上修饰词 private 私有 或 protected 受保护 ,不能在外部直接调用, 只能由对象内部的其他成员方法调用;
魔术方法: 
    __set() ; 1. 直接设置封装成员时,自动调用, 2. 把设置的封装成员属性名称(不带$符号)和值传递给该方法的参数;
    __get();  1. 直接读取封装成员时,自动调用, 2. 把访问的封装成员属性名称(不带$符号)传递给该方法的参数;
    __isset(); 对应 isset(封装成员) 调用时, 自动调用, 把访问的封装成员属性名称(不带$符号)传递给该方法的参数;
    __unset(); 对应 unset(封装成员) 调用时, 自动调用, 把访问的封装成员属性名称(不带$符号)传递给该方法的参数;

继承: 
1. extends 父类, 
2. 不能直接使用父类的 private 私有属性,可以通过父类的方法调用父类的私有属性; 
3.protected 保护属性, 只能被自己和子类使用

重载(覆盖): 子类中写和父类的同名方法;
对象->成员; 子类中调用父类成员: $this->不被覆盖的父类成员 ;  类::成员 ; parent::成员 访问父类中被覆盖的成员
重要: 只要是子类的构造方法,  去覆盖父类中的构造方法, 一定要在子类的构造方法中调用一下父类被覆盖的构造方法,成员方法同理;
权限: 子类只能大于或等于父类的权限;不能小于;
function __construct(){
    parent ::  __construct();
    $this -> school = $school;
}

关键字: 
instanceof ; 检测当前对象实例是否属于某个类; 对象 instanceof 类;

final; 修饰词,表示最终版本, 用于修饰类和方法,不能修饰属性;
     final 类 不能被继承,不能有子类; final 方法 不能被重载(覆盖);
     java中final定义常量,而PHP中,define("常量名" , "值(标量类型)") 和 const 定义常量;

static; 
    修饰词 静态; 修饰属性,方法,不能修饰类; 
    存于内存的初始化静态段; 
    可被该类的每个实例对象共用; 
    静态成员一定要使用类来访问: 类::$静态属性 ; 类::静态方法 ; self::$静态属性;self::静态方法; parent::$静态属性;parent::静态方法;
    self 可以在类中的方法中, 代表自己类 (类似 $this); 
    可以用静态环境的地方尽量使用静态环境和方法(效率)
    静态方法内不能访问非静态成员, 不能使用$this;
    在一个类的方法中如果没有出现$this 的调用, 默认为类似静态方法;

const; 
    1. 修饰词 只能修饰属性为常量;
    2. 声明时赋初始值;
    3. 常量的访问方式和静态相同,但只能读;

单态/单例设计模式
    1. 如果想让一个类只能有一个对象, 就让这个类不能创建对象, 将构造方法 private ;
    2. 可以在类的内部使用一个 静态方法来创建对象;
    <?php
    echo "1 <hr/>";
    //面向对象: 封装,继承,多态; 
    //类: 
    class Animal{

        static $obj = null;
        
        private function __construct(){
            echo "###<br>";
        }

        static function getObj (){
            if (is_null(self::$obj)){
                self::$obj =  new self;
            }
            return self::$obj;
        }
        
        function hou (){
            echo "houhouhou<br>";
        }
    }

    $a = Animal::getObj();
    $a = Animal::getObj();
    $a = Animal::getObj();
    $a = Animal::getObj();
    $a -> hou();

<?php
    echo "1 <hr/>";
    //面向对象: 封装,继承,多态; 
    //类: 
    class BoyFriend{
        //变量 成员属性
        var $name = 'li';
        var $sex = '男';
        private $age = 18;
        var $files;
            
        //函数 成员方法
        //成员方法 之 构造方法:
        //function BoyFriend($name,$age,$sex = '男'){
        function __construct($name='jan',$age='20',$sex = '男'){
            $this->name = $name;
            $this->age = $age;

            $this->files = fopen("test.html", "r");
            var_dump($this->files);
        }
        
        //魔术方法
        function __get($a){
            echo "@@@<br>";
            return $this->$a;
        }
        function __set($a, $b){
            echo "###<br>";

            if($a == 'age' && $b <18){
                echo "未成年人保护<br>";
                return;
            }
            $this->$a = $b;
        }

        function __isset($a){
            echo "这是isset({$a})时调用了__isset方法<br/>";
            if($a == 'age'){
                //echo "{$a}属性禁止判断<br/>";
                return isset($this->$a);
            }
        }
        function __unset($a){
            echo "这是unset({$a})时调用了__unset方法<br/>";
            if($a == 'age'){
                unset($this->$a);
                echo "{$a}属性删除了<br/>";
            }
        }
        //普通方法
        public function doFan (){
            echo "{$this->name}正在做饭<br>";
            $this -> doJiawu();
        }
        public function doJiawu (){
            echo "{$this->name}在做家务<br>";
        }

        //析构方法
        function __destruct(){
            
            fclose($this->files);

            echo "{$this->name}对象的内存被释放了<br>";
        }

    }

    //$bf1 = new BoyFriend;
    //$bf1 -> name = "张三";
    $bf2 = new BoyFriend("李四", 22);
    echo $bf2 -> name.'<br>';
    echo $bf2 -> sex.'<br>';
    $bf2 -> doFan();
    echo $bf2->age.'<br>';
    $bf2->age = 16;
    echo $bf2->age.'<br>';
    var_dump( isset($bf2->age));
    echo "<br>";
    unset($bf2->age);
    var_dump( isset($bf2->age));
    echo "<br>";

    class LaoGong extends BoyFriend{
        var $hukou;
        var $child;

        function __construct ($child) {
            $this->child = $child;
            echo "孩子是$this->child<br>";
        }
    }
    $laogong = new LaoGong("小明");
    echo $laogong->name.'<br>';
 
魔术方法:
    1. 自动调用,但不同的魔术方法有自己的调用时机;
    2. 都是以"__"开头;
    3. 方法名固定;
    4. 如果不写, 就不存在, 也没有默认功能;
    5. 常见语言中, 只有PHP有魔术方法;

对象串行化(序列化),用途: 长时间保存时, 传输时;:
    1. 把对象转换为字符串, 就叫串行化, 串行化会保存对象的属性和类名,但不会保存方法;
        __sleep(); 串行化时自动调用;
        作用: 可以设置需要串行化对象的属性;
        只要在这个方法中, 返回一个数组,在数组中声明的属性名就会被串行化,不在数组中声明的属性名就不会被串行化, 默认为全部串行化;
    
    2. 反之,串行化的字符串转为对象,为反串行化;
        __wakeup();
        作用: 对反串行化的对象初始化, 和 __construct() 和 __clone() 作用类似;
     
    3. PHP数组串行化(JSON格式)
    json_encode — 对变量进行 JSON 编码  string json_encode  ( mixed  $value  [, int $options  = 0  ] )

    json_decode — 对 JSON 格式的字符串进行编码  mixed  json_decode  ( string $json  [, bool $assoc  = false  [, int $depth  = 512  [, int $options  = 0  ]]] )
    This function only works with UTF-8 encoded data. 
    assoc 当该参数为 TRUE  时，将返回 array  而非 object  。 

    __construct();
    __destruct();
    __set();
    __get();
    __isset();
    __unset();

    __toString(); 
    1. 输出对象引用时自动调用: echo , print , printf;
    2. 将对象的基本信息放在方法内部, 形成字符串返回;
    3. 在这个方法中不能有参数, 而且必须返回字符串;

    __clone(); 克隆;
    1. 克隆对象 $c = clone $b;
    2. 是在克隆对象时自动调用;
    3. 作用: 克隆对象时,对新对象进行初始化;

    __call();对象调用不存在的方法时触发,不支持类的静态方法;
    1. 错误调用时触发;
    2. 两个参数: 被调用的不存在的方法名, 被调用的不存在方法的参数;
    3. 用途: 可以把多个功能相似的方法合成一个去写;
    
    __callStatic(); 类调用调用不存在的方法时触发,支持类的静态方法;必须声明为静态;

    __sleep(); 串行化时自动调用;
    __wakeup(); 反串行化时自动调用;
    
    __set_state(); 在使用 var_export()输出对象时自动调用,var_export()输出的内容已该魔术方法的返回值为准; 
    static function __set_state( $arr ){}; //$arr的值为这个对象的属性值;
    mixed  eval  ( string $code  )把字符串 code 作为PHP代码执行。 
    void  var_dump  ( mixed  $expression  [, mixed  $...  ] )此函数显示关于一个或多个表达式的结构信息，包括表达式的类型与值。数组将递归展开值，通过缩进显示其结构
    mixed  var_export  ( mixed  $expression  [, bool $return  ] ) 返回关于传递给该函数的变量的结构信息，它和 var_dump()  类似，不同的是其返回的表示是合法的 PHP 代码。

    eg:    $p = new Persong(); eval( '$obj ='.var_export($p,true).';' ); var_dump($obj);

    __invoke(); 创建完实例对象后,可以直接调用对象(作为函数运行);

    __autoload(); 只要在脚本中,需要加载类的时候(必须),就会自动调用这个方法; 
    function __autoload($classname){
        include strtolower($classname).".class.php";
    };
    
<?php
    class Person{
        var $name;
        var $sex;
        var $age;
        public $marr = ["a","b","c"];
        
        function __construct($name,$sex,$age){
            $this->name = $name;
            $this->sex = $sex;
            $this->age = $age;
        }
        public function say(){
            echo "{$this->name}的年龄是{$this->age}<br>";
        }
        function __toString(){
            return "aaaa<br>";
        }

        function __clone(){
            $this->name = "克隆的{$this->name}";//$that->name;
            echo "正在克隆<br>";
        }

        function __call($method, $args){
            echo "所调用的方法{$method}(),参数为";
            print_r($args);
            echo "不存在,此时触发__call()方法<br>";
            if(in_array($method,$this->marr)){
                echo $args[0]."<br>";
            }else{
                echo "备用方法不存在<br>";
            }
        }

        function __sleep(){
            echo "串行化时自动调用__slepp()<br>";
            return array("name","age");
        }

        function __wakeup(){
            echo "反串行化时自动调用__wakeup()<br>";
            return array("name","age");
        }

    }
    /**
    $b = new Person("小米","女","22");
    $b->say();
    $c = clone $b;
    $c->say();
    $c->you(123123);
    $c->a("aaaaaaaaaaa"); */

<?php
    //read
    include "test.php";

    //从文件中读取
    $str = file_get_contents("baocun.txt");

    //反串行化
    $p = unserialize($str);

    $p->say();

<?php
    //save
    include "test.php";
    $p = new Person("王二","女","11");
    $p->say();

    $str = serialize($p); //串行化

    file_put_contents("baocun.txt",$str); //保存在文件中
    echo "对象转换字符串,并保存成功";

抽象方法:
    1. 没有方法体: 没有{},直接;结束;
    2. abstract 抽象修饰词修饰;
    作用:  只写出结构, 具体实现交给子类; 规定了子类必须要有这些抽象方法的实现;功能交给子类;
    

抽象类: 
    1. 有抽象方法的类, 则必须为抽象类;
    2. abstract 抽象修饰词修饰抽象类 ;
    作用: 作为一个规范, 要求子类的结构;
注意: 
    1. 抽象类中可以没有抽象方法;  
    2. 抽象类除了可以有抽象方法之外, 和正常类一样;
    3. 抽象类不能实例化对象;
    4. 抽象类必须有子类,来将抽象方法覆盖;
    5. 子类必须全部覆盖抽象方法,才能创建子类的实例对象;

接口:  接口是一种特殊的抽象类;
    1. 接口的成员方法, 必须全是抽象方法, 因此不需使用 abstract 修饰方法;
    2. 接口的成员属性, 必须是常量;
    3. 接口的所有成员方法, 权限必须是 public ;
    4. 声明接口类, 不使用 class , 而是使用 interface ;
    应用细节:
    1. 可以使用 extends 让接口继承接口, 用于扩展新的抽象方法, 而不是覆盖;
    2. 可以使用一个类来实现接口中的全部方法, 也可使用一个抽象类来实现部分方法, 这时为覆盖, 使用 implements 来实现继承(相当于extends);
    3. 因为 extends 继承 在PHP 中一个类 只能继承一个父类; 所以用 implements;
    4. 一个类在继承另一个类的同时, 可以使用 implements 实现接口(可以多个,使用逗号, 分开多个接口), 一定要先继承,再接口;
    
eg: abstract class Person{
    abstract function say () ;
}
    interface Demo{
        const AAA = "aaa";
        function test();
    }
    interface Demm extends Demo{
        function tess();
    }
    interface Dema extends Demo{
        function tesa();
    }
    abstract class Son extends Person implements Demm,Dema{
    
    }

多态:
    1. 程序扩展准备
    技术:
    1. 必须有继承关系, 父类最后是接口或抽象类;
    2. 数组, 类和接口中的方法, 可以在参数中用类名限制

    <?php
    interface USB{
        const WIDTH = 12;
        const HEIGHT = 3;

        function load();
        function run();
        function stop();
    }

    class Computer{
        function useUSB(USB $usb){
            $usb -> load();
            $usb -> run();
            $usb -> stop();
        }
    }
    
    class Mouse implements USB{
        function load(){ echo "加载鼠标<br>";}
        function run(){ echo "运行鼠标<br>";}
        function stop(){ echo "卸载鼠标<br>";}  
    }
    class Keyboard implements USB{
        function load(){ echo "加载键盘<br>";}
        function run(){ echo "运行键盘<br>";}
        function stop(){ echo "卸载键盘<br>";}  
    }

    class Worker{
        function user(){
            $c = new Computer();
            $m = new Mouse;
            $k = new Keyboard;
            $c -> useUSB($m);
            $c -> useUSB($k);
        }
    }

    $w = new Worker;
    $w -> user();

    PHP5.3新增:
魔术常量: 
__LINE__   文件中的当前行号。  
__FILE__   文件的完整路径和文件名。如果用在被包含文件中，则返回被包含的文件名。自 PHP 4.0.2 起， __FILE__  总是包含一个绝对路径（如果是符号连接，则是解析后的绝对路径），而在此之前的版本有时会包含一个相对路径。  
__DIR__   文件所在的目录。如果用在被包括文件中，则返回被包括的文件所在的目录。它等价于 dirname(__FILE__)。除非是根目录，否则目录中名不包括末尾的斜杠。（PHP 5.3.0中新增） =  
__FUNCTION__   函数名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该函数被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。  
__CLASS__   类的名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该类被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。类名包括其被声明的作用区域（例如 Foo\Bar）。注意自 PHP 5.4 起 __CLASS__ 对 trait 也起作用。当用在 trait 方法中时，__CLASS__ 是调用 trait 方法的类的名字。  
__TRAIT__   Trait 的名字（PHP 5.4.0 新加）。自 PHP 5.4 起此常量返回 trait 被定义时的名字（区分大小写）。Trait 名包括其被声明的作用区域（例如 Foo\Bar）。  
__METHOD__   类的方法名（PHP 5.0.0 新加）。返回该方法被定义时的名字（区分大小写）。  
__NAMESPACE__   当前命名空间的名称（区分大小写）。此常量是在编译时定义的（PHP 5.3.0 新增）。  

类/对象 函数 
1.__autoload — 尝试加载未定义的类
2.call_user_method_array — 调用一个用户方法，同时传递参数数组（已废弃）
3.call_user_method — 对特定对象调用用户方法（已废弃）
4.class_alias — 为一个类创建别名
5.class_exists — 检查类是否已定义
6.get_called_class — 后期静态绑定（"Late Static Binding"）类的名称
7.get_class_methods — 返回由类的方法名组成的数组
8.get_class_vars — 返回由类的默认属性组成的数组
9.get_class — 返回对象的类名
10.get_declared_classes — 返回由已定义类的名字所组成的数组
11.get_declared_interfaces — 返回一个数组包含所有已声明的接口
12.get_declared_traits — 返回所有已定义的 traits 的数组
13.get_object_vars — 返回由对象属性组成的关联数组
14.get_parent_class — 返回对象或类的父类名
15.interface_exists — 检查接口是否已被定义
16.is_a — 如果对象属于该类或该类是此对象的父类则返回 TRUE
17.is_subclass_of — 如果此对象是该类的子类，则返回 TRUE
18.method_exists — 检查类的方法是否存在
19.property_exists — 检查对象或类是否具有该属性
20.trait_exists — 检查指定的 trait 是否存在

<?php
    class Demo {
        public $c = 1;
        function go (){ 
            echo __CLASS__.'<br>';  
            echo __METHOD__.'<br>'; 
            //array_filter($arr, array(__CLASS__,"hello"));
        }
        function hello (){
        }
    }
    
    Demo::go(); //Demo ; Demo::go
    
    $a = new Demo; 
    $b = new Demo;
    $a->go(); //Demo ; Demo::go
    
    $a->c = 2;
    $b->c = 2;
    var_dump($a == $b);  //true
    var_dump($a instanceof $b); //true


PHP5.3新增:
命名空间: 
1. 常量 2. 函数 3. 类 , 接口
命名空间通过关键字namespace 来声明。
如果一个文件中包含命名空间，它必须在其它所有代码之前声明命名空间，除了一个以外：declare关键字(已废弃)。
另外，所有非 PHP 代码包括空白符都不能出现在命名空间的声明之前.
同一个文件中,同时连续定义多个命名空间时,以最后的为准(毫无意义);
同一个文件中,定义多个命名空间时,建议用大括号; 括号外部不能有PHP代码;
全局代码需要不带名称的 namespace 加上{};

命名空间名称定义 
非限定名称Unqualified name
名称中不包含命名空间分隔符的标识符，例如 Foo 
限定名称Qualified name
名称中含有命名空间分隔符的标识符，例如 Foo\Bar 
完全限定名称Fully qualified name
名称中包含命名空间分隔符，并以命名空间分隔符开始的标识符，例如 \Foo\Bar。 namespace\Foo 也是一个完全限定名称。 

使用完全限定名称（包括命名空间前缀的类名称）。注意因为在动态的类名称、函数名称或常量名称中，限定名称和完全限定名称没有区别，因此其前导的反斜杠是不必要的。
    
PHP支持两种抽象的访问当前命名空间内部元素的方法， __NAMESPACE__  魔术常量和namespace关键字。 
常量 __NAMESPACE__ 的值是包含当前命名空间名称的字符串。在全局的，不包括在任何命名空间中的代码，它包含一个空的字符串。 
关键字 namespace 可用来显式访问当前命名空间或子命名空间中的元素。它等价于类中的 self 操作符。 
使用命名空间：别名/导入 允许通过别名引用或导入外部的完全限定名称，是命名空间的一个重要特征。这有点类似于在类 unix 文件系统中可以创建对其它的文件或目录的符号连接。 
所有支持命名空间的PHP版本支持三种别名或导入方式：为类名称使用别名、为接口使用别名或为命名空间名称使用别名。PHP 5.6开始允许导入函数或常量或者为它们设置别名。 
对于函数和常量来说，如果当前命名空间中不存在该函数或常量，PHP 会退而使用全局空间中的函数或常量。



<?php
    declare(encoding="utf-8"); //已废弃;

    namespace myself\son{
        function var_dump($a){
            echo $a.'<br>';
        }
        class Demo{
            static function test(){
                echo "testson1<br>";
            }
        }
    
    define(AAA, "999"); //错误,命名空间的常量应用 const声明;
    //const AAA = 666; //定义此命名空间的常量; 
    
    }

    namespace myself\son2{
        function var_dump($a){
            echo $a.'+2<br>';
        }
        class Demo{
            static function test(){
                echo "testson2<br>";
            }
        }
        const AAA = 999; //定义此命名空间的常量;  


        var_dump(333); //333
        \myself\son\var_dump(333); //333 ,根目录访问myself里面的var_dump();
        \var_dump(333); //int(333);根目录也就是原生的var_dump();
        echo '<br>';

        echo AAA.'<br>';
        echo \myself\son2\AAA.'<br>';
        
        Demo::test();
        \myself\son\Demo::test();

        $p = 'var_dump';
        $fun= __NAMESPACE__.'\\'.$p;
        $fun(222);
        namespace\var_dump(222);

    }

    namespace{
    
        echo \myself\son2\AAA.'<br>';
    }

    namespace com\baidu\www{
        use com\baidu\www as baidu2;
        use com\baidu\www ;

        function test (){
            echo 'baidu_test<br>';
        }
        class Hello{
            static function one(){
                echo '1111111111111<br>';
            }
        }
        baidu2\test();
        www\test();

        www\Hello::one();

        // use \Hello; 导入一个全局类
    
    }