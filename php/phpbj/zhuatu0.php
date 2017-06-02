<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
if(isset($_POST['submit']) && isset($_POST['url'])){
  //下载图片保存地址，最后要有/
  define('PATH_DOWNLOAD', './download/');
  if(!file_exists(PATH_DOWNLOAD)){
    mkdir(PATH_DOWNLOAD);
  }
  set_time_limit(0);
  ob_end_clean();
  echo str_pad('', 1024); // 设置足够大，受output_buffering影响
  $url = $_POST['url'];
  //验证curl模块
  if(!function_exists('curl_init')){
    echo '<p><font color="red">执行失败!请先安装curl扩展!</font></p>';
    exit();
  }
  //验证url合法性
  if(!preg_match('/^https?:\/\/[a-zA-Z0-9\-\.]+/i', $url)){
    echo '<p><font color="red">执行失败!URL不合法!</font></p>';
    exit();
  }
?>
  <script>
    setInterval(function(){document.body.scrollTop = document.body.scrollHeight;}, 2000);
  </script>
<?php
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
  //请求栏目url，并转码
  $string = iconv('GBK', 'UTF-8', curl_exec($curl));
  //HTTP 状态码
  $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  //耗时
  $totaltime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
  //栏目存在就输出栏目名称
  if($httpStatus == 200){
    //获取栏目标题
    preg_match('/<title>(.*?)<\/title>/i' ,$string, $title_result_array);
    echo '<li><font color="green">进入栏目:<font color="black">'. $title_result_array[1] . '</font>(' . $url . ')' .'成功，耗时:'. $totaltime .'s</font></li>';
    flush();
    //建立栏目文件夹，存在的话不用建立
    if(!file_exists(PATH_DOWNLOAD . iconv('UTF-8', 'GBK', $title_result_array[1]))){
      if(@mkdir(PATH_DOWNLOAD . iconv('UTF-8', 'GBK', $title_result_array[1]))){
	echo '<li><font color="green">建立文件夹：<font color="blue"><b> ' . PATH_DOWNLOAD . $title_result_array[1] . '</b></font> 成功</font></li>';
      }else{
	echo '<li><font color="green">建立文件夹：' . PATH_DOWNLOAD . $title_result_array[1] . '失败，请检查权限设置</font></li>';
	exit;
      } 
    }  
  }else{
    echo '<li><font color="red">进入栏目:'. $url .'失败，错误码:'. $httpStatus .'</font></li>';
    exit();
  }
  //获取图片总套数和页数
  if(preg_match('/<a\s+title="Total\srecord">.*?(\d+).*?<\/a>/i', $string, $num_result_array)){
    $totalnum = $num_result_array[1];
    $totalpage = ceil($totalnum / 36);
    echo '<li><font color="black">此栏目共有：<font color="blue"><b> ' . $totalnum . ' </b></font>套图片，共 <font color="blue"><b>' . $totalpage . '</b></font> 页</font></li>';
    flush();
  }else{
    echo '<li><font color="red">获取图片总数和总页数失败，请检查url</font></li>';
    exit();
  }
  //开始逐页抓取图片
  for($i = 1; $i <= $totalpage; $i++){
    if($i == 1){
      $page_string = $string;  
    }else{
      curl_setopt($curl, CURLOPT_URL, $url . 'index_' . $i . '.html');
      $page_string = curl_exec($curl);
    }
    if(!$page_string){
      echo '<li><font color="red">抓取第<font color="blue"><b> ' . $i . ' </b></font>页套图链接失败，将跳过此页</font></li>';
      flush();
      $error_info = fopen(PATH_DOWNLOAD . 'error.txt', 'ab');
      $time_now = date('Y-m-d H:i:s');
      fwrite($error_info, '抓取第 ' . $i . ' 页套图链接失败，时间：' . $time_now . " \r\n");
      fclose($error_info);
      continue;   
    }
    echo '<li><font color="black">进入第<font color="blue"><b> ' . $i . ' </b></font>页，开始抓取套图链接</font></li>';
    flush();
    $link_all_arr = array();
    //找出本页所有套图链接
    preg_match_all('/<ul\s+class="piclist">.*?<\/ul>/is', $page_string, $link_all_arr);
    $link_no_arr = array();
    //去除精品推荐，提取出剩下套图的链接
    preg_match_all('/<p>.*?(http:\/\/[a-zA-Z0-9\-\.\/]+).*?<\/p>/i', $link_all_arr[0][1], $link_no_arr);
    //本页套图链接
    $link_arr = $link_no_arr[1];
    //本页套图数量
    $link_num = count($link_arr);
    //抓取成功进入每个套图中分别下载图片
    if($link_num > 0){
      echo '<li><font color="green">抓取第<font color="blue"><b> ' . $i . ' </b></font>页套图链接成功，共抓取到<font color="blue"><b> ' . $link_num . ' </b></font>条链接，现在开始进入第<font color="blue"><b> ' . $i . ' </b></font>页进行抓取套图</font></li>';
      flush();
      //循环访问每个套图链接
      //循环次数
      $for_num = 0;
      foreach($link_arr as $value){
	curl_setopt($curl, CURLOPT_URL, $value);
	//获取套图的内容
	$image_all_string = iconv('GBK', 'UTF-8', curl_exec($curl));
	//如果获取失败，则跳过此套图
	if(!$image_all_string){
	  echo '<li><font color="red">抓取套图<font color="blue"><b> ' . $value . ' </b></font>失败，将跳过此套图</font></li>';
	  flush();
	  $error_info = fopen(PATH_DOWNLOAD . 'error.txt', 'ab');
	  $time_now = date('Y-m-d H:i:s');
	  fwrite($error_info, '抓取第 ' . $i . ' 页套图中的' . $value . '失败，时间：' . $time_now . " \r\n");
	  fclose($error_info);
	  continue;
	}
	$for_num++;
	//请求成功则获取请求时间
	$time_out = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
	//套图标题
	preg_match('/<title>(.*?)<\/title>/i', $image_all_string, $title_arr);
	//图片总数
	preg_match('/<div\s+class="pictitle">.*?<p>.*?<i>\d+<\/i>.*?<i>(\d+)<\/i>.*?<\/p><\/div>/is', $image_all_string, $pic_num_arr);
	echo '<li><font color="green">获取套图： <font color="blue"><b>' . $title_arr[1] . ' </b></font>(<a href="' . $value . '" target="_blank">' . $value . '</a>)成功，此套图共： <font color="blue"><b>' . $pic_num_arr[1] . ' </b></font>张图片，耗时：' . $time_out . 's</font></li>';
	flush();
	//建立套图文件夹，如果不存在的话
	if(!file_exists(PATH_DOWNLOAD . iconv('UTF-8', 'GBK', $title_result_array[1]) . '/' . $for_num . iconv('UTF-8', 'GBK', $title_arr[1]))){
	  if(mkdir(PATH_DOWNLOAD . iconv('UTF-8', 'GBK', $title_result_array[1]) . '/' . $for_num . iconv('UTF-8', 'GBK', $title_arr[1]))){
	    echo '<li><font color="green">建立文件夹：<font color="blue"><b> ' . PATH_DOWNLOAD . $title_result_array[1] . '/' . $for_num . $title_arr[1] . '</b></font> 成功</font></li>';
	    flush();
	  }else{
	    echo '<li><font color="red">建立文件夹：' . PATH_DOWNLOAD . $title_result_array[1] . '/' . $title_arr[1] . $for_num . '失败，请检查无权限，将跳过此套图</font></li>';
	    flush();
	    $error_info = fopen(PATH_DOWNLOAD . 'error.txt', 'ab');
	    $time_now = date('Y-m-d H:i:s');
	    fwrite($error_info, '建立第 ' . $i . ' 页套图中的' . $value . '的文件夹失败，时间：' . $time_now . " \r\n");
	    fclose($error_info);
	    continue;
	  }
	}	
	//循环抓取套图的每张图片
	for($i = 1; $i <= $pic_num_arr[1]; $i++){
	  if($i == 1){
	    $a_image_string = $image_all_string;
	  }else{
	    $a_image_link = rtrim($value, '.html') . '_' . $i . '.html';
	    curl_setopt($curl, CURLOPT_URL, $a_image_link);
	    $a_image_string = iconv('GBK', 'UTF-8', curl_exec($curl));
	  }
	  if(!$a_image_string){
	    echo '<li><font color="red">抓取套图的第<font color="blue"><b> ' . $i . ' </b></font>张图片失败，将跳过此张图片</font></li>';
	    flush();
	    $error_info = fopen(PATH_DOWNLOAD . 'error.txt', 'a');
	    $time_now = date('Y-m-d H:i:s');
	    fwrite($error_info, "抓取 {$title_arr[1]} 套图中的第 {$i} 张图片失败，时间：{$time_now}\r\n");
	    fclose($error_info);
	    continue;
	  }
	  echo '<li><font color="black">进入此套图的第<font color="blue"><b> ' . $i . ' </b></font>张图片页面成功，开始下载第<font color="blue"><b> ' . $i . ' </b></font>张图片...</font></li>';
	  flush();
	  //抓取图片地址
	  preg_match('/<div\s+class="bigpic">.*?src="(.*?)".*?<\/div>/i', $a_image_string, $pic_link);
	  //提取图片文件后缀
	  $pic_suffix_arr = explode('.', $pic_link[1]);
	  $pic_suffix = $pic_suffix_arr[count($pic_suffix_arr) - 1];
	  //如果此图片存在，则不再获取
	  if(file_exists(PATH_DOWNLOAD . iconv('UTF-8', 'GBK', $title_result_array[1]) . '/' . $for_num . iconv('UTF-8', 'GBK', $title_arr[1]) . '/' . iconv('UTF-8', 'GBK', $title_arr[1]) . '_' . $i . '.' . $pic_suffix)){
	    echo '<li><font color="red">第<font color="blue"><b> ' . $i . ' </b></font>张图片已存在，将跳过此张图片</font></li>';
	    flush();
	    $error_info = fopen(PATH_DOWNLOAD . 'error.txt', 'ab');
	    $time_now = date('Y-m-d H:i:s');
	    fwrite($error_info, '抓取 ' . $title_arr[1] . ' 套图中的第' . $i . '张失败，此图片已存在，时间：' . $time_now . " \r\n");
	    fclose($error_info);
	    continue;
	  }
	  curl_setopt($curl, CURLOPT_URL, 'http://tuku.famimi.com' . $pic_link[1]);
	  $image_re = curl_exec($curl); 
	  if(!$image_re){
	    echo '<li><font color="red">下载图片失败，图片地址：http://tuku.famimi.com' . $pic_link[1] . '将跳过此图片</font></li>';
	    flush();
	    $error_info = fopen(PATH_DOWNLOAD . 'error.txt', 'ab');
	    $time_now = date('Y-m-d H:i:s');
	    fwrite($error_info, '下载 ' . $title_arr[1] . ' 套图中的第' . $i . '失败，时间：' . $time_now . ' \n');
	    fclose($error_info);
	    continue;
	  }else{
	    //将图片写入本地文件
	    $picfile = fopen(PATH_DOWNLOAD . iconv('UTF-8', 'GBK', $title_result_array[1]) . '/' . $for_num . iconv('UTF-8', 'GBK', $title_arr[1]) . '/' . iconv('UTF-8', 'GBK', $title_arr[1]) . '_' . $i . '.' . $pic_suffix, 'wb');
	    if(!fwrite($picfile, $image_re)){
	      echo '<li><font color="red">保存图片失败，将跳过此图片</font></li>';
	      flush();
	      $error_info = fopen(PATH_DOWNLOAD . 'error.txt', 'ab');
	      $time_now = date('Y-m-d H:i:s');
	      fwrite($error_info, '保存 ' . $title_arr[1] . ' 套图中的第' . $i . '失败，时间：' . $time_now . " \r\n");
	      fclose($error_info);
	      continue;
	    }
	    fclose($picfile);
	    echo '<li><font color="green">保存第<font color="blue"><b> ' . $i . ' </b></font>张图片成功</font></li>';
	    flush();
	  }
	}
      }
    //抓取失败则跳过此页
    }else{
      echo '<li><font color="red">抓取第<font color="blue"><b> ' . $i . ' </b></font>页套图链接失败，将跳过此页</font></li>';
      flush();
      $error_info = fopen(PATH_DOWNLOAD . 'error.txt', 'ab');
      $time_now = date('Y-m-d H:i:s');
      fwrite($error_info, '抓取第 ' . $i . ' 页套图链接失败，将跳过此页，时间：' . $time_now . " \r\n");
      fclose($error_info);
      continue;
    }    
  }
  curl_close($curl);
}
?>

<html>
<head>
</head>
<body>
<h4>请输入栏目url</h4>
<h4><font color="blue">目标站：http://tuku.famimi.com/</font></h4>
<form method="post">
<input type="text" name="url" size="40" /> <input type="submit" name="submit" value="开抓" />
</form>
</body>
</html>