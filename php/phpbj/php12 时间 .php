<?php
    时间戳: 整数; 1970年到现在的秒数(和JS不同) 
    日期  date(); 默认0时区 ,php.ini 中 date.timezone = Etc/GMT+8 更改;代码更改  date_default_timezone_set()  
    mktime — 取得一个日期的 Unix 时间戳 
    time - 返回自从 Unix 纪元（格林威治时间 1970 年 1 月 1 日 00:00:00）到当前时间的秒数。 
    microtime — 返回当前 Unix 时间戳和微秒数  microtime(true);
<?php
    header("Content-Type: text/html; charset=utf-8");
    
    $t = time()-60*60*24*7;
    //date_default_timezone_set( 'Asia/Hong_Kong' ) ;
    //date_default_timezone_set( 'PRC' ) ;
    echo date("Y-m-d H:i:s T",time()).'<br>';
    echo date("Y年m月d日 H:i:s",$t).'<br>';

    $y = 1982;
    $d = 5;
    $m = 1;
    $t = mktime(0, 0, 0, $m, $d, $y);
    $nianlin = floor((time() - $t;)/(24*60*60));
    echo $nianlin.'<br>';

    echo strtotime('2016-08-15 10:36:20').'<br>';


eg: 日历:
<?php
    header("Content-Type: text/html; charset=utf-8");

    $year = isset($_GET['year'])? $_GET['year'] : date('Y');
    $month = isset($_GET['month'])? $_GET['month'] : date('m');
    $day = isset($_GET['day'])? $_GET['day'] : date('d');
    
    //当月天数
    $days= date('t',mktime(0,0,0,$month,$day,$year));
    
    //获取当月第一天是星期几
    $firstday= date('w',mktime(0,0,0,$month,1,$year));


    echo '<table border="1" width="300" align="center" cellspacing="0" cellpadding="0">';
    echo "<caption align='center' style='border:2px solid #000;line-height:30px;font-weight:bold'>{$year}年{$month}月</caption>";
    echo '<tr>';
    echo '<th style="background:#eee">日</th>';
    echo '<th style="background:#eee">一</th>';
    echo '<th style="background:#eee">二</th>';
    echo '<th style="background:#eee">三</th>';
    echo '<th style="background:#eee">四</th>';
    echo '<th style="background:#eee">五</th>';
    echo '<th style="background:#eee">六</th>';
    echo '</tr>';
    
    echo '<tr>';
    for($i=0;$i<$firstday;$i++){
        echo '<td></td>';
    }

    for($j=1;$j<=$days;$j++){
        $i++;
        if($j ==$day){
            echo "<td style='background:red'>{$j}</td>";
        } else {
            echo "<td>{$j}</td>";
        }
        if($i%7 == 0){
            echo '</tr><tr>';
        }
    }
    
    while($i%7 != 0){
        echo '<td></td>';
        $i++;
    }
    echo '</tr>';
    echo '</table>';

