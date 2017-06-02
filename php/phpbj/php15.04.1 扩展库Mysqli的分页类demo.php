<?php
    //eg: 使用get传输数据并操作sql 
    // mysqli扩展
    //http://127.0.0.1/test.php?name=testuser&password=111&sex=male&email=adfad&tel=191919&pid=12
    
    include('./page/page.class.php');

    header('Content-Type:text/html;charset=utf-8');
    date_default_timezone_set('PRC');

    //先定义sql语句
    //1. 连接数据库,返回资源; url, 用户名, 密码, 设置默认数据库名;
    $mysqli = new mysqli('localhost', 'root', 'root' , 'test');
    if($mysqli -> connect_errno ){
        echo "连接数据库错误: ". $mysqli -> connect_errno ;
        exit;
    }
    $sql = 'SELECT id as "编号", name as "用户名", password as "密码", sex as "性别", email as "邮箱", tel as "电话" FROM users';
    $result = $mysqli->query($sql);
    $cols = $result->field_count; 
    $rows = $result->num_rows; 
    $num = 10;

    echo '<table align="center" width="800" border="1" >';
    echo '<caption><h2>分页表</h2></caption>';
    echo '<tr>';
    while ( $finfo  =  $result -> fetch_field ()) {
         echo '<th>'.$finfo -> name .'</th>';
    }
    echo '</tr>';

    $page = new Page($rows, $num, 'pid=66');
    $sql = 'SELECT id as "编号", name as "用户名", password as "密码", sex as "性别", email as "邮箱", tel as "电话" FROM users '.$page->limit;
    $result = $mysqli->query($sql);
    
    //循环遍历
    while ($row = $result->fetch_assoc()){ 
        echo '<tr>';
        foreach($row as $value){
            echo '<td>'.$value.'</td>';
        }
        echo '</tr>';
    };

    echo "<tr><td colspan={$cols} align='center' >".$page->fpage(array(0,1,2,3,4,5,6,7,9,8)).'</td></tr>';
    echo '</table>';
    
    
    //通过返回值判断SQL语句是否合法
    if(!$result){
        echo '错误发生: 错误号: '.$mysqli->errno.' : 错误信息: '.$mysqli->error.'<br>';
    }
    //通过影响行数的函数,判断表是否有变化;
    if($mysqli->affected_rows > 0){
        echo $mysqli->affected_rows.'行数据有变动, 操作成功<br>';
    }else{
        echo '数据无变动, 操作失败:'.$mysqli->errno.' : '.$mysqli->error.'<br>';
    }

    //5.释放资源:
    //释放结果集资源
    $result -> close (); // $result -> free() ; $result -> free_result() 都可以;
    //关闭数据库连接,不写参数默认关闭所有;
    $mysqli -> close();