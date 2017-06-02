<?php
    header('Content-Type:text/html;charset=utf-8');
    date_default_timezone_set('PRC');
    include './page.class.php';
    
    @$link = mysql_connect('localhost', 'root', 'root');

    mysql_select_db('test');

    $result = mysql_query('SELECT * FROM users');
    
    $num = 10;
    $rows = mysql_num_rows($result);
    $cols = mysql_num_fields($result);

    echo '<table align="center" width="800" border="1" >';
    echo '<caption><h2>'.'表名'.'</h2></caption>';

    echo '<tr>';
    for($i=0; $i<$cols; $i++){
        echo '<th>'.mysql_field_name($result , $i).'</th>';
    }
    echo '</tr>';
    //echo $rows;
    $page = new Page($rows, $num, 'pid=66');
    $sql = "SELECT * FROM users {$page->limit}";
    $result = mysql_query($sql);

    while ($row = mysql_fetch_assoc($result) ){
        echo '<tr>';
        foreach($row as $key){
            echo '<td>'.$key.'</td>';
        }
        echo '</tr>';
    };
    
    echo "<tr><td colspan={$cols} align='right'>".$page->fpage(array(0,3,4,9,8)).'</td></tr>';
    echo '</table>';
    
    mysql_free_result($result);
    mysql_close();