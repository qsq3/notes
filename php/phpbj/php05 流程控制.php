<?php
流程控制:
    顺序结构:
    分支结构:
    循环结构:

    分支结构:
        1. 单一条件(if)
        2. 双向条件(else 从句)
        3. 多向条件(elseif 字句; switch 语句)
        4. 巢状条件
        
    一. 单路和双向 : 
    二. 多路分支中只能进入一个条件;
    if(bool)单条;
    
    if(bool){
        多条
    }else if (bool){
            
    }elseif (bool){
    
    }else{
    
    }
    //需注意switch case 比较时用的是全等===, 变量$a 类型应为: 整型,字符串, 或布尔;同一语句匹配多个值时,可省略break;
    switch($a){
        case $b :  
            语句;
            break;
        case $c :  
            语句;
            break;
        default:
            语句;
            break;
    }

PHP接受客户端的两种方式:
    URL :  get  : // http://localhost/a.php?name=zhangsan&age=10&sex=5; //地址链接之类通过url传;
    HTTP:  post : // 表单传数据,通过PHP配置文件的一个属性决定大小;最大不要超过服务器内存;一般文件上传通过post上传;

    9个 超全局数组:
      1. $_GET;
      2. $_POST;

简单计算器:
eg: 
<?php
    error_reporting(E_ALL & ~NOTICE);
    var_dump($_GET);
    echo '<br/>';
    var_dump($_POST['num1']);
    echo '<br/>';
    var_dump($_POST);
    echo '<hr/>';
    
   
    $flag = true;
    $errormessage = '错误信息提示: ';
    if(!isset($_POST['submit'])){
        $errormessage .= '用户是在刷新页面';
        $flag = false;
    } else if ( ($_POST['num1'] == '') || ($_POST['num2'] == '') ){
        $errormessage .= '输入不能为空';
        $flag = false;
    } else if ( !is_numeric($_POST['num1']) || !is_numeric($_POST['num2']) ){
        $errormessage .= '必须输入数字'.$_POST['num1'].$_POST['num2'];
        $flag = false;
    } else {
        switch($_POST[operator]){
            case '+' : $result = $_POST[num1] + $_POST[num2]; break;
            case '-' : $result = $_POST[num1] - $_POST[num2]; break;
            case 'x' : $result = $_POST[num1] * $_POST[num2]; break;
            case '÷' : $result = $_POST[num1] / $_POST[num2]; break;
            default : $result = '错误的输入'; break;
        }
    }
?>
<div class='container'>
    <div class="title">简单计算器PHP版</div>
    <form action="client.php" method='post'>
        <input type="text" name='num1' size='10'/>
        <select name="operator" id="">
            <option <?php echo $_POST['operator'] == '+' ? 'selected' : '' ?> value="+"> + </option>
            <option <?php if($_POST['operator'] == '-') echo 'selected'; ?> value="-"> - </option>
            <option <?php if($_POST['operator'] == 'x') echo 'selected'; ?> value="x"> x </option>
            <option <?php if($_POST['operator'] == '÷') echo 'selected'; ?> value="÷"> ÷ </option>
        </select>
        <input type="text" name='num2' size='10'/>
        <input type="submit" class="submit" name='submit' value='提交'/>
    </form>
    <div  class="result">
        <?php
            if($flag)
            echo "{$_POST[num1]} {$_POST[operator]} {$_POST[num2]} 的结果是:  {$result}";
            else
            echo $errormessage;
        ?>
    </div>
</div>

循环结构:
    while(){} 条件循环
    do{}while(); 注意: 后面必须加分号;
    for(;;){} 计数循环
    goto  : 5.2没有,5.3+有;
    特殊流程控制语句

    控制循环 : 
    continue 2; 用在  while  do while for 语句中, 用于跳过当前一次循环;
    break 3; 用在 switch while  do while for 语句中, 用于退出当前循环结构;
        php中,break 和continue后可以接数字表示退出几层循环;
    exit; exit('可以输出文本'); 退出当前脚本 ,die()就是exit()的一个别名; 注意 , exit后面即使 html 代码也不会被加载
    return 1; 返回一个值;
    goto ; 不能用 break 跳出;

eg:     
    echo '111';

    goto bj;

    echo '222';

    //标记
    bj: {
        echo '333';
    }


eg:
    $i = 0;
    for(;;){
        if($i>10){break;}
        echo $i;
        $i++;
    }

    for($i=0,$j=10;$i<10 || $j>0 ;$i++,$j--){
        echo "$i $j";
        $i++;
        $j--;
    }