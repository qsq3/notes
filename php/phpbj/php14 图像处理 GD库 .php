<?php
图形处理
    GD库的使用: 画图 与 改图
    JPEG : 是一种压缩标准, 通常用来储存照片和丰富色彩和层次的图片, 有损压缩.
    PNG : 可移植网络图像, 无损压缩.
    GIF : 原义是"图像互换格式", 基于LZW算法的连续色调的 无损压缩格式.

一.画图:
<?php
 
    //1. 创建画布(背景),设置大小
    $img = imagecreatetruecolor(400,400) or die( '无法创建 GD库 图像文件' );

    //2. 制作各种颜色
    $white  =  imagecolorallocate ( $img ,  0xff ,  0xff ,  0xff );
    $blue  =  imagecolorallocate ( $img ,  122 ,  233 ,  255 );
    $red  =  imagecolorallocate ( $img ,  255 ,  0 ,  0 );
    $orange  =  imagecolorallocate ( $img ,  0xff ,  0x66 ,  0 );
    $pink  =  imagecolorallocate ( $img ,  0xff ,  0 ,  0xff );
    $black  =  imagecolorallocate ( $img ,  0 ,  0 ,  0 );

    //3. 画出各种图形和文字
    
    //填充颜色
    imagefill($img, 0, 0, $white); //区域填充, 整个画布
    imagesetpixel ($img,50,50,$red); //画点
    imageline($img,200,0,0,200,$blue); //画线
    imagerectangle($img,80,10,150,80,$pink);  //画矩形
    imagefilledrectangle ($img,100,20,130,50,$orange); //画矩形并填充
    imageellipse($img,50,100,150,80,$pink); //画一个椭圆
    imagefilledellipse($img,50,100,30,30,$red);//画一椭圆并填充
    imagefilledarc($img,120,120,30,90,0,245,$blue,IMG_ARC_PIE );//画一椭圆弧且填充
    
    imagestring($img,2, 200,20,'AAA',$red); //水平地画一行字符串
    imagestringup($img,5, 200,100,'BBB',$blue); //垂直地画一行字符串
    imagechar($img,4, 230,50,'C',$black);//水平地画一个字符
    imagecharup($img,4, 230,80,'D',$black); //垂直地画一个字符
    
    imagettftext($img, 30.8, 45, 100,240,$orange,  'C:\Windows\Fonts\msyhbd.ttf' , '你好AKfs234'); //用 TrueType 字体向图像写入文本


    //4. 保存或输出给浏览器
    //imagepng($img, './test.png'); //保存
    header('Content-type:images/jpeg;');
    imagejpeg($img); //输出

    //5. 释放资源
    imagedestroy($img);
?>


<?php
//制作时钟
    header('Content-Type:text/html;charset=utf-8');
    date_default_timezone_set('PRC');
    
    $h = date("H");
    $i = date("i");
    $s = date("s");

    $img = imagecreatetruecolor(400,400) or die( '无法创建 GD库 图像文件' );

    //2. 制作各种颜色
    $white  =  imagecolorallocate ( $img ,  0xff ,  0xff ,  0xff );
    $blue  =  imagecolorallocate ( $img ,  122 ,  233 ,  255 );
    $blue_d  =  imagecolorallocate ( $img ,  0 ,  0 ,  255 );
    $red  =  imagecolorallocate ( $img ,  255 ,  0 ,  0 );
    $orange  =  imagecolorallocate ( $img ,  0xff ,  0x66 ,  0 );
    $pink  =  imagecolorallocate ( $img ,  0xff ,  0 ,  0xff );
    $black  =  imagecolorallocate ( $img ,  0 ,  0 ,  0 );

    imagefill($img, 0, 0, $white); //区域填充, 整个画布
    
    imagestring($img,5, 20,20,"Now:{$h}:{$i}:{$s}",$red);
    imageellipse($img,200,200,300,300,$blue); //画一个椭圆
    
    //刻度
    imagestring($img,5, 192,65,"12",$blue_d);
    imagestring($img,5, 196,320,"6",$blue_d);
    imagestring($img,5, 66,192,"9",$blue_d);
    imagestring($img,5, 327,192,"3",$blue_d);
    

    $lenA = 144;
    $lenB = 6;
    for($k=0; $k<60; $k++){
        if($k%15 == 0){
            imagesetthickness ( $img ,  3 ); //设置宽度
            $lenA = 140;
            $lenB = 10;
        } else {
            imagesetthickness ( $img ,  1 ); //设置宽度
            $lenA = 144;
            $lenB = 6;
        }
        
        $a= $lenA * sin(pi()/180*6*$k);
        $b= $lenA * cos(pi()/180*6*$k);
        $x1 = 200 + $a;
        $y1 = 200 - $b;
        
        $a= $lenB * sin(pi()/180*6*$k);
        $b= $lenB * cos(pi()/180*6*$k);
        $x2 = $x1 + $a;
        $y2 = $y1 - $b;

        imageline($img,$x1,$y1,$x2,$y2,$blue);
    }

    //秒针
    $len = 110;
    $a= $len * sin(pi()/180*6*$s);
    $b= $len * cos(pi()/180*6*$s);
    $x = 200 + $a;
    $y = 200 - $b;
    imageline($img,200,200,$x,$y,$pink);

    //分针
    $len = 90;
    $a= $len * sin(pi()/180*6*$i);
    $b= $len * cos(pi()/180*6*$i);
    $x = 200 + $a;
    $y = 200 - $b;

    imagesetthickness ( $img ,  3 ); //设置宽度
    imageline($img,200,200,$x,$y,$orange);

    //时针
    $len = 60;
    $a= $len * sin(pi()/180*6*$h);
    $b= $len * cos(pi()/180*6*$h);
    $x = 200 + $a;
    $y = 200 - $b;
    imagesetthickness ( $img ,  5 );
    imageline($img,200,200,$x,$y,$red);
    
    imagefilledellipse($img,200,200,10,10,$blue);//画中心圆并填充

    imagepng($img);

    //5. 释放资源
    imagedestroy($img);
    
    echo '<br><img id="clock" src="./test.php"/>';
?>
<script>
    var clock = document.getElementById("clock");
    setInterval(function(){
        var d = new Date();
        clock.src="./test.php?"+ d.getTime()+ Math.random();
    },1000)
</script>


二. 图片处理
<?php
1.图片背景管理
    imagecreatefromgif — 由文件或 URL 创建一个新图象。
    imagecreatefromjpeg — 由文件或 URL 创建一个新图象。
    imagecreatefrompng — 由文件或 URL 创建一个新图象。

    imagesx — 取得图像宽度
    imagesy — 取得图像高度
    getimagesize — 取得图像大小  eg: list($width, $height, $type) = getimagesize("url");
    getimagesizefromstring — 从字符串中获取图像尺寸信息

2.  图像的缩放和剪切
imagecopyresampled — 重采样拷贝部分图像并调整大小
bool imagecopyresampled  ( resource $dst_image  , resource $src_image  , int $dst_x  , int $dst_y  , int $src_x  , int $src_y  , int $dst_w  , int $dst_h  , int $src_w  , int $src_h  )
imagecopyresized() - 拷贝部分图像并调整大小 

<?php
    header('Content-Type:text/html;charset=utf-8');
    date_default_timezone_set('PRC');

//图像等比例缩放 ,类似 background-size: contain;
    function thumb($imgname, $dst_w, $dst_h){

        //获取原图参数
        list($src_w, $src_h, $type) = getimagesize($imgname);
        //变量函数
        $types = array(1=>'gif', 2=>'jpeg', 3=>'png');
        $createimage = 'imagecreatefrom'.$types[$type];
        //调整缩放的比例
        $src_r  =  $src_w / $src_h ;
        $dst_w/$dst_h > $src_r ? $dst_w = $dst_h * $src_r :  $dst_h = $dst_w / $src_r ;
        //原图片
        $src_image = $createimage($imgname);
        //目标图片
        $dst_image = imagecreatetruecolor($dst_w, $dst_h) or die( '无法创建 GD库 图像文件' ); 
        //缩放
        imagecopyresampled  ( $dst_image  , $src_image  , 0  , 0 , 0  , 0  , $dst_w  , $dst_h  , $src_w  , $src_h  );
        //保存新图片
        $save = 'image'.$types[$type];
        $save($dst_image, 'new_'.$imgname);
        //销毁图片资源
        imagedestroy($src_image);
        imagedestroy($dst_image);
    }
    
    thumb( 'ad1.jpg',50,50);
    thumb( 'ad2.gif',50,50);
    thumb( 'ad3.png',50,50);

//图像剪切
    function cut($imgname, $x, $y, $dst_w, $dst_h){
        
        //获取原图参数
        list($src_w, $src_h, $type) = getimagesize($imgname);
        //变量函数
        $types = array(1=>'gif', 2=>'jpeg', 3=>'png');
        $createimage = 'imagecreatefrom'.$types[$type];
        //原图片资源
        $src_image = $createimage($imgname);
        //目标图片资源
        $dst_image = imagecreatetruecolor($dst_w, $dst_h) or die( '无法创建 GD库 图像文件' ); 
        //进行剪切
        imagecopyresampled  ( $dst_image, $src_image, 0 , 0, $x, $y, $dst_w, $dst_h, $dst_w, $dst_h);
        //保存新图片
        $save = 'image'.$types[$type];
        $save($dst_image, 'new_'.$imgname);
        //销毁图片资源
        imagedestroy($src_image);
        imagedestroy($dst_image);
    }
    
    cut( 'ad1.jpg', 60, 10, 50,50);
    cut( 'ad2.gif', 60, 10, 50,50);
    cut( 'ad3.png', 60, 10, 50,50);

//缩放并剪切居中,类似 background-size: cover;
    function thumbcut($imgname, $dst_w, $dst_h){
        
        //获取原图参数
        list($src_w, $src_h, $type) = getimagesize($imgname);
        //变量函数
        $types = array(1=>'gif', 2=>'jpeg', 3=>'png');
        $createimage = 'imagecreatefrom'.$types[$type];

        //调整缩放的比例,取最大值
        $dst_w2 = $dst_w;
        $dst_h2 = $dst_h;
        $src_r  =  $src_w / $src_h ;
        $dst_w/$dst_h < $src_r ? $dst_w2 = $dst_h * $src_r :  $dst_h2 = $dst_w / $src_r ;

        //原图片
        $src_image = $createimage($imgname);
        //目标图片
        $dst_image = imagecreatetruecolor($dst_w, $dst_h) or die( '无法创建 GD库 图像文件' ); 
        //过度图片
        $dst_image2 = imagecreatetruecolor($dst_w2, $dst_h2) or die( '无法创建 GD库 图像文件' ); 

        //缩放
        imagecopyresampled  ($dst_image2, $src_image, 0, 0, 0, 0, $dst_w2, $dst_h2, $src_w, $src_h);

        //剪切
        imagecopyresampled($dst_image, $dst_image2, 0, 0, ($dst_w2-$dst_w)/2, ($dst_h2-$dst_h)/2, $dst_w, $dst_h, $dst_w, $dst_h);

        //保存新图片
        $save = 'image'.$types[$type];
        $save($dst_image, 'new_'.$imgname);
        //销毁图片资源
        imagedestroy($src_image);
        imagedestroy($dst_image);
        imagedestroy($dst_image2);
    }
    
    thumbcut( 'ad1.jpg', 50,50);
    thumbcut( 'ad2.gif', 50,50);
    thumbcut( 'ad3.png', 50,50);

//文字水印
    function watermark($imgname, $string){
        
        //获取原图参数
        list($src_w, $src_h, $type) = getimagesize($imgname);
        //变量函数
        $types = array(1=>'gif', 2=>'jpeg', 3=>'png');
        $createimage = 'imagecreatefrom'.$types[$type];
        //原图片
        $src_image = $createimage($imgname);

        $white = imagecolorallocate  ($src_image, 200, 200, 200);
        $green = imagecolorallocate  ($src_image, 0, 200, 0);

        $x = rand(3,$src_w - strlen($string)*imagefontwidth(5) - 3);
        $y = rand(3,$src_h - imagefontheight(5) - 3);

        imagestring($src_image, 5, $x, $y, $string, $white);
        imagestring($src_image, 5, $x+1, $y+1, $string, $green);

        //保存新图片
        $save = 'image'.$types[$type];
        $save($src_image, 'new_'.$imgname);
        //销毁图片资源
        imagedestroy($src_image);
    }
    
    watermark( 'ad1.jpg', "1111");
    watermark( 'ad2.gif', "2222");
    watermark( 'ad3.png', "3333");

//图片水印
    function watermark($imgname, $watername){
        
        //获取原图参数
        list($src_w, $src_h, $type) = getimagesize($imgname);
        //获取水印图参数
        list($water_w, $water_h, $water_type) = getimagesize($watername);
        //变量函数
        $types = array(1=>'gif', 2=>'jpeg', 3=>'png');
        $createimage = 'imagecreatefrom'.$types[$type];
        $createwater = 'imagecreatefrom'.$types[$water_type];
        //原图片
        $src_image = $createimage($imgname);
        $water_image = $createwater($watername);

        $x = rand(3,$src_w - $water_w - 3);
        $y = rand(3,$src_h - $water_h - 3);

        imagecopy($src_image, $water_image, $x, $y, 0, 0, $water_w, $water_h);

        //保存新图片
        $save = 'image'.$types[$type];
        $save($src_image, 'new_'.$imgname);

        //销毁图片资源
        imagedestroy($src_image);
        imagedestroy($water_image);
    }
    
    watermark( 'ad1.jpg', "logo.png");
    watermark( 'ad2.gif', "logo.png");
    watermark( 'ad3.png', "logo.png");

//旋转
    function rotate($imgname, $angle){
        
        //获取原图参数
        list($src_w, $src_h, $type) = getimagesize($imgname);
        //变量函数
        $types = array(1=>'gif', 2=>'jpeg', 3=>'png');
        $createimage = 'imagecreatefrom'.$types[$type];
        //原图片
        $src_image = $createimage($imgname);
        //旋转
        $dst_image = imagerotate ($src_image, $angle, 0);

        //保存新图片的变量函数
        $save = 'image'.$types[$type];
        $save($dst_image, 'new_'.$imgname);
        //销毁图片资源
        imagedestroy($src_image);
        imagedestroy($dst_image);
    }
    
    rotate( 'ad1.jpg', 30);
    rotate( 'ad2.gif', 30);
    rotate( 'ad3.png', 30);

//翻转
    function turn($imgname, $turn_type = 'x'){
        
        //获取原图参数
        list($src_w, $src_h, $type) = getimagesize($imgname);
        //变量函数
        $types = array(1=>'gif', 2=>'jpeg', 3=>'png');
        $createimage = 'imagecreatefrom'.$types[$type];
        //原图片
        $src_image = $createimage($imgname);
        $dst_image = $createimage($imgname);

        //变量
        $dst_x = $dst_y = $src_x = $src_y = 0;
        $width = $src_w;
        $height = $src_h;
        switch($turn_type){
            case 'x':
                $num = $src_w;
                $width = 1;
                break;
            case 'y':
                $num = $src_h;
                $height = 1;
                break;
        }
        //可变变量
        $dst_t = 'dst_'.$turn_type;
        $src_t = 'src_'.$turn_type;
        //翻转
        for($i=0; $i<$num; $i++){ 
            $$dst_t = $i;
            $$src_t = $num - $i;
            imagecopyresampled  ( $dst_image, $src_image, $dst_x , $dst_y, $src_x, $src_y, $width, $height, $width, $height);
        }

        //保存新图片的变量函数
        $save = 'image'.$types[$type];
        $save($dst_image, 'new_'.$imgname);
        //销毁图片资源
        imagedestroy($src_image);
        imagedestroy($dst_image);
    }
    
    turn( 'ad1.jpg', 'x');
    turn( 'ad2.gif', 'y');
    turn( 'ad3.png', 'y');