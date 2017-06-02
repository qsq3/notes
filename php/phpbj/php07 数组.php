<?php
数组按下标个数分类有一维数组,二维数组等多维数组;数组是一个容器,使用的目的是可以批量操作;
    php 中数字组实际上是一个有序图,
    一个数组存多个内容,
    数组中的内容叫做"元素",每个元素都是由 健 和 值 组成的 key/value , 
    在数组中, 我们通过 key - 下标 来使用值;
    通过 print_r($arr) 来打印数组;

    
数组分类: 
    php中有两种数组: 索引数组和关联数组
    1. 索引(indexed)数组的索引值是"整数",以0开始, 通过位置来标识东西时用索引数组.
        $arr[0] = '1';
    2. 关联(associative)数组以"字符串"作为索引值, 关联数组更像操作表. 索引值为列名,用于访问列的数据;
        $arr['one'] = '1';
    3. 键值 value 可以是任意类型;

    若多个元素使用同一个键名,则只使用最后一个,之前的都被覆盖.
    如果对给出的键值没有指定键名,则去当前最大的整数索引值,而新键名则是该值加一,
    如果对给出的键名已存在, 则覆盖之前的键值;
    使用[]来操作下标,也可使用{}进行互换,但不建议;$arr{'one'} = '1';
    在字符串中 $arr['one']的中括号不会被解析为间隔符号;
    不建议下标使用常量 ,例如: $arr[one]
    数组自动增长索引下标, 默认从0开始, 自动增长都是出现过的最大值加1;
    关联下标不会影响索引下标的排列规则;
    索引下标支持负数;
    使用 => 指定下标;

    //循环赋值数组
    $arr = array();
    for($i=0; $i<100; $i++){
        $arr[] = $i*$i; //不写下标默认递增
    }
    echo '<pre>';
    print_r($arr);
    echo '</pre>';

此外 key 会有如下强制转换:
    1. 合法整型值的字符串 会被转换为 整型. 比如"8"会被存储为8; 但"08"不会(因为8进制) 
    2. 浮点型 会被转换为 整型, 小数部分会被舍去
    3. 布尔值 会被转换为 整型, true 转 1 , false 转 0;
    4. null 会被转换为空字符串:"";
    5. 数组和对象不能作为键名,会导致警告; lllegal offset type;



声明方式:
    1. 直接赋值; 
        $arr[] = $i
    2. 使用 array() , 默认是索引下标,从0开始; 
        $e = array('name'=>'zhang', 'age'=>"20");
    3. php5.4新增方式 [] 
       $arr = [1,2,3=>3,4];
    4. 多维数组
    
eg:
<?php
    $a = array(1,2,3);
    $b = array('one','two','three'); //默认索引数组,下标从0开始
    $c = array(0=>'aaa', 1=>'bbb', 2=>'ccc');
    $d = array('aaa', 6=>'bbb', 'ccc');
    $e = array('name'=>'zhang', 'age'=>"20");

<?php
    function demo () {
        return array('one','two','three');
    }
    $arr = demo();
    //print_r ($arr);
    echo demo()[1];// php5.4新增方式 ,直接使用函数返回的数组,而不需要临时变量;

    if(function_exists("array")){
        echo "存在"; //true
    }else {
        echo "不存在";
    }

unset() 函数允许删除数组中的某个键.但要注意数组不会重建索引,如果需要删除后重建索引,可以用 array_values() 函数;
    $arr = [1,2,3];
    unset($arr[2]);
    // $arr[2] = null; //不相同效果;
    $arr = array_values($arr);

eg:
<?php
function chooseking($sum, $n){
    $arr = array();
    $a = 0;
    for($i=0; $i<$sum; $i++){
        $arr[] = $a++;
    }
    
    $i = 0;
    while (count($arr)>1){
        if($i < $n || $i%$n != 0){
            $arr[] = $arr[$i];
        }
        unset($arr[$i]);

        $i++;
    }
    return $arr;
}
$king =  chooseking(30, 3);
print_r($king);

二维数组的声明和应用
    $group = array(
        array('name'=>'zs','age'=>20,'email'=>'zs@aa.com'),
        array('name'=>'ls','age'=>21,'email'=>'ls@aa.com'),
        array('name'=>'ww','age'=>23,'email'=>'ww@aa.com')
    );

    var_dump($group[1]['email']);

    $group[][] = '11'; //$group[3][0]
    $group[][] = '22'; //$group[4][0]
    $group[][] = '33'; //$group[5][0]
    
    echo '<pre>';
    print_r($group);
    echo '</pre>';

数组的遍历:
count(数组) 获取数组长度,是数组实际元素的个数;
不足: 下标不一定是连续的, 不能访问关联数组下标

//注意: foreach执行时,操作的是数组的一个拷贝,而不是数组本身;

$arr = array(1,2,3,4,9=>6,'aa'=>7,8,9);

    for($i=0;$i<count($arr);$i++){ 
        echo $arr[$i]."<br/>";
    }

    foreach($arr as $value){
        echo $value."<br/>"; //循环把数组中的值赋给自定义变量;
    }

    foreach($arr as $key => $value){
        echo $key."=>".$value."<br/>"; //循环把数组中的键和值赋给自定义变量;
    }
eg:    
    $group = [
        'groupName' => 'groupOne',
        ['name'=>'zs','age'=>20,'email'=>'zs@aa.com'],
        ['name'=>'ls','age'=>21,'email'=>'ls@aa.com'],
        ['name'=>'ww','age'=>23,'email'=>'ww@aa.com'],
        ['name'=>'wa','age'=>23,'email'=>'ww@aa.com'],
        ['name'=>'wb','age'=>23,'email'=>'ww@aa.com'],
        ['name'=>'wc','age'=>23,'email'=>'ww@aa.com'],
        ['name'=>'wd','age'=>23,'email'=>'ww@aa.com']
    ];

    echo '<table border="1" width="800" align="center">';
    echo '<caption><h1>数组转为表格</h1></caption>';
    foreach($group as $key => $row){
        echo '<tr align="center">';
            if(is_array($row)){
                foreach( $row as $key => $value){
                    echo "<td bgcolor='#eee'>{$key}</td><td>{$value}</td>";
                }
            } else {
                echo "<td bgcolor='#eee' colspan='3'>{$key}</td><td colspan='3'>{$row}</td>";
            }
        echo '</tr>';
    }
    echo '</table>';
    
list(),each() 和 while(){} ; 用于数据库表;

void list( mixed... ) 
   list并不是真正的函数,只是语言结构,与其他函数用法不同,作用: 将数组中的元素转为变量使用;

1. 等号左边使用 list() 函数, 等号右边只能是一个数组;
2. list()的参数是用来接收数组的值的, 必须是变量(新声明的自定义变量),不能是值;
3. 只能将下标连续的索引数组, 转为变量;
4. 可以在 list() 参数中, 通过空项 ,选择性接收数组中的元素; 

array each(array array) 
    each 返回 array 数组中当前指针位置的键/值对,并向前移动数组指针;
    键值对被返回为四个单元的数组, 键名为 0, 1, key 和 value ;
    单元 0 和 key 包含有数组单元的键名, 1 和 value 包含有键值;
    如果内部指针越过了数组的末端, 则 each() 返回 false.
    each() 经常和 list() 结合来遍历数组;
    在执行 each() 之后, 数组指针将停留在数组的下一个单元, 
    或者当碰到数组结尾时停留在最后一个单元. 
    如果要再使用 each()遍历数组, 必须使用reset().

eg1:
    $arr = array(1,2,3,'sz');
    list($a,,$b) = $arr;
    list($e,$f,$g,$h) = array(1,2,3,'sz');
    echo $a,$b,$h;

eg2:
    $str = '大家_新年好';
    list($name,$pro) = explode("_",$str);
    echo $name, $pro;

eg3:
    $arr = array(1,2,3,'sz');
    $one = each($arr);
    $two = each($arr);
    echo '<pre>';
    print_r($one);
    print_r($two);
    echo '</pre>';

eg4:
    //while($tmp = each($arr)){
       // echo "$tmp[0]=>$tmp[1]<br/>";
       // echo "{$tmp['key']}=>{$tmp['value']}<br/>";
    //}

    while(list($key,$value) = each($arr)){
       echo "$key=>$value<br/>";
    }

    reset($arr);

内部指针: 控制数组内部指针位置来获取数据;
相关函数:    mixed next ($arr) ;  指针向后移动一位,返回数组内部指针指向的下一个单元的值，或当没有更多单元时返回 FALSE 。 
            mixed prev ($arr) ;  将数组的内部指针倒回一位。 返回数组内部指针指向的前一个单元的值，或当没有更多单元时返回 FALSE 。 
            mixed end ($arr) ;   将内部指针移动到最后一个单元并返回其值。 如果数组为空则返回 FALSE 。 
            mixed reset ($arr) ; 将内部指针倒回到第一个单元并返回第一个数组单元的值，如果数组为空则返回 FALSE 。 
            mixed key ($arr) ;   输出当前指针的 key ,如果内部指针超过了元素列表尾部，或者数组是空的，会返回 NULL 。 
            mixed current($arr); 输出当前指针的 value;如果内部指针超过了元素列表尾部，或者数组是空的， 会返回 FALSE  
            。 
    这些函数可能返回布尔值 FALSE ，但也可能返回等同于 FALSE  的非布尔值。请阅读 布尔类型章节以获取更多信息。应使用 === 运算符来测试此函数的返回值。

    echo "$arr当前指针的元素为: ".key($arr) ."=>".current($arr);

    
//超全局数组:  默认为 关联数组;
    $_GET       
        通过GET方法  URL 参数传递给当前脚本的变量的数组。 
        $HTTP_GET_VARS  包含相同的信息， 但它不是一个超全局变量。

    $_POST
        通过 HTTP POST 方法传递给当前脚本的变量的数组。 
        $HTTP_POST_VARS  包含相同的信息，但它不是一个超全局变量。

    $_REQUEST
         HTTP Request 变量,默认情况下包含了 $_GET ， $_POST 和 $_COOKIE 的数组 。 

    $_SERVER    
        服务器和执行环境信息,包含了诸如头信息(header)、路径(path)、以及脚本位置(script locations)等等信息的数组。
        $HTTP_SERVER_VARS [已弃用]  包含着相同的信息，但它不是一个超全局变量

    $_ENV
        环境变量 - 通过环境方式传递给当前脚本的变量的 数组 。 
        $_ENV -- $HTTP_ENV_VARS [已弃用] 包含相同的信息，但它不是一个超全局变量。


    $_FILES     
        通过 HTTP POST 方式上传到当前脚本的项目的 数组 。 
        $HTTP_POST_FILES  包含相同的信息，但它不是一个超全局变量。

    $_COOKIE
        通过 HTTP Cookies 方式传递给当前脚本的变量的 数组 
        $HTTP_COOKIE_VARS  包含相同的信息，但它不是一个超全局变量。

    $_SESSION
        当前脚本可用 SESSION 变量的数组。参见 Session 函数 文档。 
        $HTTP_SESSION_VARS  包含相同的信息，但它不是一个超全局变量。

    $GLOBALS    
        一个包含了全部变量的全局组合 数组 。变量的名字就是数组的键。
        与所有其他超全局变量不同， $GLOBALS 在PHP中总是可用的。 
        php.ini中 register_globals = Off 关闭,

eg: GET, POST传递数组;

<?php
    echo "1 <br/>";
    $arr = (!empty($_GET)) ? $_GET : $_POST;
    if(!empty($arr)){
        print_r($arr);
    }
?>    
<hr />
<a href="test.php?action[]=add&action[]=play&id=0&name=admin" >HTTP GET方法</a>
<form action="test.php" method="post">
    username1 : <input type="text" name="name[]" /><br/>
    username2 : <input type="text" name="name[]" /><br/>
    username3 : <input type="text" name="name[]" /><br/>
    age :<input type="text" name="age" /><br/>
    <input type="submit" value='提交' name='submit'/>
</form>

<?php
PHP数组处理函数分类:
1. 键/值操作
    array array_values  ( array $input  ) 
        返回 input 数组中所有的值并给其建立数字索引。
        
    array array_keys  ( array $array  [, mixed  $search_value  [, bool $strict  = false  ]] )
        返回 input 数组中的数字或者字符串的键名。 
        如果指定了可选参数 search_value，则只返回该值的键名。否则 input 数组中的所有键名都会被返回。
        
    bool in_array  ( mixed  $needle  , array $haystack  [, bool $strict  = FALSE    ] )
        haystack 中搜索 needle，如果没有设置 strict 则使用宽松的比较。
        如果 needle 是字符串，则比较是区分大小写的。
        如果第三个参数 strict 的值为 TRUE  则 in_array()  函数还会检查 needle 的类型是否和 haystack 中的相同。 

    mixed  array_search  ( mixed  $needle  , array $haystack  [, bool $strict  = false  ] )
        在数组中搜索给定的值，如果成功则返回相应的键名 
        如果找到了 needle 则返回它的键，否则返回 FALSE 。 
        如果 needle 在 haystack 中出现不止一次，则返回第一个匹配的键。要返回所有匹配值的键，应该用 array_keys()  加上可选参数 search_value 来代替

    bool array_key_exists  ( mixed  $key  , array $search  )
        在给定的 key 存在于数组中时返回 TRUE 。key 可以是任何能作为数组索引的值。 也可用于对象。
        array_key_exists()  与 isset()  的对比 
            isset()  对于数组中为 NULL  的值不会返回 TRUE ，而 array_key_exists()  会。 
            <?php
            $search_array  = array( 'first'  =>  null ,  'second'  =>  4 );
             // returns false
             isset( $search_array [ 'first' ]);
             // returns true
             array_key_exists ( 'first' ,  $search_array );

    array array_flip  ( array $trans  )
        返回一个反转后的 array ，例如 trans 中的键名变成了值，而 trans 中的值成了键名。 
        注意 trans 中的值需要能够作为合法的键名，例如需要是 integer  或者 string 。如果值的类型不对将发出一个警告，并且有问题的键／值对将不会反转。 
        如果同一个值出现了多次，则最后一个键名将作为它的值，所有其它的都丢失了。 
    
    array array_reverse  ( array $array  [, bool $preserve_keys  = false  ] )
        接受数组 array 作为输入并返回一个单元为相反顺序的新数组。 
        preserve_keys 如果设置为 TRUE  会保留数字的键。 非数字的键则不受这个设置的影响，总是会被保留。 


2. 统计个数与唯一性
    int count  ( mixed  $var  [, int $mode  = COUNT_NORMAL  ] )
    //strlen() 字符串;

        统计一个数组里的所有元素，或者一个对象里的东西。 对于对象，如果安装了 SPL，可以通过实现 Countable 接口来调用 count() 。该接口只有一个方法 Countable::count() ，此方法返回 count()  函数的返回值。 
        eg:
        $arr = array("a"=>"aaa",'b'=>array(1,2,3),1=>"ccc");
        print(count($arr));//3
        echo "<br/>";
        print(count($arr,1));//6

    array array_count_values  ( array $input  )
        返回一个数组，该数组用 input 数组中的值作为键名，该值在 input 数组中出现的次数作为值。
    
    array array_unique  ( array $array  [, int $sort_flags  = SORT_STRING  ] )
        接受 array 作为输入并返回没有重复值的新数组。 
        注意键名保留不变。 array_unique()  先将值作为字符串排序，然后对每个值只保留第一个遇到的键名，接着忽略所有后面的键名。这并不意味着在未排序的 array 中同一个值的第一个出现的键名会被保留。 
        Note: 当且仅当 (string) $elem1 === (string) $elem2 时两个单元被认为相同。就是说，当字符串的表达一样时。   第一个单元将被保留。 


3. 使用回调函数处理数组
    array array_filter  ( array $input  [, callable  $callback  = ""  ] )
        依次将 input 数组中的每个值传递到 callback 函数。如果 callback 函数返回 TRUE ，则 input 数组的当前值会被包含在返回的结果数组中。数组的键名保留不变。 

    bool array_walk  ( array &$array  , callable  $funcname  [, mixed  $userdata  = NULL    ] )
        将用户自定义函数 funcname 应用到 array 数组中的每个单元。 
        array_walk()  不会受到 array 内部数组指针的影响。 array_walk()  会遍历整个数组而不管指针的位置。 
        eg:
        <?php
        $fruits  = array( "d"  =>  "lemon" ,  "a"  =>  "orange" ,  "b"  =>  "banana" ,  "c"  =>  "apple" );

        function  test_alter (& $item1 ,  $key ,  $prefix )
        {
             $item1  =  " $prefix :  $item1 " ;
        }

        function  test_print ( $item2 ,  $key )
        {
            echo  " $key .  $item2 <br />\n" ;
        }

        echo  "Before ...:\n" ;
         array_walk ( $fruits ,  'test_print' );

         array_walk ( $fruits ,  'test_alter' ,  'fruit' );
        echo  "... and after:\n" ;

         array_walk ( $fruits ,  'test_print' );
         

    array array_map  ( callable  $callback  , array $arr1  [, array $...  ] )
        array_map()  返回一个数组，该数组包含了 arr1 中的所有单元经过 callback 作用过之后的单元。callback 接受的参数数目应该和传递给 array_map()  函数的数组数目一致。


4. 排序
    1. 冒泡排序:
    2. 二分排序:
            $arr = array(20,15,22,1,66,23,65,33,28,12);
            function qsort ($arr) {
                if(!is_array($arr) || empty($arr))
                    return array();
                $len = count($arr);
                if($len <= 1)
                    return $arr;
                $key = $arr[0];
                
                $left = array();
                $right = array();
                
                for($i = 1; $i < $len; $i++){
                    if($arr[$i] <= $key){
                        $left[] = $arr[$i];
                    } else {
                        $right[] = $arr[$i];
                    }
                }
                $left = qsort($left);
                $right = qsort($right);
                return array_merge($left,array($key),$right);
            }
            print_r($arr);
            echo '<br>';
            print_r(qsort ($arr));
        
        3. 排序函数:
            sort -- 升序排序;
            rsort -- 降序排序;
            ksort -- 按键名排序;
            krsort -- 按键名降序排序
            asort -- 排序并保持索引关系(关联数组)
            arsort -- 降序排序并保持索引关系(关联数组)
            natsort -- 自然排序
            natcasesort -- 自然排序 不区分大小写
            usort -- 用自定义函数排序
            uasort -- 自定义函数排序 并 保持索引关系
            uksort -- 使用用户自定义的比较函数对数组键名进行排序
            array_multisort -- 对多个数组或多维数组排序;
            
 eg:        <?php
                $arr = array(
                    array('id'=>1,'name'=>'zhangsan',age=>18),
                    array('id'=>2,'name'=>'lisi',age=>22),
                    array('id'=>3,'name'=>'wangwu',age=>22),
                    array('id'=>4,'name'=>'zhaoliu',age=>16),
                    array('id'=>5,'name'=>'chenqi',age=>31),
                );
                
                $name = array();
                $age = array();
                foreach( $arr as $value){
                    $name[] = $value['name'];
                    $age[] = $value['age'];
                }
                
                echo '<pre>';
                print_r($arr);
                echo '<br>';
                print_r($name);
                echo '<br>';
                print_r($age);
                echo "<hr/>";
                array_multisort($age, SORT_ASC ,$name,SORT_DESC,$arr);
                print_r($arr);
                echo '</pre>';
        

5. 拆分.合并.分解.结合
array array_slice  ( array $array  , int $offset  [, int $length  = NULL    [, bool $preserve_keys  = false  ]] )
        array_slice()  返回根据 offset 和 length 参数所指定的 array 数组中的一段序列。 
    参数:
    array 
    输入的数组。 
    offset 
    如果 offset 非负，则序列将从 array 中的此偏移量开始。如果 offset 为负，则序列将从 array 中距离末端这么远的地方开始。 
    length 
    如果给出了 length 并且为正，则序列中将具有这么多的单元。如果给出了 length 并且为负，则序列将终止在距离数组末端这么远的地方。如果省略，则序列将从 offset 开始一直到 array 的末端。 
    preserve_keys 
    注意 array_slice()  默认会重新排序并重置数组的数字索引。你可以通过将 preserve_keys 设为 TRUE  来改变此行为。 5.0.2 增加了可选参数 preserve_keys 。 

    2. 
array array_splice  ( array &$input  , int $offset  [, int $length  = 0  [, mixed  $replacement  ]] )
    把 input 数组中由 offset 和 length 指定的单元去掉，如果提供了 replacement 参数，则用其中的单元取代。 返回一个包含有被移除单元的数组。 
    注意 input 中的数字键名不被保留。 
    Note:  If replacement is not an array, it will be typecast to one (i.e. (array) $parameter). This may result in unexpected behavior when using an object or NULL  replacement.  
    参数
    input 
    输入的数组。 
    offset 
    如果 offset 为正，则从 input 数组中该值指定的偏移量开始移除。如果 offset 为负，则从 input 末尾倒数该值指定的偏移量开始移除。 
    length 
    如果省略 length，则移除数组中从 offset 到结尾的所有部分。如果指定了 length 并且为正值，则移除这么多单元。如果指定了 length 并且为负值，则移除从 offset 到数组末尾倒数 length 为止中间所有的单元。小窍门：当给出了 replacement 时要移除从 offset 到数组末尾所有单元时，用 count($input) 作为 length。 
    replacement 
    如果给出了 replacement 数组，则被移除的单元被此数组中的单元替代。 
    如果 offset 和 length 的组合结果是不会移除任何值，则 replacement 数组中的单元将被插入到 offset 指定的位置。 注意替换数组中的键名不保留。 
    如果用来替换 replacement 只有一个单元，那么不需要给它加上 array()，除非该单元本身就是一个数组、一个对象或者 NULL 。 

array array_combine  ( array $keys  , array $values  )
    返回一个 array ，用来自 keys 数组的值作为键名，来自 values 数组的值作为相应的值。 
 
合并:
直接相加    
eg: $a=['a','b','c'];
    $b=['ba' =>1, 'bb'=>2,'bc'=>3];
    $c=$a+$b; //下标相同会覆盖.前面覆盖后面的;
    var_dump($c);

array array_merge  ( array $array1  [, array $...  ] )
    array_merge()  将一个或多个数组的单元合并起来，一个数组中的值附加在前一个数组的后面。返回作为结果的数组。 
    如果输入的数组中有相同的字符串键名，则该键名后面的值将覆盖前一个值。然而，如果数组包含数字键名，后面的值将不会覆盖原来的值，而是附加到后面。 
    如果只给了一个数组并且该数组是数字索引的，则键名会以连续方式重新索引。
    
array array_merge_recursive  ( array $array1  [, array $...  ] )
    array_merge_recursive()  将一个或多个数组的单元合并起来，一个数组中的值附加在前一个数组的后面。返回作为结果的数组。 
    如果输入的数组中有相同的字符串键名，则这些值会被合并到一个数组中去，这将递归下去，因此如果一个值本身是一个数组，本函数将按照相应的条目把它合并为另一个数组。然而，如果数组具有相同的数组键名，后一个值将不会覆盖原来的值，而是附加到后面。 

交集:
array array_intersect  ( array $array1  , array $array2  [, array $ ...  ] )
    array_intersect()  返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。注意键名保留不变。

    array_intersect_assoc() - 带索引检查计算数组的交集 
    array_intersect_uassoc() - 带索引检查计算数组的交集，用回调函数比较索引 
    array_intersect_key() - 使用键名比较计算数组的交集 
    array_uintersect() - 计算数组的交集，用回调函数比较数据 
    array_uintersect_assoc() - 带索引检查计算数组的交集，用回调函数比较数据 
    array_uintersect_uassoc() - 带索引检查计算数组的交集，用回调函数比较数据和索引 


差集:
array array_diff  ( array $array1  , array $array2  [, array $...  ] )
    array_diff() - 对比返回在 array1 中但是不在 array2 及任何其它参数数组中的值。
    
    array_udiff() - 用回调函数比较数据来计算数组的差集 
    array_diff_assoc() - 带索引检查计算数组的差集 
    array_diff_uassoc() - 用用户提供的回调函数做索引检查来计算数组的差集 
    array_udiff_assoc() - 带索引检查计算数组的差集，用回调函数比较数据 
    array_udiff_uassoc() - 带索引检查计算数组的差集，用回调函数比较数据和索引 
    array_diff_key() - 使用键名比较计算数组的差集 
    array_diff_ukey() - 用回调函数对键名比较计算数组的差集 

    implode(",",$args); 拼接数组为字符串;
    explode() - 使用一个字符串分割另一个字符串 

6. 数组与数据结构
    桟: 后进先出, 栈顶, 桟底, 压入, 弹出; 
    队列: 先进先出, 队首, 队尾, 

int array_push  ( array &$array  , mixed  $var  [, mixed  $...  ] )
    将 array 当成一个栈，并将传入的变量压入 array 的末尾。array 的长度将根据入栈变量的数目增加。返回处理之后数组的元素个数。 

mixed  array_pop  ( array &$array  )
    弹出并返回 array 数组的最后一个单元，并将数组 array 的长度减一。如果 array 为空（或者不是数组）将返回 NULL 。 此外如果被调用不是一个数则会产生一个 Warning。 Note: 使用此函数后会重置（ reset() ） array  指针。 

int array_unshift  ( array &$array  , mixed  $var  [, mixed  $...  ] )
    将传入的单元插入到 array 数组的开头。注意单元是作为整体被插入的，因此传入单元将保持同样的顺序。所有的数值键名将修改为从零开始重新计数，所有的文字键名保持不变。 

mixed  array_shift  ( array &$array  )
    将 array 的第一个单元移出并作为结果返回，将 array 的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变。 Note: 使用此函数后会重置（ reset() ） array  指针。 




7. 其他
mixed  array_rand  ( array $input  [, int $num_req  = 1  ] )
    从数组中取出一个或多个随机的单元，并返回随机条目的一个或多个键。 如果你只取出一个， array_rand()  返回一个随机单元的键名，否则就返回一个包含随机键名的数组。这样你就可以随机从数组中取出键名和值。 num_req 指明了你想取出多少个单元。如果指定的数目超过了数组里的数量将会产生一个 E_WARNING  级别的错误
    
bool shuffle  ( array &$array  )
    本函数打乱（随机排列单元的顺序）一个数组。 成功时返回 TRUE ， 或者在失败时返回 FALSE 。 

number  array_sum  ( array $array  )
    array_sum()  将数组中的所有值的和以整数或浮点数的结果返回。


array range  ( mixed  $start  , mixed  $limit  [, number  $step  = 1  ] )
    建立一个包含指定范围单元的数组。 返回的数组中从 start 到 limit 的单元，包括它们本身。 
    参数
    start 
    序列的第一个值。 
    limit 
    序列结束于 limit 的值。 
    step 
    如果给出了 step 的值，它将被作为单元之间的步进值。step 应该为正值。如果未指定，step 则默认为 1。 

array array_fill  ( int $start_index  , int $num  , mixed  $value  )
    用 value 参数的值将一个数组填充 num 个条目，键名由 start_index 参数指定的开始。 

array compact  ( mixed  $varname  [, mixed  $...  ] )
    创建一个包含变量与其值的数组。 
    对每个参数， compact()  在当前的符号表中查找该变量名并将它添加到输出的数组中，变量名成为键名而变量的内容成为该键的值。简单说，它做的事和 extract()  正好相反。返回将所有变量添加进去后的数组。 
    任何没有变量名与之对应的字符串都被略过。 
