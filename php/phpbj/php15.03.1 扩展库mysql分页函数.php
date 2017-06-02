<?php
    //分页类
    header('Content-Type:text/html;charset=utf-8');
    date_default_timezone_set('PRC');

    //先定义sql语句
    //1. 连接数据库,返回资源; 持久连接 mysql_pconnect();
    @$link = mysql_connect('localhost', 'root', 'root') or die('数据库连接失败, 原因: '.mysql_error());
    //2. 设置操作信息   设置字符集;
    mysql_query('set names utf8');

    //3. 选择一个数据库,作为默认数据库使用,不写$link默认为最新连接的数据库;
    mysql_select_db('test' ,$link) or die('指定默认数据库失败');

    //4. 操作数据库的sql语句执行
    table('users', 22);

    function table($tabname, $num=10){
        $sql = "SELECT * FROM {$tabname}";
        $result = mysql_query($sql); 
        
        $url = 'test.php'; //每次请求的url
        $cols = mysql_num_fields($result); //取得结果集中字段的数目
        $rows = mysql_num_rows($result); //取得结果集中行的数目
        
        $page = isset($_GET['page']) && ($_GET['page']>=1) && ($_GET['page']<=$rows) ? $_GET['page'] : 1;
        $totalpage = ceil($rows/$num);
        $start = ( $page -1 )*$num +1;
        $end = $page*$num<=$rows ? $page*$num : $rows;
       
        echo '<table align="center" width="800" border="1" >';
        echo '<caption><h2>'.$tabname.'</h2></caption>';

        echo '<tr>';
        for($i=0; $i<$cols; $i++){
            echo '<th>'.mysql_field_name($result , $i).'</th>';
        }
        echo '</tr>';
        
        //循环遍历
        $sql = "SELECT * FROM {$tabname} LIMIT ".($start-1).", {$num}";
        $result = mysql_query($sql); 
        while ($row = mysql_fetch_assoc($result) ){
            echo '<tr>';
            foreach($row as $key){
                echo '<td>'.$key.'</td>';
            }
            echo '</tr>';
        };
        
        echo "<tr><td colspan={$cols} align='right'>";
        echo "共<b>{$rows}</b>条记录, 当前显示第<b>{$start} - {$end}</b>&nbsp;&nbsp;{$page} / {$totalpage}";

        if($page == 1){
            echo "&nbsp;&nbsp;首页&nbsp;&nbsp;";
            echo "&nbsp;&nbsp;上一页&nbsp;&nbsp;";
        }else{
            echo "&nbsp;&nbsp;<a href='{$url}?page=1'>首页</a>&nbsp;&nbsp;";
            echo "&nbsp;&nbsp;<a href='{$url}?page=".($page>=2?($page-1):1)."'>上一页</a>&nbsp;&nbsp;";
        }
        if($page == $totalpage){
            echo "&nbsp;&nbsp;下一页&nbsp;&nbsp;";
            echo "&nbsp;&nbsp;尾页&nbsp;&nbsp;";
        }else{
            echo "&nbsp;&nbsp;<a href='{$url}?page=".($page<$totalpage?($page+1):$totalpage)."'>下一页</a>&nbsp;&nbsp;";
            echo "&nbsp;&nbsp;<a href='{$url}?page=".$totalpage."'>尾页</a>&nbsp;&nbsp;";
        }
        echo '</td></tr>';
        echo '</table>';
        mysql_free_result($result);
    }

    //关闭数据库连接,不写参数默认关闭所有;
    mysql_close();