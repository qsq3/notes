<?php
    字符串类型:
    1. 单双引号: 双引号解析变量和转义符, 单引号只解析 \\ 和\单引号,不解析变量;
    2. 定界符: <<<
    3. 分割,匹配,查找,替换;
    其他类型的数据使用字符串处理函数, 先自动转字符串;
    字符串可以通过下标{}[]来读写(JS只能通过[]读), 建议{};
    $str = "hello";
    $str[2] = "world"; //hewlo;

    常用字符串处理函数: 分 普通 和 多字节(mb_) 字符串处理函数

    UTF-8 中文字符占3字节, GB2312占2字节
    count(数组);
    strlen(字符串);
    
    字符串输出语句:
（1）echo"helloworld！";---echo命令   能够输出一个以上的字符串,数字, 输出布尔值true为1, false为空;
（2）print();输出语句，是函数，有返回值。输出成功返回1，失败返回0。 只能输出一个字符串，并始终返回 1
（3）printf();格式化输出字符串。例：printf("%d,%f",12,12.3); 
（4）sprintf();格式化返回字符串，不是输出语句，只能将字符串拼接。
 (5) die();输出一条信息,并退出当前脚本; die()就是exit()的一个别名;


可能的格式值：
%% - 返回一个百分号 %
%b - 二进制数
%c - ASCII 值对应的字符
%d - 包含正负号的十进制数（负数、0、正数）
%e - 使用小写的科学计数法（例如 1.2e+2）
%E - 使用大写的科学计数法（例如 1.2E+2）
%u - 不包含正负号的十进制数（大于等于 0）
%f - 浮点数（本地设置）
%F - 浮点数（非本地设置）
%g - 较短的 %e 和 %f
%G - 较短的 %E 和 %f
%o - 八进制数
%s - 字符串
%x - 十六进制数（小写字母）
%X - 十六进制数（大写字母）
附加的格式值。必需放置在 % 和字母之间（例如 %.2f）：
+ （在数字前面加上 + 或 - 来定义数字的正负性。默认地，只有负数做标记，正数不做标记）
' (单引号)' （规定使用什么作为填充，默认是空格。它必须与宽度指定器一起使用。）
- （左调整变量值）
[0-9] （规定变量值的最小宽度）
.[0-9] （规定小数位数或最大字符串长度）
注释：如果使用多个上述的格式值，它们必须按照上面的顺序进行使用，不能打乱。


字符串处理
    一.去空格
    ltrim(); rtrim(); trim();
    str_pad(); 按需求对字符串填充;


    二.和html标签相关的字符串格式化函数:
    htmlspecialchars();  Convert special characters to HTML entities 
    addslashes ;  使用反斜线引用字符串 \
    stripcslashes() - 反引用一个使用 addcslashes 转义的字符串 
    stripslashes() - 反引用一个引用字符串 
    strip_tags — 从字符串中去除 HTML 和 PHP 标记 
    nl2br — 在字符串所有新行之前插入 HTML 换行标记 
    htmlentities — 将非ASCII码转换为对应实体代码;
    
    字符串格式化函数:
    strrev — 反转字符串
    strlen — 获取字符串长度
    number_format — 以千位分隔符方式格式化一个数字
    md5 — 计算字符串的 MD5 散列值

    比较函数:
    == 注意区分大小写
    int strcmp  ( string $str1  , string $str2  ) — 二进制安全字符串比较  如果 str1 小于 str2 返回 -1； 如果 str1 大于 str2 返回 1；如果两者相等，返回 0。

    strcasecmp() - 二进制安全比较字符串（不区分大小写） 
    int strncmp  ( string $str1  , string $str2  , int $len  )该函数与 strcmp()  类似，不同之处在于你可以指定两个字符串比较时使用的长度（即最大比较长度）。 注意该比较区分大小写。
    strncasecmp() - 二进制安全比较字符串开头的若干个字符（不区分大小写） 

    int strnatcmp  ( string $str1  , string $str2  )该函数实现了以人类习惯对数字型字符串进行排序的比较算法，这就是“自然顺序”。注意该比较区分大小写
    strnatcasecmp() - 使用“自然顺序”算法比较字符串（不区分大小写） 


    $str = 'hello WORLD a839i9o  ';
    echo $str.'---'.strlen($str).'<br>';
    $nstr = trim($str,"0..9i..z ");
    echo $nstr.'---'.strlen($nstr).'<br>';
    $nstr = str_pad($str,26,"_");
    echo $nstr.'---'.strlen($nstr).'<br>';
    $nstr = strtoupper($str);
    echo $nstr.'---'.strlen($nstr).'<br>';
    $nstr = strtoupper($str);
    echo $nstr.'---'.strlen($nstr).'<br>';
    $nstr = strtolower($str);
    echo $nstr.'---'.strlen($nstr).'<br>';
    $nstr = ucfirst($str);
    echo $nstr.'---'.strlen($nstr).'<br>';
    $nstr = ucwords($str);
    echo $nstr.'---'.strlen($nstr).'<br>';

    strstr() - 查找字符串的首次出现 
    stristr — strstr()  函数的忽略大小写版本 
    strpos() - 查找字符串首次出现的位置 
    stripos() - 查找字符串首次出现的位置（不区分大小写） 
    
    dirname()
    explode() 分割字符串为数组;
    implode() 连接数组为字符串;
    str_repeat() 字符串重复拼接;