<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
/* SQL
mysql -h localhost -uroot -proot
SHOW DATABASES;
CREATE DATABASE IF NOT EXISTS test;
USE test;
SHOW TABLES;
CREATE TABLE IF NOT EXISTS
  images(
    id int not null auto_increment primary key, 
    mimetype char(30), 
    data blob
  );
SELECT * FROM images;
*/
  $pdo = new PDO("mysql:host=localhost;dbname=test","root","root");
  // 上传图片
  if(isset($_POST["pic_submit"])){
    try{
      $stmt = $pdo -> prepare("INSERT INTO images(mimetype,data) VALUES(:mimetype,:data)");
      $stmt -> bindParam('mimetype',$_FILES['pic']['type']);
      // 读取文件数据, 可直接读取二进制数据
      $fp = fopen($_FILES['pic']['tmp_name'], 'rb');
      $stmt -> bindParam('data', $fp, PDO::PARAM_LOB); //绑定数据
      $stmt -> execute(); // 执行
      fclose($fp);

      // 手动抛出异常
      $affect_rows = $stmt -> rowCount();
      if($affect_rows){
        echo "图片上传成功<br>";
      }else{
          throw new PDOException("错误: 图片上传失败<br>");
      }
    } catch ( PDOException $e ) {
      print  $e -> getMessage ();
    }
}

  // 读取图片
  $pic_num = "";
  if(isset($_POST["pic_download"])){
    if(isset($_POST["pic_num"])){
      try{
        $pic_num = $_POST["pic_num"];
        $stmt = $pdo -> prepare("SELECT mimetype, data FROM images WHERE id=?");
        $stmt -> bindParam(1, $pic_num);
        $stmt -> execute();
        list($mimetype, $data) = $stmt -> fetch(PDO::FETCH_NUM);
        if(empty($data)){
          throw new PDOException("错误: 读取图片失败!");
        }
        // 输出图片
        header("Content-Type: {$mimetype}");
        echo $data;
        exit;
      } catch ( PDOException $e ) {
        print  $e -> getMessage ();
        exit;
      }
    }
  }
?>
<form action="" method="post" enctype="multipart/form-data">
  上传图片:  <input type="file" name="pic" />
  <input type="submit" name="pic_submit" value="上传图片" />
</form>
<hr>

<form action="" method="post" enctype="multipart/form-data">
  根据ID读取图片: <input type="text" name="pic_num" value="<?php echo $pic_num ?>" />
  <input type="submit" name="pic_download" value="读取图片" />
</form>