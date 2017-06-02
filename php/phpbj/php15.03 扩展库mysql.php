<?php
    //eg: 使用get传输数据并操作sql 
    //本扩展自 PHP 5.5.0 起已废弃，并在将来会被移除。应使用 MySQLi 或 PDO_MySQL 扩展来替换之。
    
    header('Content-Type:text/html;charset=utf-8');
    date_default_timezone_set('PRC');

    //先定义sql语句
    //1. 连接数据库,返回资源; 持久连接 mysql_pconnect();
    @$link = mysql_connect('localhost', 'root', 'root') or die('数据库连接失败, 原因: '.mysql_error());
    var_dump($link);
    echo '<br>';

    //2. 设置操作信息  mysql_query — 发送一条 MySQL 查询 

    // 设置字符集;
    //mysql_query('set names utf8');

    //3. 选择一个数据库,作为默认数据库使用,不写$link默认为最新连接的数据库;
    mysql_select_db('test' ,$link) or die('指定默认数据库失败');
    echo '连接指定表成功<br>';

    //获取相关信息
    echo 'MySQL客户端信息: '.mysql_get_client_info().'<br>';
    echo 'MySQL主机信息: '.mysql_get_host_info().'<br>';
    echo 'MySQL协议版本信息: '.mysql_get_proto_info().'<br>';
    echo 'MySQL服务器信息: '.mysql_get_server_info().'<br>';

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
    echo '建表语句返回值为: '.mysql_query($sql).'<br>'; //1
    
    //http://127.0.0.1/test.php?name=testuser&password=111&sex=male&email=adfad&tel=191919&pid=12
    $sql = "INSERT INTO users(name, password, sex, email, tel) 
        VALUES('{$_GET['name']}', '{$_GET['password']}', '{$_GET['sex']}', '{$_GET['email']}', '{$_GET['tel']}');";
    echo '插入语句返回值为: '.mysql_query($sql).'<br>'; //1
    echo '最后的自动增长ID是: '.mysql_insert_id().'<br>';

    $sql = "UPDATE users SET name=concat('{$_GET['name']}',RAND()) WHERE id<='{$_GET['pid']}'+5";
    echo '<br>更新'.mysql_query($sql);
    
    $sql = "DELETE FROM users WHERE id>='{$_GET['pid']}'+5 && id<='{$_GET['pid']}'+8";
    echo '<br>删除'.mysql_query($sql);

    echo '<br>影响的行数: '.mysql_affected_rows().'<br>';
    
    //查询语句
    /*
     * 一. 从结果集中将记录取出
        1. mysql_fetch_row($result) - 从结果集中取得一行作为枚举数组 
        2. mysql_fetch_assoc($result) - 从结果集中取得一行作为关联数组 

        3. mysql_fetch_array($result) - 从结果集中取得一行作为关联数组，或数字数组，或二者兼有  
        4. mysql_fetch_object($result) - 从结果集中取得一行作为对象 

        5. mysql_data_seek(int) - 移动内部结果的指针 
        6. mysql_fetch_lengths($result ) - 取得结果集中每个字段输出的长度 
        7. mysql_result($result) - 取得结果数据  推荐使用上面的高性能的替代函数
        
        一次性从结果集中取出当前指针的一条记录(默认为第一条);
        再将指针移动到下一条记录;
        再取依次递增,直到结尾返回false;
     * 
     * 
     * 二. 从结果集中将表的字段
     *
     *
     * 三. 其它: 取行数, 列数, 从那行开始取;
    */
    $sql = 'DESC users';
    echo '描述表结构语句输出为: '.mysql_query($sql).'<br>';//Resource id #4
    
    $sql = 'SELECT id as "编号", name as "用户名", password as "密码", sex as "性别", email as "邮箱", tel as "电话" FROM users ORDER BY id';
    $result = mysql_query($sql); //放入一个正确的sql语句就可以执行;
    echo '查询语句输出为: '.$result.'<br>'; //Resource id #5
    
    $cols = mysql_num_fields($result); //取得结果集中字段的数目
    $rows = mysql_num_rows($result); //取得结果集中行的数目
    echo "表 [列 : {$cols}, 行 : {$rows}]<br>";

    echo '<table align="center" width="800" border="1" >';
    echo '<caption><h2>演示表</h2></caption>';
    
    echo '<tr>';
    for($i=0; $i<$cols; $i++){
        echo '<th>'.mysql_field_name($result , $i).'</th>';
    }
    echo '</tr>';

    //循环遍历
    while ($row = mysql_fetch_assoc($result)){
        echo '<tr>';
        foreach($row as $key){
            echo '<td>'.$key.'</td>';
        }
        echo '</tr>';
    };
    /*索引遍历
    while (list($id,$name,$password,$sex,$email,$tel) = mysql_fetch_row($result)){   
        echo '<tr>';
        echo '<td>'.$id.'</td>';
        echo '<td>'.$name.'</td>';
        echo '<td>'.$password.'</td>';
        echo '<td>'.$sex.'</td>';
        echo '<td>'.$email.'</td>';
        echo '<td>'.$tel.'</td>';
        echo '</tr>';
    };
    */
    echo '</table>';
      
    mysql_data_seek($result,3); //移动指针
    
    //通过返回值判断语句是否合法
    if(!$result){
        echo '错误发生: 错误号: '.mysql_errno().' : 错误信息: '.mysql_error().'<br>';
    }
    //通过影响行数的函数,判断表是否有变化;
    if(mysql_affected_rows() > 0){
        echo mysql_affected_rows().'行数据有变动, 操作成功<br>';
    }else{
        echo '数据无变动, 操作失败:'.mysql_errno().' : '.mysql_error().'<br>';
    }

    //5.释放资源:
    //释放结果集资源
    mysql_free_result($result);
    //关闭数据库连接,不写参数默认关闭所有;
    mysql_close();