<?php
    $filename = "message.txt";
    //如果用户提交就写入文件 
    if(isset($_POST['dosubmit'])){
        //字段分割 ||, 行分割 [n]
        $message = "{$_POST['username']}||".time()."||{$_POST['title']}||{$_POST['content']}[n]";
        writemessage($filename,$message);
    }
    
    function writemessage($filename,$message){
        $fp = fopen($filename,'a');
        if(flock($fp, LOCK_EX+LOCK_NB)){
        fwrite($fp,$message); 
        flock($fp, LOCK_UN+LOCK_NB);
        } else {
            echo '写入锁定失败!';
        }
        fclose($fp);
    }
    
    if(file_exists($filename)){
        readmessage($filename);
    }
    
    function readmessage($filename){
    //    $message = file_get_contents($filename);
        $fp = fopen($filename,'r');
        if(flock($fp, LOCK_SH+LOCK_NB)){
            //$message = fread($fp, filesize($filename));
            $message = '';
            while(!feof($fp)){
                $message.=fread($fp, 1024);
            }
            flock($fp, LOCK_UN+LOCK_NB);
            $message = rtrim($message,'[n]');
            $arrmess = explode('[n]',$message);
            foreach($arrmess as $m){
                list($username,$time,$title,$content) = explode('||',$m);
                echo "<b>{$username}:</b> ".date("Y-m-d H:i:s",$time)." <i>{$title}</i> <u>{$content}</u><br><hr><br>";
            }
        } else {
            echo "文件读取锁定失败!";
        }
        fclose($fp);
    }

?>
<!doctype html>
<head>
    <meta charset='utf-8' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>简单留言板</title>
    <style type="text/css">
        li{
            list-style:none;
            margin-bottom:10px;
        }
        li>*{
            vertical-align:middle;
        }
    </style>
</head>
<body>
    <form action="message.php" method="post">
        <ul>
            <li><label for="username">用户: </label><input type="text" name="username" id="username" value="" placeholder="请输入用户名"/></li>
            <li><label for="title">标题: </label><input type="text" name="title" id="title" value="" placeholder="请输入标题"/></li>
            <li><label for="content">内容: </label><textarea cols="40" rows="4" name="content" id="content" value="" placeholder="请输入留言信息"/></textarea></li>
            <li> <input type="submit" name="dosubmit" value="提交留言" /></li>
        </ul>
    </form>

</body>


//eg: 上传文件:
<?php
    header("Content-Type:text/html;charset=utf-8");

if(isset($_POST['dosubmit'])){
    echo '<pre>';
    print_r($_POST);
    print_r($_FILES);
    echo '</pre>';


//多文件处理
$num = count($_FILES['pic']['name']);
for($i=0; $i<$num; $i++){
    //第一步: 判断错误
    if($_FILES['pic']['error'][$i]>0){
        switch($_FILES['pic']['error'][$i]){
            case 1: echo "上传文件超过了 php.ini 中 upload_max_filesize 选项限制的值" ; break;
            case 2: echo "上传文件超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值" ; break;
            case 3: echo "文件只有部分被上传" ; break;
            case 4: echo "没有文件被上传" ; break;
            case 6: echo "找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进。" ; break;
            case 7: echo "文件写入失败。PHP 5.1.0 引进" ; break;
            default: echo "未知错误"; break;
        }
        echo "<br>";
        continue;
    }

    //第二步 判断类型
    $hzarr = explode('.', basename($_FILES['pic']['name'][$i]));
    $hz = array_pop($hzarr );
    $allowtype = array('jpg','jpeg','png','gif'); 
    if(!in_array($hz,$allowtype)){
        echo('文件类型必须为图片<br>');
        continue;
    }
    //第三步 判断大小
    $messize = 1000000;
    if($_FILES['pic']['size'][$i] > $messize){
        echo("文件大小超出{messize}字节");
        continue;
    }

    //第四步 上传后的文件名一定要设置随机
    $tmpfile = $_FILES['pic']['tmp_name'][$i];
    $srcname = './uploads/'.date("YmdHis").rand(100,999).'.'.$hz;

    //将临时目录下的上传文件, 复制到指定目录下
    if(move_uploaded_file($tmpfile, $srcname)){
        echo "{$_FILES['pic']['name'][$i]}上传成功<br>";
    }else{
        echo "{$_FILES['pic']['name'][$i]}上传失败<br>";
    }
}

}
?>

<form action="upload.php" method="post" enctype="multipart/form-data">
    用户名: <input type="text" name="username" value="" /><br>
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> <!--仅仅是提示,写在文件上传上面-->
    上传头像: <input type="file" name="pic[]" value="" multiple=/><br>
    <input type="submit" name="dosubmit" value="上传" /><br>

</form>