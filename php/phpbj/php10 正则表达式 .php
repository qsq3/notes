<?php
正则表达式:
    1. 正则在php中,就是一个字符串,需要在对应函数中使用, $str = "/http\:\/\/www(.*?)(com|net)/i";
    2. PCRE preg_  POSIX ereg_
    3. 列需求, 然后一条一条满足;
    定界符 // {} ## !! ||等,除了字母,数字和\外其他字符都可以;
    原子  :字符: d \d,至少一个;由未显式指定为元字符的字符组成
        1. 普通字符: a-z, A-Z,0-9
        2. 特殊字符,转义字符;
            - 所有标点符号,但有语句特殊意义的符号需转义后才可作为原子
            - 转义字符 可以 使 字符在 无意义的打印字符 和 对应特殊意义字符 间切换, 一些没有对应特殊意义的标点符号 加不加转义 都一样; 
        3. 一些非打印字符 
            \r(回车符,等价 \x0d \cM); 
            \n(换行符,等价 \x0a \cJ) ; 
            \f(换页符,等价 \x0c \cL); 
            \t(制表符,等价 \x09 \cI); 
            \v(垂直制表符,等价 \x0b \cK) 
            \cx(匹配由x指明的控制字符,control-X, 如\cM匹配一个 Control-M或回车符, x值必须为英文字母)

        4. 通用字符类型 \d \D \w \W \s \S 

        5. 自定义原子表([]) : '/[a-i]sp/' , '/[^api]sp/' ;
        
        6. 点 (.) 代表所有

    元字符: 不单独使用, 扩展功能的修饰词,  \d{7} 
    ^和\A 开头
    $和\Z 结尾
    \b 边界  \B 非边界
    | 或 优先级最低;
    () 括号的子模式和反向引用, \1 指对第一个()匹配规则的引用, 同理2,3,4; 替换函数中还可用${1};
    (?:) 括号的不使用子模式和反向引用


    模式修正符: 对模式修正 ;定界符右边;
    i: 忽略大小写
    m: 多行模式,^,$时每行可匹配;
    s: 使 . 可以匹配 换行符
    x: 忽略非转义的空白字符;
    U: 逆转贪婪模式 (加 元字符后 ? 也可逆转贪婪模式)
    e: 如果设置了这个被弃用的修饰符， preg_replace()  在进行了对替换字符串的 后向引用替换之后, 将替换后的字符串作为php 代码评估执行(eval 函数方式)，并使用执行结果 作为实际参与替换的字符串。单引号、双引号、反斜线(\)和 NULL 字符在 后向引用替换时会被用反斜线转义. 

    $str = "time 2014/01-22";
    $reg = '/\d{4}(\/|-)\d{2}\1\d{2}/';
    if( preg_match($reg, $str,$arr)){
        echo '<pre>';
        echo "字符串: {$str}<br>正则: {$reg}<br>成功匹配<br>";
        print_r($arr);
        echo '</pre>';
    } else {
        echo '不匹配';
    }

函数相关
1. 优先使用字符串函数 
2. 匹配查找的
    字符串函数 strstr strpos substr
    正则函数   preg_match preg_match_all preg_grep
<?php
分割:
    字符串分割 : explode  implode - join
    正则分割 : preg_split 

    header("Content-Type: text/html; charset=utf-8");
    $str = "this is, a, test";

    echo "<pre>";
    print_r($arr1 = explode(' ',$str,3));
    print_r($arr2 = preg_split('/\W+/',$str,-1,PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_OFFSET_CAPTURE ));

    echo implode('+++',$arr1).'<br>';
    list($a,$b) = explode("_", "aaa_bbb");
    echo $a.'<br>';
    echo $b.'<br>';
    echo "</pre>";

替换:
    字符串替换: str_replace substr_replace 
    正则替换:   preg_replace 反引用; preg_replace_callback , preg_filter;
    <?php
    header("Content-Type: text/html; charset=utf-8");
    
    $str = '链接一: http://www.baidu.com, 然而链接二: http://www.163.net';
    $url = '/(https?|ftps?):\/\/(www|mail|ftp|bbs)\.(.+?)\.(net|com|org|cn)([\?\/\.\=\&\%\w-]*)?/';

    echo "<pre>";
    $nstr = preg_replace($url, '<a href=\'$1://\2.\3.\4\'>$1://\2.\3.\4</a>', $str);
    $nstr  = preg_replace_callback ($url, function($matches ){
        $upper = strtoupper($matches[1].'://'.$matches[2].'.'.$matches[3].'.'.$matches[4]);
        return "<a href=\'{$upper}\'>{$upper}</a>";
    }, $str);
    echo $str.'<br>';
    echo $nstr.'<br>';
    echo "</pre>";
    
    $str = array(
        '链接一: http://www.baidu.com, 然而链接2: http://www.163.net',
        '链接三: http://www.baidu.com, 然而链接4: http://www.163.net',
        '链接五: http://www.baidu.com, 然而链接6: http://www.163.net',
    );
    $reg = array(
        '/(https?|ftps?):\/\/(www|mail|ftp|bbs)\.(.+?)\.(net|com|org|cn)([\?\/\.\=\&\%\w-]*)?/e',
        '/\<[\/\!]*?[^\<\>]+?\>/is',
        '/\d/'
    );
    $rep = array(
        '"<a href=\'$1://\2.\3.\4\'>".strtoupper("$1://\2.\3.\4")."</a>"',
        '',
        '@'
    );
    $nstr = preg_replace($reg, $rep, $str);
    echo "<pre>";
    print_r($str);
    print_r($nstr);
    echo "</pre>";

其他: 
    preg_last_error — 返回最后一个PCRE正则执行产生的错误代码 
    preg_quote — 转义正则表达式字符
    