<?php
    header('Content-Type:text/html;charset=utf-8');
    if (isset($_POST['dosubmit'])){
        session_start();
        if( strtoupper($_SESSION['vcode']) == $_POST['vcode']){
            echo "验证码正确";
        } else {
            echo "验证码错误";    
        };
    }

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<style>
    form>*{
        vertical-align: middle;
        margin-bottom: 6px;
    }
</style>
</head>
<body>
    <form method="post">
    用户名: <input type="text" name="username" /> <br>
    密&nbsp;码: <input type="password" name="username" /> <br>
    验证码: <input type="text" name="vcode" onkeyup = "this.value != this.value.toUpperCase()? this.value = this.value.toUpperCase() : void(0)" /> 
            <img src="vcode.php" onclick = "this.src = 'vcode.php?r='+Math.random()"/><br>
            <input type="submit" name="dosubmit" value="登录"/> <br>
    </form>
</body>
</html>

