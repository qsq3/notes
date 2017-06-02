<?php
    //eg: 使用get传输数据并操作sql 
    // mysqli扩展
    //http://127.0.0.1/test.php?name=testuser&password=111&sex=male&email=adfad&tel=191919&pid=12

    header('Content-Type:text/html;charset=utf-8');
    date_default_timezone_set('PRC');

    //先定义sql语句
    //1. 连接数据库,返回资源; url, 用户名, 密码, 设置默认数据库名;
    $mysqli = new mysqli('localhost', 'root', 'root' , 'test');
    if($mysqli -> connect_errno ){
        echo "连接数据库错误: ". $mysqli -> connect_errno ;
        exit;
    }
    //2. 设置操作信息  mysqli->query — 发送一条 mysqli 查询 

    // 设置字符集;
    // 注意表单提交的字符集和脚本中的字符集可能不一致;
    $mysqli->query('set names utf8mb4');
    //$mysqli->set_charset('gb2312');
    /*

    //获取相关信息
    echo 'mysqli客户端信息: '.mysqli_get_client_info().'<br>';
    echo 'mysqli主机信息: '.mysqli_get_host_info().'<br>';
    echo 'mysqli协议版本信息: '.mysqli_get_proto_info().'<br>';
    echo 'mysqli服务器信息: '.mysqli_get_server_info().'<br>';

    //4. 操作数据库的sql语句执行
    
    /*
        SQL语句分为两种: 
        1. 非查询语句(操作型语句) DML DCL DDL : 返回bool值 或 基本类型; 
            create insert update delete alter
        2. 查询型语句 DQL : 成功则返回结果集(资源),并可以处理结果集,失败返回假;
            select desc
    */
    
    //非查询语句
    $sql = "CREATE TABLE IF NOT EXISTS users(
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(30) NOT NULL DEFAULT '',
            password VARCHAR(30) NOT NULL DEFAULT '',
            sex ENUM('male','female','unknown') NOT NULL DEFAULT 'unknown',
            email VARCHAR(30) NOT NULL DEFAULT '',
            tel INT NOT NULL DEFAULT 0,
            PRIMARY KEY (id),
            KEY name(name, sex)
        );";
    echo '建表语句返回值为: '.$mysqli->query($sql).'<br>'; //1

    $sql = "INSERT INTO users(name, password, sex, email, tel) 
        VALUES('{$_GET['name']}', '{$_GET['password']}', '{$_GET['sex']}', '{$_GET['email']}', '{$_GET['tel']}');";
    echo '插入语句返回值为: '.$mysqli->query($sql).'<br>'; //1
    echo '最后的自动增长ID是: '.($mysqli->insert_id).'<br>'; //mysqli_insert_id($link)

    $sql = "UPDATE users SET name=concat('{$_GET['name']}',RAND()) WHERE id<='{$_GET['pid']}'+5;";
    echo '<br>更新'.$mysqli->query($sql);
    
    $sql = "DELETE FROM users WHERE id>='{$_GET['pid']}'+5 && id<='{$_GET['pid']}'+8";
    echo '<br>删除'.$mysqli->query($sql);

    echo '<br>影响的行数: '.$mysqli->affected_rows.'<br>'; //mysqli_affected_rows()
    
    //查询语句
    /*
     * 一. 从结果集中取出记录/行信息
        1. $result->fetch_row(); mysqli_fetch_row() - 从结果集中取得一行作为枚举/索引数组 
        2. $result->fetch_assoc() ; mysqli_fetch_assoc() - 从结果集中取得一行作为关联数组 

        3. $result->fetch_array() ; mysqli_fetch_array() - 从结果集中取得一行作为关联数组，或数字数组，或二者兼有,取决于参数MYSQLI_ASSOC , MYSQLI_NUM , or MYSQLI_BOTH ;
        4. $result->fetch_object() ; mysqli_fetch_object() - 从结果集中取得一行作为对象 
        
        5. $result->data_seek()  ; mysqli_data_seek() - 移动行指针 
         
        6. $result-> ; mysqli_result() - 取得结果数据  推荐使用上面的高性能的替代函数
        
        一次性从结果集中取出当前指针的一条记录(默认为第一条);
        再将指针移动到下一条记录;
        再取依次递增,直到结尾返回false;
    
    */

    //执行 $result = $mysqli->query($sql) 返回结果集;
    $sql = 'DESC users';
    $result = $mysqli->query($sql);
    echo '描述表结构语句输出: ';
    var_dump($result); //object(mysqli_result)#2
    echo '<hr/>';

    $sql = 'SELECT id as "编号", name as "用户名", password as "密码", sex as "性别", email as "邮箱", tel as "电话" FROM users';
    $result = $mysqli->query($sql);
    echo '查询语句输出: '; 
    var_dump($result); //object(mysqli_result)#3
    echo '<hr/>';

    $cols = $result->field_count; //取得结果集中字段的数目 $cols = mysqli_num_fields($result);
    $rows = $result->num_rows; //取得结果集中行的数目 $rows = mysqli_num_rows($result);
    echo "表 [列 : {$cols}, 行 : {$rows}]<br>";

    $result->data_seek(0); //移动指针

    renderTable($result); //绘制表格
    
    $result->data_seek(66); //移动指针
    $row = $result->fetch_assoc(); //从结果集中取得一行作为关联数组 
    echo $row['编号']."<br>";

    //通过影响行数的函数,判断表是否有变化;
    if($mysqli->affected_rows > 0){
        echo $mysqli->affected_rows.'行数据有变动, 操作成功<br>';
    }else{
        echo '数据无变动, 操作失败:'.$mysqli->errno.' : '.$mysqli->error.'<br>';
    }

    //二. 从结果集中处理字段/列信息
    /*  7. $result->lengths  ; mysqli_fetch_lengths() - 返回一个索引数组, 值为结果集中当前指针行的每个字段的长度
     *  8. $result -> fetch_field () 逐列查询, 返回一个该列字段的属性对象;
     *  9. $result->current_field ; 返回用于最后一次的 mysqli_fetch_field() 调用的字段指针的位置。可以使用此值作为 mysqli_field_seek() 的参数, 等同mysqli_field_tell ( $result );
        10. bool $result->field_seek  ( int $fieldnr  ) 移动列指针;
        11. array $result->fetch_fields  ( void ); 返回所有列字段属性对象组成的数组;
     * 
     */
     
    foreach ( $result -> lengths  as  $i  =>  $val ) {  //注意: 此处为取出行指针所在行的数据, 也就是行指针必须在有效行内;
         printf ( "Field %2d has Length %2d\n<br>" ,  $i + 1 ,  $val );
    }
    //通过返回值判断SQL语句是否合法
    if(!$result){
        echo '错误发生: 错误号: '.$mysqli->errno.' : 错误信息: '.$mysqli->error.'<br>';
    }

    //5.释放资源:
    //释放结果集资源
    $result -> close (); // $result -> free() ; $result -> free_result() 都可以;
    
/* 四.  执行多条语句 bool mysqli::multi_query  ( string $query); 字符串$query内的多个sql语句用分号隔开 */
    
    //多条非查询语句
    $sqls  = "INSERT INTO users(name, password, sex, email, tel) VALUES('{$_GET['name']}', '{$_GET['password']}', '{$_GET['sex']}', '{$_GET['email']}', '{$_GET['tel']}') ; ";
    $sqls .= "UPDATE users SET name=concat('{$_GET['name']}',RAND()) WHERE id<='{$_GET['pid']}'+5;";
    $sqls .= "DELETE FROM users WHERE id>='{$_GET['pid']}'+5 && id<='{$_GET['pid']}'+8";
    
    //多条查询语句
    $sqls  = "SELECT CURRENT_USER();";
    $sqls .= 'DESC users;';
    $sqls .= 'SELECT id as "编号", name as "用户名", password as "密码", sex as "性别", email as "邮箱", tel as "电话" FROM users';

    $result = $mysqli->multi_query($sqls);
    
    if($result){
        echo "成功执行多条语句<br>";
        echo "最后插入的ID为: ".($mysqli->insert_id).'<br>';
        //echo '影响行数'.$mysqli->affected_rows.'<br>'; //1 ,这里不准确了
        
        //依次取出多条查询语句的结果集 mysqli_store_result($link, [,int $option]); $mysqli->store_result ([ int $option  ])
        do{
            $result = $mysqli->store_result();
            renderTable($result);
        }while($mysqli->more_results() && $mysqli->next_result());//手动跳转下一个结果集

        $result -> close ();
    }else{
        echo '操作失败:'.$mysqli->errno.' : '.$mysqli->error.'<br>';
    }

/*五. 事务处理 , 有任何一个环节出错, 会将整个事务回滚 InnoDB和BDB表类型才支持;
        所有表类型都是默认自动提交 autocommit(即不回滚);
    */
    //1 首先需关闭自动提交 set autocommit=0; 开启为 set autocommit=1;
    $mysqli -> autocommit ( false );

    //2. 开启事务 start transaction; (MySqli中关闭自动提交后开启, PDO中才需要)
    //执行sql语句
    $flag = true;
    $buyerId = 1;
    $salerId = 2;
    $productId =9;

    $sql = "update users set balance=balance-(select price from products where id={$productId}) where id={$buyerId};";
    $result = $mysqli->query($sql);
    if(!$result){
        $flag = false;
        echo '错误发生,购买方金额转出失败: 错误号: '.$mysqli->errno.' : 错误信息: '.$mysqli->error.'<br>';
    }else if($mysqli->affected_rows <= 0){
        $flag = false;
        echo '错误发生,购买方金额没有变动: 错误号: '.$mysqli->errno.' : 错误信息: '.$mysqli->error.'<br>';
    }else{
        echo '购买方金额转出成功!<br>';
    }
    
    $sql = "update users set balance=balance+(select price from products where id={$productId}) where id={$salerId};";
    $result = $mysqli->query($sql);
    if(!$result){
        $flag = false;
        echo '错误发生,出售方金额转入失败: 错误号: '.$mysqli->errno.' : 错误信息: '.$mysqli->error.'<br>';
    }else if($mysqli->affected_rows <= 0){
        $flag = false;
        echo '错误发生,出售方金额没有变动: 错误号: '.$mysqli->errno.' : 错误信息: '.$mysqli->error.'<br>';
    }else{
        echo '出售方金额转入成功!<br>';
    }

    if(!$flag){
        //3 回滚命令 rollback;
        echo '转账失败!<br>';
        $mysqli -> rollback ();
        //3.1 折返点    SAVEPOINT adqoo_1;   ROLLBACK TO SAVEPOINT adqoo_1; 发生在折返点 adqoo_1 之前的事务被提交，之后的被忽略 public bool mysqli::savepoint  ( string $name  )
    } else {
        //4 确认无误后提交 commit;
        echo '转账成功!<br>';
        $mysqli -> commit ();
    };
    //执行完毕,重新开启自动提交
    $mysqli -> autocommit ( true );

    
/*六 MySqli 的预处理类 MySQLi_STMT 推荐使用

    优点 :
    1. 功能: 能完成大部分 mysqli类和 mysqli_result类的大部分功能
    2. 效率: 对需要执行多次的相同语句, 只需要在服务器端编译一次, 客户端只需要传入不同数据
    3. 安全: 防止SQL注入; ?占位符
    */

    /* 1. 处理非查询语句 */

    //1. 初始化STMT对象 mysqli_stmt  mysqli::stmt_init  ( void ) 
    //$stmt =$mysqli->stmt_init();
    
    //2. 准备好预存语句
    //$sql = "INSERT INTO users(name, sex) VALUES(?,?)";
    $sql = "UPDATE users SET name=?, sex=? WHERE id=?";

    //调用STMT的预处理方法
    //$stmt->prepare($sql);

    //1. 也可不初始化stmt对象, 直接使用mysqli的预处理方法
    $stmt = $mysqli->prepare($sql);

    //给占位符号?绑定变量参数;
    //bool mysqli_stmt::bind_param  ( string $types  , mixed  &$var1  [, mixed  &$...  ] ) 
    //$types = i (integer)/ d (double)/ s (string)/ b(blob)

    $stmt -> bind_param("ssi",$name,$sex,$id);
    
    //赋值:
    $name = "张三";
    $sex = "male";
    $id = "6";
    //执行;
    $stmt->execute();
    
    //赋值:
    $name = "王小花";
    $sex = "female";
    $id = "4";
    //执行;
    $stmt->execute();

    echo "最后ID: ".$stmt->insert_id."<br>";
    echo "影响行数: ".$stmt->affected_rows."<br>"; //1

    //释放
    $stmt->close();

    

    /* 2. 处理查询语句/结果集 */

    $sql = "SELECT id,name,sex FROM users WHERE id<?";

    if ( $stmt  =  $mysqli -> prepare ($sql )) {
        
        
        $stmt -> bind_param("i",$num); //绑定变量
        $stmt -> bind_result ( $id ,  $name ,  $sex); //绑定结果集变量
        $num = "29";

        $stmt -> execute (); //执行
        $stmt -> store_result();//一次性取出结果集
 
        //1. 处理记录信息 $stmt -> fetch ()
        $stmt -> data_seek(8); //移动指针 受store_result影响
        while ( $stmt -> fetch ()) {
             printf  ( "(id : %d) (name : %s) (sex : %s)\n<br>" ,  $id,  $name, $sex );
        }
        echo "影响行数: ".$stmt->affected_rows."<br>"; //受store_result影响
        
        //2. 处理字段信息 mysqli_stmt::result_metadata ( void ) 这个返回的结果集对象不一样,只有字段相关的方法
        $result = $stmt -> result_metadata(); 
        while($filed = $result -> fetch_field()){
            foreach($filed as $key=>$value){
                printf  ( "(%s : %s) " ,  $key, $value);
            }
            echo "\n<br>";
        };
        

        $stmt -> free_result(); //释放结果集
        $stmt -> close ();      //关闭stmt资源
    }

    //关闭数据库连接,不写参数默认关闭所有;
    $mysqli -> close();

function renderTable($result){
    echo '<table align="center" width="800" border="1" >';
    echo '<caption><h2>演示表</h2></caption>';
    //循环遍历每列
    echo '<tr>';
    while ( $col  =  $result -> fetch_field ()) {
         echo '<th>'.$col -> name .'</th>';
    }
    echo '</tr>';
    //循环遍历每行
    while ($row = $result->fetch_assoc()){  //$row = mysqli_fetch_assoc($result)
        echo '<tr>';
        foreach($row as $value){
            echo '<td>'.$value.'</td>';
        }
        echo '</tr>';
    };
    echo '</table>';
}
    
