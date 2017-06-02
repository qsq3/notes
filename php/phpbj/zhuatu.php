<!doctype html>
<html>
<head>
<title>抓图0.2版</title>
<meta charset="utf-8"/>
<style type="text/css">
    form > *{
        margin-bottom: 6px;
    }
    label{
        display:inline-block;
        width:80px;
    }
    input[type="text"]{
        width : 900px;
    }
</style>
</head>
<body>
<h4>请输入栏目url</h4>
<h4><font color="blue">范例站点：中升机电</font></h4>
<form method="post" class="sub">
<label for="">目标站点: </label><input type="text" name="url"  placeholder="目标站点"/> <br>
<label for="">标题过滤: </label><input type="text" name="titletrim"  value="" placeholder="标题过滤,逗号分隔"/> <br><br>

<label for="">目录列表: </label><input type="radio" checked name="type" value="linklist" placeholder="孙页面抓图"/> <br>
<label for="">目录规则: </label><input type="text" name="linklistReg" placeholder="目录规则"/>  <br>
<br>
<label for="">图组列表: </label><input type="radio" name="type" value="imglist" placeholder="子页面抓图" /> <br>
<label for="">图组规则: </label><input type="text" name="imglistReg"  placeholder="列表规则"/>  <br>
<label for="">下页规则: </label><input type="text" name="nextpageReg" placeholder="图组列表下页规则"/> <br>
<br>
<label for="">图片详情: </label><input type="radio" name="type" value="img" placeholder="当前页面抓图" /> <br>
<label for="">图片规则: </label><input type="text" name="imgReg"  placeholder="图片规则"/> <br>
<label for="">附加提取: </label><input type="text" name="imgtextReg"  placeholder="附加提取规则"/> <br>
<br>
<input type="submit" name="submit" value="开抓" />
</form>
</body>
</html>
<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');

if(isset($_POST['submit']) && isset($_POST['url'])){

    $regArr = array(
        'url' => 'https://wap.koudaitong.com/v2/showcase/homepage?kdt_id=14956514&reft=1470906331148_1470906416162&spm=f43164699_f43164699_t83107639&sf=wx_sm',

        'titletrim' => array("中升管业总批发大"),

        'linklistReg' => '{<a[^>]+?href\=\"(https:\/\/wap\.koudaitong\.com\/v2\/showcase\/tag\?alias=[^\"]+?|https:\/\/wap\.koudaitong\.com\/v2\/tag\/[^\"]+?)\">}',

        'imglistReg' => '{<a[^>]+?href\=\"(https:\/\/wap\.koudaitong\.com\/v2\/goods\/[^\"]+?)\"\s+class\=\"js\-goods\slink\sclearfix\"\starget\=\"\_blank\"}is',

        'nextpageReg' => '{<a[^>]+?href\=\"(https:\/\/wap\.koudaitong\.com\/[^\"]+?)\"[^>]*?>下一页<\/a>}is',
        
        'imgtextReg' => '{<strong[^>]+?class\=\"goods\-current\-price\s+pull\-left\">(.+?)<\/strong>}is',

        'imgReg' => '{<img[^>]+?src\=\"(https:\/\/img\.yzcdn\.cn\/.+?|https:\/\/img\.alicdn\.com\/.+?|https?:\/\/cbu01\.alicdn\.com\/.+?)\"}is',

        'type' => 'linklist'
    );

    foreach($regArr as $key => $val){
        if(isset($_POST[$key]) && !empty($_POST[$key])){
            $regArr[$key] =   $_POST[$key];
            if($key == 'titletrim'){
                $regArr[$key] = explode(',',$_POST[$key]);
            }
        }
    }

    echo "<br><pre>";
    print_r($regArr);
    echo "</pre><br>";
    ?>

    <script>
        
        //滚动
       var gundong = setInterval(function(){document.body.scrollTop = document.body.scrollHeight;
            if(document.getElementById('over')){ clearInterval(gundong); alert("抓取结束");}
        }, 2000);
        
        //补填表单;
        var form = document.getElementsByTagName('form')[0];
        var obj = <?php echo json_encode($regArr); ?> ;        
        for(var key in obj){
            if(key == 'titletrim'){obj[key] = obj[key].join(',')}
            form[key].value = obj[key];
        }
    </script>

    <?php
    //下载图片保存地址，最后要有/
    define('PATH_DOWNLOAD', './download2');
    if(!file_exists(PATH_DOWNLOAD)){
        mkdir(PATH_DOWNLOAD);
    }
    set_time_limit(0);
   // ob_end_clean();
    echo str_pad('', 1024); // 设置足够大，受output_buffering影响

    //验证curl模块
    if(!function_exists('curl_init')){
        exit('<p><font color="red" id="over">执行失败!请先安装curl扩展!</font></p>');
    }
    
    //验证url合法性
    if(!preg_match('/^https?:\/\/[a-zA-Z0-9\-\.]+/i', $regArr['url'])){
        exit('<p><font color="red" id="over">执行失败!URL不合法!</font></p>');
    }

    function getCurl($url){
      
      //初始化curl
      $curl = curl_init($url);
      //curl超时 30s
      curl_setopt($curl, CURLOPT_TIMEOUT, '30');
      //user-agent头
      curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30");
      //返回文件流
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
      //关闭头文件数据流输出
      curl_setopt($curl, CURLOPT_HEADER, 0);
      //禁止服务端验证
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

      //允许重定向,避免302;
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 3); 

      //请求栏目url，并转码
      //$exec = iconv('GBK', 'UTF-8', curl_exec($curl));
      $exec = curl_exec($curl);
      
      //HTTP 状态码
      $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      //耗时
      $totaltime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
      
      curl_close($curl);

      flush();

      return array('exec' => $exec, 'httpStatus'=>$httpStatus, 'totaltime'=> $totaltime);
    }


    function getImg($url,$dir){
      
      //提取图片文件后缀
      $pic_name = basename($url);
      $pic_src = $dir.'/'.$pic_name;
      $pic_srcG = iconv('UTF-8', 'GBK', $pic_src) ;
      $dirG = iconv('UTF-8', 'GBK', $dir) ;
      //如果此图片存在，则不再获取
      if(file_exists($pic_srcG)){
        echo '<li><font color="red">第<font color="blue"><b> ' . $pic_src . ' </b></font>张图片已存在，将跳过此张图片</font></li>';
        flush();
        $error_info = fopen($dirG . 'error.txt', 'ab');
        $time_now = date('Y-m-d H:i:s');
        fwrite($error_info, '抓取 ' . $dir . ' 目录中的第' . $pic_src . '张失败，此图片已存在，时间：' . $time_now . " \r\n");
        fclose($error_info);
        return;
      }
      
      $image_re = getCurl($url)['exec']; 

      if(!$image_re){
        echo '<li><font color="red">下载图片失败，图片地址：' .$url. '将跳过此图片</font></li>';
        flush();
        $error_info = fopen($dir . 'error.txt', 'ab');
        $time_now = date('Y-m-d H:i:s');
        fwrite($error_info, '下载套图中的第' . $pic_src . '失败，时间：' . $time_now . ' \n');
        fclose($error_info);
        return;
      }else{
        //将图片写入本地文件
        $p = file_put_contents($pic_srcG,$image_re);
        if($p){
          echo '<li><font color="green">保存<font color="blue"><b> ' . $pic_src . ' </b></font>图片成功</font>, 字节数: '.$p.'</li>';
        } else {
          echo '<li><font color="red">保存<font color="blue"><b> ' . $pic_src . ' </b></font>图片失败</font>, 字节数: '.$p.'</li>';
          file_put_contents($dir . 'error.txt',"\r\n".'保存' . $pic_src . '图片失败, 字节数:'.$p,FILE_APPEND);
        }
        flush();
      }
    }

    function getList ($url,$dir,$type,$typeReg) {
      global $regArr;

      $re_Arr = getCurl($url);
      $string = $re_Arr['exec'];
      $httpStatus = $re_Arr['httpStatus'];
      $totaltime = $re_Arr['totaltime'];

      //栏目存在就输出栏目名称
      if($httpStatus == 200){
        //获取栏目标题
        preg_match('/<title>(.*?)<\/title>/is' ,$string, $title_result_array);
        $titleA = str_replace($regArr['titletrim'],'',$title_result_array[1]);
        $titleA = preg_replace("{[\\\/\-\r\s\n\'\"\<\>\?\:\*\|]+}",' ',$titleA);
        $titleA = trim($titleA);
        
        echo '<br><br><li><font color="green">进入栏目:<font color="black">'. $titleA . '</font> 网址:(' . $url . ')' .'成功，耗时:'. $totaltime .'s</font></li>';
        flush();

        //建立栏目文件夹，存在的话不用建立
        $dirN = $dir;
        $dir = $dir.'/'.$titleA;
        $dirG = iconv('UTF-8', 'GBK', $dir);
        echo '<li> 目标路径为: <b>'.$dir.'</b> ';
        if(!file_exists($dirG)){
            if(mkdir($dirG)){
              echo '<font color="green">建立文件夹成功</font></li>';
            }else{
              echo '<font color="red" id="over">建立文件夹失败，请检查权限设置</font></li>';
              exit;
            } 
        }else{
            echo '<font color="blue">文件夹已存在</font></li>';
        }
      }else{
        echo '<li><font color="red" id="over">进入栏目:'. $url .'失败，错误码:'. $httpStatus .'</font></li>';
        exit;
      }
        

      //获取图片总套数和页数
      //提取内容
      if(preg_match_all($typeReg, $string, $num_result_array)){
        //替换链接
        //https://wap.koudaitong.com/v2/goods/2olchf4up6e4i
        //http://detail.koudaitong.com/show/goods?alias=2olchf4up6e4i&v2/goods/2olchf4up6e4i
        /*
        if($typeReg == $listReg){
            $num_result_array[1] = preg_replace('{wap\.koudaitong\.com\/v2\/goods\/(.+?)$}i','detail.koudaitong.com/show/goods?alias=$1&v2/goods/$1', $num_result_array[1]);
        }
        */

        /*
        echo "<br>抓取链接为:<br>";
        echo "<pre>";
        print_r($num_result_array[1]);
        echo "</pre>";
        */

        $totalnum = count($num_result_array[1]);
        echo '<li><font color="black">此栏目<font color="blue">'.$titleA.'</font>共有：<font color="blue"><b> ' . $totalnum . ' </b></font>个项目，类型为 <font color="blue"><b>' . $type . '</b></li>';
        flush();
      }else{
        echo '<li><font color="red">获取图片总数和总页数失败，请检查url</font></li>';
        return;
      }

      file_put_contents($dirG.'/details.txt',$titleA."\r\n".$url."\r\n-----------------------------\r\n".implode("\r\n", $num_result_array[1])."\r\n===========================================\r\n",FILE_APPEND);

      //file_put_contents($dirG.'/links.txt',"\r\n".implode("\r\n",$num_result_array[1])."\r\n",FILE_APPEND);

      sleep(1);

      //判断类型递归
      if($type == 'img'){

        if(preg_match($regArr['imgtextReg'], $string, $detail_result_array)){
          file_put_contents($dirG.'/details.txt',"\r\n".$detail_result_array[1],FILE_APPEND);
        }
        for($i = 0; $i < $totalnum; $i++){
        getImg($num_result_array[1][$i],$dir);
        }
      } else if ($type == 'imglist'){
        for($i = 0; $i < $totalnum; $i++){
          getList ($num_result_array[1][$i],$dir,'img',$regArr['imgReg']);
        }

        echo '<br><b><font color="blue" > '.$titleA. ' 本节抓取完成</font></b><br>';

        if(preg_match($regArr['nextpageReg'], $string, $nextpage_result_array)){
          echo '存在下一页是: '.$nextpage_result_array[1];
          getList ($nextpage_result_array[1],$dirN,'imglist',$regArr['imglistReg']);
        } else {
          echo "没有下一页了!";
        }
      } else if ($type == 'linklist'){
        for($i = 0; $i < $totalnum; $i++){
          getList ($num_result_array[1][$i],$dir,'imglist',$regArr['imglistReg']);
        }
      }
    };

getList($regArr['url'], PATH_DOWNLOAD, $regArr['type'], $regArr[$regArr['type'].'Reg']);
echo '<br><center><font size="30" color="red" id="over">全部抓取结束</font></center>';

}

?>
