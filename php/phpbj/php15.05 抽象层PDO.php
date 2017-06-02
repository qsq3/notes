<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
/* PDO扩展 PHP Data Object
    对于不同数据库,采取基于不同驱动

一. 安装:
    基础文件:
    1. linux:
        --width-pdo-mysql = /user/local/mysql

    2. windows
        pdo扩展: D:\xampps\php\ext\php_pdo.dll //php5.5以后默认开启pdo,扩展文件夹中无此文件
        pdo扩展的mysql引擎:  D:\xampps\php\ext\php_pdo_mysql.dll

    配置(配置文件中前面的分号为注释): 
        php.ini中: extension=php_pdo_mysql.dll 

二. 简述

    PDO提供三个类:
        PDO : 代表 PHP 和数据库服务之间的一个连接, 执行sql语句等
        PDOStatement : 预处理类, 代表一条预处理语句，并在该语句被执行后代表一个相关的结果集。
        PDOException 异常类 , 代表一个由 PDO 产生的错误。在自己的代码不应抛出一个 PDOException 异常。
    
    PDO提供很多常量: 
        

    */
    //eg: 使用get传输数据并操作sql 
    //http://127.0.0.1/test.php?name=testuser&password=111&sex=male&email=adfad&tel=191919&pid=12

    $dsn  =  'mysql:dbname=test;host=127.0.0.1;port=3306;charset=utf8' ;
    //$dsn  =  'uri:file:///usr/local/dsn' ; //通过本地的配置文件连接;  
    //$dsn  =  'mydb' ; //使用别名连接到一个ODBC数据库 , 别名需定义在配置文件 php.ini中

    $user  =  'root' ;
    $password  =  'root' ;

    //设置连接参数1 ,初始化时设置: 
    $driver_ops = array( PDO::ATTR_AUTOCOMMIT=>1 , PDO::ATTR_PERSISTENT => false );
    
    try {
        $pdo  =  new  PDO ( $dsn ,  $user ,  $password , $driver_ops );
        echo "数据库连接成功<hr>";
    } catch ( PDOException $e ) {
        echo  '数据库连接失败: '  .  $e -> getMessage () ;
        exit;
    }
    //设置连接参数2
    $pdo -> setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); //设置错误报告模式 : 异常模式;
    
    //获取连接参数
    $attributes  = array(
        "AUTOCOMMIT" => "是否自动提交",
        "ERRMODE" => "错误模式",
        "CASE" => "强制列名大小写 --- 0. PDO::CASE_NATURAL：保留数据库驱动返回的列名。 1. PDO::CASE_UPPER：强制列名大写。2. PDO::CASE_LOWER：强制列名小写。 ",  
        "CLIENT_VERSION" => "客户端版本",
        "CONNECTION_STATUS" => "连接状态", 
        "DRIVER_NAME" => "驱动名", 
        "ORACLE_NULLS" => "在获取数据时将空字符串转换成 SQL 中的 NULL", 
        "SERVER_INFO" => "服务器信息",  
        "SERVER_VERSION" => "服务器版本",
        "PERSISTENT" => "请求一个持久连接，而非创建一个新连接, 需在初始化时设置." //,
        /* 下面二个为设置选项 并非所有驱动都支持*/
        //"PREFETCH" => "设置预取大小来为你的应用平衡速度和内存使用。", 
        //"TIMEOUT" => "设置连接数据库的超时秒数"
    );

    foreach ( $attributes  as  $key => $val ) {
        echo  "PDO::ATTR_{$key} : {$val} : " ;
        echo  $pdo -> getAttribute ( constant ( "PDO::ATTR_{$key}" )) .  "\n<br>" ;
    }
    
/* 执行SQL语句:
    PDO::query   — 执行一条 SQL 语句，并返回PDOStatementd结果集对象(类数组);用于执行有结果集的语句 select  desc ...
    PDO::exec    — 执行一条 SQL 语句，并返回受影响的行数;   用于执行无结果集的语句 update delete insert ...
    PDO::prepare — 执行一条 SQL 语句，并返回PDOStatementd预处理对象; 
*/
    
    //非查询语句(无结果集): PDO::exec
    $sql = "INSERT INTO users( name, balance) VALUES('王二' , '1000'),('张三' , '2000')";

    /*  错误模式: 默认
    $affect_rows = $pdo -> exec( $sql );
    if( $affect_rows > 0 ){
        echo "执行成功, 受影响行数为{$affect_rows}<br>";
    } else {
        
        echo "执行失败, 受影响行数为{$affect_rows}<br>";
        echo "错误代码: ". $pdo->errorCode() .'<br>';
        echo "错误信息: ";
        print_r($pdo->errorInfo());
        exit;
    }
    */

    /* 错误模式: 异常 */
    try {
        $affect_rows = $pdo -> exec( $sql );
        echo "执行成功, 受影响行数为{$affect_rows}<br>";
        echo "最近插入语句(可以是多行)的ID(多行的情况, id全为自动增长则为第一个,或者指定id的最后一个): ". $pdo -> lastInsertId() . '<br>';
    } catch ( PDOException $e ){
        echo '执行失败: ' . $e -> getMessage () ;
        exit;
    }

    //查询语句(有结果集):  PDO::query
    $sql = "SELECT * FROM users WHERE id < 20";

    /* 错误模式: 异常 */
    try {
        $stmt = $pdo -> query( $sql );
        echo "查询语句执行成功: ";
        echo($stmt->queryString).'<br>';
        var_dump($stmt);
        echo '<br>';
        foreach($stmt as $key => $value){
            echo "$key : ";
            print_r($value);
            echo '<br>';
        }
        echo '<hr>';
    } catch ( PDOException $e ){
        echo '执行失败: '  .  $e -> getMessage () ;
        exit;
    }
    
/* 事务处理  InnoDB支持, MyIsam不支持*/
    echo "<hr>开始事务处理: <br>";

    

    /* 错误模式: 异常 */
    try {
        //关闭自动提交
        $pdo -> setAttribute (PDO::ATTR_AUTOCOMMIT, 0 );
        //开启事务处理
        $pdo -> beginTransaction();

        //执行SQL语句
        $buyerId = 2;
        $salerId = 1;
        $productId =9;

        $sql = "update users set balance=balance-(select price from products where id={$productId}) where id={$buyerId};";

        $affect_rows = $pdo -> exec( $sql );

        //手动抛出异常
        if($affect_rows){
            echo "购买者余额更新成功,更新记录 $affect_rows 条<br>";
        }else{
            throw new PDOException("购买者余额更新失败");
        }

        $sql = "update users set balance=balance+(select price from products where id={$productId}) where id={$salerId};";
        $affect_rows = $pdo -> exec( $sql );
        if($affect_rows){
            echo "出售者余额更新成功,更新记录 $affect_rows 条<br>";
        }else{
            throw new PDOException("出售者余额更新失败");
        }

        //确认正常并提交
        $pdo -> commit ();
        echo "支付事务执行成功<hr>";
        
    } catch ( PDOException $e ){

        //识别错误并回滚
        $pdo -> rollBack ();
        echo '执行失败: '  .  $e -> getMessage () ;
        exit;
    }
    
    //恢复开启自动提交
    $pdo -> setAttribute (PDO::ATTR_AUTOCOMMIT, 1 );

/*PDOStatement 类 代表一条预处理语句，并在该语句被执行后代表一个相关的结果集。 PDO::prepare
    PDO两种占位符: ? 参数 --- 索引数组 ;  名字参数 --- 关联数组; 
*/
    

    try {

    /* 无结果集 */
        $sql = "INSERT INTO users(name, balance) VALUES(?, ?)"; //?参数
        
        $sql = "UPDATE users SET name=:name, balance=:balance WHERE id=:id"; // 名字参数

        $sql = "INSERT INTO users(name, balance) VALUES(:name, :balance)"; // 名字参数

       
        //预处理 prepare
        $stmt = $pdo -> prepare( $sql );
        
        /*绑定参数1 bindParam 
        
        // 绑定 ? 参数
        //$stmt -> bindParam ( 1 ,  $name ,  PDO :: PARAM_STR );
        //$stmt -> bindParam ( 2 ,  $balance , PDO :: PARAM_STR | PDO :: PARAM_INPUT_OUTPUT ,  12 );
        
        // 绑定名字参数
        $stmt -> bindParam ( ':id' ,  $id ,  PDO :: PARAM_INT );
        $stmt -> bindParam ( ':name' ,  $name ,  PDO :: PARAM_STR );
        $stmt -> bindParam ( ':balance' ,  $balance , PDO :: PARAM_STR | PDO :: PARAM_INPUT_OUTPUT );
        
        //
        $id = 225;
        $name = '赵六';
        $balance = '800.12';

        //执行 execute
        $flag = $stmt -> execute ();
        */

        /* 绑定参数2 直接执行 execute 传参*/
        
        $stmt -> execute( array( ':name' => '赵钱' , ':balance' => '1688.88' ));
        //$stmt -> execute( $_POST );
        
        //$stmt -> execute( array( '100', '赵钱' , '1688.88' ) ) // ?参数 执行传参;

        //手动抛出异常
        $affect_rows = $stmt -> rowCount();
        
        if($affect_rows){
            echo "受影响行数为{$affect_rows}<br>";
            echo "最后插入行的id为". $pdo -> lastInsertId() . '<br>';
            echo "无结果集预处理执行成功<br><hr><br>";
        }else{
            throw new PDOException("错误: 无记录更新, 手动抛出异常");
        }

    /*有结果集 */
        $sql = "SELECT id , name, balance FROM users WHERE id < :num";
        
        
        //预处理 prepare
        $stmt = $pdo -> prepare( $sql );
        $stmt -> execute( array( ':num' => 5 ));
        /*
        foreach($stmt as $val){
            print_r($val);
            echo '<br>';
        }
        */
        
        //获取结果
        //PDOStatement::fetchColumn — 从结果集中的下一行返回单独的一列。
        //PDOStatement::fetch — 从结果集中获取下一行 
        //PDOStatement::fetchAll()  返回一个包含结果集中所有剩余行的数组。此数组的每一行要么是一个列值的数组，要么是属性对应每个列名的一个对象。 
        //
        printTable ($stmt);

        //释放 $stmt
        $stmt  =  null ;

    } catch ( PDOException $e){
        echo "错误 : ".$e ->getMessage();
        exit;
    
    }


function printTable($stmt){
    echo '<table align="center" width="800" border="1" >';
    echo '<caption><h2>演示表</h2></caption>'; 
    //循环遍历每列

    echo '<tr>';
    for ($i=0; $i < $stmt->columnCount() ; $i++){ 
        $col  =  $stmt -> getColumnMeta ($i);
        echo '<th>'.$col['name'] .'</th>';
    }
    echo '</tr>';

    
    
//循环遍历每行 fetch 

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        echo '<tr>';
        foreach($row as $value){
            echo '<td>'.$value.'</td>';
        }
        echo '</tr>';
    };
    
// 没有移动指针方法, 建议使用 fetchAll 
 
    //设置fetch模式,
    $stmt -> setFetchMode  ( PDO::FETCH_ASSOC );

//循环遍历结果数组 fetchAll

    $result = $stmt -> fetchAll();

    foreach ( $result as $row){
        echo '<tr>';
        foreach ($row as $key => $value){
            echo '<td>'.$value.'</td>';
        };
        echo '</tr>';
    }
    
    //释放指针连接
    $stmt -> closeCursor ();

echo '<tr><td colspan='. $stmt->columnCount().'>----------------------</td></tr>';

//通过绑定列  bindColumn
    $stmt -> bindColumn ( 'id' , $id, PDO::PARAM_INT);
    $stmt -> bindColumn ( 'name' , $name, PDO::PARAM_STR);
    $stmt -> bindColumn ( '3' , $balance, PDO::PARAM_STR);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        echo '<tr>';
            echo '<td>'.$id.'</td>';
            echo '<td>'.$name.'</td>';
            echo '<td>'.$balance.'</td>';
        echo '</tr>';
    };

//行/列数
    $footer  = '<tr><td colspan='. $stmt->columnCount().'>';
    $footer .= '总行数:'. $stmt->rowCount();
    $footer .= '总列数:'. $stmt->columnCount();
    $footer .= '</td></tr>';
    echo $footer;

    echo '</table>';
}

//例子 2. Fetching rows with a scrollable cursor 输出有误  可能是版本或引擎原因 待验证：
$sql  =  'SELECT id, name, balance FROM users WHERE id<10 ORDER BY id' ;
function  readDataForwards ( $dbh ,$sql  ) {
  try {
     $stmt  =  $dbh -> prepare ( $sql , array( PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ));
     $stmt -> execute ();
    while ( $row  =  $stmt -> fetch ( PDO :: FETCH_NUM ,  PDO :: FETCH_ORI_NEXT )) {
       $data  =  $row [ 0 ] .  "\t"  .  $row [ 1 ] .  "\t"  .  $row [ 2 ] .  "\n<br>" ;
      print  $data ;
    }
     $stmt  =  null ;
  }
  catch ( PDOException $e ) {
    print  $e -> getMessage ();
  }
}
function  readDataBackwards ( $dbh ,$sql ) {
  try {
     $stmt  =  $dbh -> prepare ( $sql , array( PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ));
     $stmt -> execute ();
     $row  =  $stmt -> fetch ( PDO :: FETCH_NUM ,  PDO :: FETCH_ORI_LAST );
    do {
       $data  =  $row [ 0 ] .  "\t"  .  $row [ 1 ] .  "\t"  .  $row [ 2 ] .  "\n<br>" ;
      print  $data ;
    } while ( $row  =  $stmt -> fetch ( PDO :: FETCH_NUM ,  PDO :: FETCH_ORI_PRIOR ));
     $stmt  =  null ;
  }
  catch ( PDOException $e ) {
    print  $e -> getMessage ();
  }
}

print  "<hr>Reading forwards:\n<br>" ;
 readDataForwards ( $pdo ,$sql  );

print  "<hr>Reading backwards:\n<br>" ;
 readDataBackwards ( $pdo ,$sql );
