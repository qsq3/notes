<?php
文件操作:
    文件和目录
    文件类型:
    window下只有 dir file 和 unknown
    unix下有  dir file block char fifo link 和 unknown
    filetype() 获取文件类型;
    is_dir — 判断给定文件名是否是一个目录
    is_executable — 判断给定文件名是否可执行
    is_file — 判断给定文件名是否为一个正常的文件
    is_link — 判断给定文件名是否为一个符号连接
    is_readable — 判断给定文件名是否可读
    is_uploaded_file — 判断文件是否是通过 HTTP POST 上传的
    is_writable — 判断给定的文件名是否可写
    is_writeable — is_writable 的别名

文件的属性:
<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
    function getFilePro($filename){
        if(file_exists($filename)){
            echo '文件存在<br>';
            
            //获取文件类型 ,大小
            echo filetype($filename).'<br>';
            if(is_dir($filename)){
                echo '文件类型为: dir<br>';
            }else if(is_file($filename)){
                echo '文件类型为: file<br>';
                echo '文件大小为: '.tosize(filesize($filename)).'<br>';            
            }
            
            //获取文件权限
            $du = is_readable($filename)? '可' : '不可';
            $xie = is_writable($filename)? '可' : '不可';
            $zx = is_executable($filename)? '可' : '不可';

            echo "文件{$du}写<br>文件{$xie}写<br>文件{$zx}执行<br>";

            //创建时间
            echo '文件创建时间:'.date("Y年m月d日 H:i:s",filectime($filename)).'<br>';
            //修改时间
            echo '文件修改时间:'.date("Y年m月d日 H:i:s",filemtime($filename)).'<br>';
            //访问时间
            echo '文件访问时间:'.date("Y年m月d日 H:i:s",fileatime($filename)).'<br>';
        }else{
            echo '文件不存在';
        }
    }
    getFilePro("./test.php");

    function tosize($size){
        $s = $size;
        $dw = '';
        if($s>=pow(2,40)){
           $s = $size/pow(2,40); 
           $dw = "TB";
        } else if ($s>=pow(2,30)){
           $s = $size/pow(2,30);
           $dw = "GB";
        } else if ($s>=pow(2,20)){
           $s = $size/pow(2,20);
           $dw = "MB";
        } else if ($s>=pow(2,10)){
           $s = $size/pow(2,10);
           $dw = "KB";
        } else {
           $s = $size;
           $dw = "bytes";
        }
        return $s.$dw;
    }

解析目录路径:
    跨平台常量
    windows:    D:\Appserver\www\test.php
    linux:      /user/local/apache/
    1. 路径分隔符常量: DIRECTORY_SEPARATOR : echo 'D:'.DIRECTORY_SEPARATOR.'Appserver'.DIRECTORY_SEPARATOR.'www'; 
        注意: C:/Appserver ,所有程序中,都用'/'来代表路径分隔符, PHP程序中,Apache配置文件中,PHP配置文件中,只要有目录的情况, 全部使用正斜杠'/';
    2.多路径分隔符常量: PATH_SEPARATOR ;  windows: ';' eg: C:\Appserver; D\Appserver , linux: ':' eg: /user/local:/etc/aaa; 
    3.换行符常量: PHP_EOL; window: \r\n ; linux: \n;

    相对和绝对路径: 
    ./ 当前目录 
    ../ 上级目录
    / 根目录;
    
    不同根路径: 
        1.php程序操作的文件,根路径是服务器操作系统的文档根目录,windows的话安装盘C盘;
        2.客户端查看的根路径, 是服务器(apache)的域名根目录;
    
    路径解析函数:
    echo basename("http://tag.163.com/news/174/174575/1.html?from=tagwall").'<br>'; //1.html?from=tagwall 获取文件名
    echo basename("http://www.baidu.com/index.html",'.html').'<br>';//index 去掉后缀
    echo dirname("http://www.baidu.com/index.html").'<br>';//http://www.baidu.com 获取目录名
    print_r(pathinfo("http://www.baidu.com/index.html")); //返回一个关联数组包含有 path 的信息。返回关联数组还是字符串取决于 options
    //realpath — 返回规范化的绝对路径名 
    
    遍历目录:
    glob — 寻找与模式匹配的文件路径 
    foreach(glob("./*") as $filename){
        echo $filename.'<br>';
    };

    <?php
文件操作:
    文件和目录
    文件类型:
    window下只有 dir file 和 unknown
    unix下有  dir file block char fifo link 和 unknown
    filetype() 获取文件类型;
    is_dir — 判断给定文件名是否是一个目录
    is_executable — 判断给定文件名是否可执行
    is_file — 判断给定文件名是否为一个正常的文件
    is_link — 判断给定文件名是否为一个符号连接
    is_readable — 判断给定文件名是否可读
    is_uploaded_file — 判断文件是否是通过 HTTP POST 上传的
    is_writable — 判断给定的文件名是否可写
    is_writeable — is_writable 的别名

文件的属性:
<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
    function getFilePro($filename){
        if(file_exists($filename)){
            echo '文件存在<br>';
            
            //获取文件类型 ,大小
            echo filetype($filename).'<br>';
            if(is_dir($filename)){
                echo '文件类型为: dir<br>';
            }else if(is_file($filename)){
                echo '文件类型为: file<br>';
                echo '文件大小为: '.tosize(filesize($filename)).'<br>';            
            }
            
            //获取文件权限
            $du = is_readable($filename)? '可' : '不可';
            $xie = is_writable($filename)? '可' : '不可';
            $zx = is_executable($filename)? '可' : '不可';

            echo "文件{$du}写<br>文件{$xie}写<br>文件{$zx}执行<br>";

            //创建时间
            echo '文件创建时间:'.date("Y年m月d日 H:i:s",filectime($filename)).'<br>';
            //修改时间
            echo '文件修改时间:'.date("Y年m月d日 H:i:s",filemtime($filename)).'<br>';
            //访问时间
            echo '文件访问时间:'.date("Y年m月d日 H:i:s",fileatime($filename)).'<br>';
        }else{
            echo '文件不存在';
        }
    }
    getFilePro("./test.php");

    function tosize($size){
        $s = $size;
        $dw = '';
        if($s>=pow(2,40)){
           $s = $size/pow(2,40); 
           $dw = "TB";
        } else if ($s>=pow(2,30)){
           $s = $size/pow(2,30);
           $dw = "GB";
        } else if ($s>=pow(2,20)){
           $s = $size/pow(2,20);
           $dw = "MB";
        } else if ($s>=pow(2,10)){
           $s = $size/pow(2,10);
           $dw = "KB";
        } else {
           $s = $size;
           $dw = "bytes";
        }
        return $s.$dw;
    }

解析目录路径:
    跨平台常量
    windows:    D:\Appserver\www\test.php
    linux:      /user/local/apache/
    1. 路径分隔符常量: DIRECTORY_SEPARATOR : echo 'D:'.DIRECTORY_SEPARATOR.'Appserver'.DIRECTORY_SEPARATOR.'www'; 
        注意: C:/Appserver ,所有程序中,都用'/'来代表路径分隔符, PHP程序中,Apache配置文件中,PHP配置文件中,只要有目录的情况, 全部使用正斜杠'/';
    2.多路径分隔符常量: PATH_SEPARATOR ;  windows: ';' eg: C:\Appserver; D\Appserver , linux: ':' eg: /user/local:/etc/aaa; 
    3.换行符常量: PHP_EOL; window: \r\n ; linux: \n;

    相对和绝对路径: 
    ./ 当前目录 
    ../ 上级目录
    / 根目录;
    
    不同根路径: 
        1.php程序操作的文件,根路径是服务器操作系统的文档根目录,windows的话安装盘C盘;
        2.客户端查看的根路径, 是服务器(apache)的域名根目录;
    
    路径解析函数:
    echo basename("http://tag.163.com/news/174/174575/1.html?from=tagwall").'<br>'; //1.html?from=tagwall 获取文件名
    echo basename("http://www.baidu.com/index.html",'.html').'<br>';//index 去掉后缀
    echo dirname("http://www.baidu.com/index.html").'<br>';//http://www.baidu.com 获取目录名
    print_r(pathinfo("http://www.baidu.com/index.html")); //返回一个关联数组包含有 path 的信息。返回关联数组还是字符串取决于 options
    //realpath — 返回规范化的绝对路径名 
    
    遍历目录:
    glob — 寻找与模式匹配的文件路径 
    foreach(glob("./*") as $filename){
        echo $filename.'<br>';
    };

    $lujin = './huanbao';
    $dir = opendir($lujin); //打开目录
    //echo readdir($dir).'<br>';  //从目录句柄中读取条目 第一个文件 .
    //echo readdir($dir).'<br>'; //第二个文件 ..
    while($filename = readdir($dir)){
        if($filename != '.' && $filename != '..' ){
            $filename = $lujin.'/'.$filename;
            if(is_dir($filename)){
                echo '进入目录: '.$filename;
            }else{
                echo '文件: '.$filename;
            }
            echo '<br>';
        }
    }
    //rewinddir($dir); //倒回目录句柄
    closedir($dir); //关闭目录句柄

    dir — 返回一个 Directory 类实例
    chdir — 改变目录
    chroot — 改变根目录
    scandir — 列出指定路径中的文件和目录
    getcwd — 取得当前工作目录

统计目录
<?php
    //统计磁盘
    $total = disk_total_space('C:');
    $free = disk_free_space('C:');
    echo "C:盘总大小为: ".round($total/pow(2,30)).'G; 可用空间为:'.round($free/pow(2,30)).'G。<br>'; 

    //统计目录文件个数和大小 
    //linux下命令: exec("du -shm ../xm/choujiang");
    $dirn = 0;
    $filen = 0;
    $filesize = 0;
    function getdirnum($file){
        global $dirn;
        global $filen;
        global $filesize;
        if(is_dir($file)){
            $dir = opendir($file);
            while(false  !== ($filename = readdir($dir))){
                if($filename!='.' && $filename!='..'){
                    $filename = $file.'/'.$filename;
                    if(is_dir($filename)){
                        $dirn++;
                        getdirnum($filename);
                    }else{
                        $filen++;
                        $filesize+=filesize($filename);
                    }
                    
                }
            }
            closedir($dir);
        }else{
            $filen++;
            $filesize+=filesize($file);
        }
    }

    getdirnum('../xm/choujiang');
    echo '目录数:'.$dirn.'<br>文件数:'.$filen.'<br>总大小为:'.round($filesize/pow(2,10)).' KB<br>';

建立与删除目录:
    linux下系统命令:
    exec('mkdir /hello'); //创建目录
    exec("rm -rf /hello");//删除目录
    
    php命令:
    bool mkdir  ( string $pathname  [, int $mode  = 0777  [, bool $recursive  = false  [, resource $context  ]]] )尝试新建一个由 pathname 指定的目录。
    bool rmdir  ( string $dirname  [, resource $context  ] ) 尝试删除 dirname 所指定的目录。 该目录必须是空的，而且要有相应的权限。 失败时会产生一个 E_WARNING  级别的错误。 
    int umask  ([ int $mask  ] ) 无参数调用会返回当前的 umask，有参数则返回原来的 umask。 
    bool chmod  ( string $filename  , int $mode  ) 尝试将 filename 所指定文件的模式改成 mode 所给定的。 
    bool unlink  ( string $filename  [, resource $context  ] )删除 filename。和 Unix C 的 unlink() 函数相似。 发生错误时会产生一个 E_WARNING  级别的错误。 

    注意八进制, 0777, 0开头的数字而不是字符串;
    在多线程的服务器上尽量避免使用 umask 函数。创建文件后要改变其权限最好还是使用 chmod() 。
    使用 umask()  会导致并发程序和服务器发生不可预知的情况，因为它们是使用相同的 umask 的。

    权限: 读r=4 写w=2 执行x=1
    filedir 用户    组    其他
            rwx    rwx    rwx
            rw_    r__    _wx
            6       4      3
    1. chown() - 改变文件的所有者 
    2. chgrp() - 改变文件所属的组 
    3. fileperms() - 取得文件的权限 
    4. stat() - 给出文件的信息 
    is_dir() - 判断给定文件名是否是一个目录 

<?php
    function deldir($dirname){
        if(!file_exists($dirname)){
            die("文件夹不存在!");
        } else if(is_file($dirname)){
            unlink($dirname);
            echo "删除文件成功: {$dirname}<br>";
        } else {
            $dir = opendir($dirname);
            while( ($filename = readdir($dir)) !== false){
                if($filename!='.' && $filename!='..'){
                    $filename = $dirname.'/'.$filename;
                    deldir($filename);
                }
            }
            closedir($dir);
            rmdir($dirname);
            echo "删除目录成功: {$dirname}<br>----------------------------<br><br>";
        }
    }
    deldir('abc');

复制移动目录:
    bool rename  ( string $oldname  , string $newname  [, resource $context  ] ) 尝试把 oldname 重命名为 newname。即为移动,文件目录均可用;
    bool copy  ( string $source  , string $dest  [, resource $context  ] )将文件从 source 拷贝到 dest。 如果要移动文件的话，请使用 rename()  函数。只能文件,不能目录;
<?php
    function copydir($olddir,$newdir){
        if(!file_exists($olddir)){
            die("{$olddir} 源目录不存在<br>");
        }
        if(file_exists($newdir)){
            if(!is_dir($newdir)){
                echo "{$newdir} 目标目录不是一个目录,无法拷贝进去<br>";
                exit;
            }
        }else{
            if(mkdir($newdir)){
                echo "{$newdir} 目录创建成功<br><br>";
            }else{
                echo "{$newdir} 目录创建失败<br><br>";
            }
        }
        $dir = opendir($olddir);
        while(false!==($filename=readdir($dir))){
            if($filename!='.' && $filename!='..'){
                $oldfilename = $olddir.'/'.$filename;
                $newfilename = $newdir.'/'.$filename;
                if(is_dir($oldfilename)){
                    copydir($oldfilename,$newfilename);
                }else{
                    if(copy($oldfilename,$newfilename)){
                        echo "{$newfilename} 文件复制成功<br>";
                    } else {
                        echo "{$newfilename} 文件复制失败<br>";
                    }
                }
            }
        }
        closedir($dir);
    }
    copydir('aaa','bbb');


文件的操作:
    touch — 设定文件的访问和修改时间 ,即为创建;
    rename — 重命名一个文件或目录 ,即为移动;
    copy — 拷贝文件 
    unlink — 删除文件 
    fopen — 打开文件或者 URL 
    ftruncate — 将文件截断到给定的长度 
    file_get_contents — 将整个文件读入一个字符串 
    file_put_contents — 将一个字符串写入文件 ,覆盖之前内容;
    readfile - 读入一个文件并写入到输出缓冲。
    file — 把整个文件读入一个数组中 

    int fwrite  ( resource $handle  , string $string  [, int $length  ] ) 把 string 的内容写入 文件指针 handle 处。每次执行会清空
    fread — 读取文件（可安全用于二进制文件） 

    fgetc — 从文件指针中读取字符 
    fgets() - 从文件指针中读取一行
    fgetss — 从文件指针中读取一行并过滤掉 HTML 标记    
    strip_tags() - 从字符串中去除 HTML 和 PHP 标记 


<?php
    $filename = 'test.txt';
    $rsize = rand(1,filesize($filename));
    echo "随机截取了文件 {$filename} 大小为 {$rsize} bytes";
    $fp=fopen($filename,'w'); 
    ftruncate($fp, $rsize);
    fclose($fp);

    // r只读,不会清空; w可写 没有文件会创建文件; 会清空文件内容; r+ 读写,不会清空,写入内容会覆盖; a  追加;
    /*
    fopen()  中 mode 的可能值列表  
    mode    说明
    'r'  只读方式打开，将文件指针指向文件头。  
    'r+'  读写方式打开，将文件指针指向文件头。  
    'w'  写入方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。  
    'w+'  读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。  
    'a'  写入方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。  
    'a+'  读写方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。  
    'x'  创建并以写入方式打开，将文件指针指向文件头。如果文件已存在，则 fopen()  调用失败并返回 FALSE ，并生成一条 E_WARNING  级别的错误信息。如果文件不存在则尝试创建之。这和给 底层的 open(2) 系统调用指定 O_EXCL|O_CREAT 标记是等价的。  
    'x+'  创建并以读写方式打开，其他的行为和 'x' 一样。  
    'c'  Open the file for writing only. If the file does not exist, it is created. If it exists, it is neither truncated (as opposed to 'w'), nor the call to this function fails (as is the case with 'x'). The file pointer is positioned on the beginning of the file. This may be useful if it's desired to get an advisory lock (see flock() ) before attempting to modify the file, as using 'w' could truncate the file before the lock was obtained (if truncation is desired, ftruncate()  can be used after the lock is requested).  
    'c+'  Open the file for reading and writing; otherwise it has the same behavior as 'c'.  

    */

<?php
    $fp = fopen('test3.txt', 'r');

    echo fread($fp, filesize('test3.txt'));
   // while(!feof($fp)){
        //echo fgetc($fp); //读取单字符;
        //echo fgets($fp); //读取整行;
   // }    
    fclose($fp);

移动文件指针:
    ftell — 返回文件指针读/写的位置
    fseek — 在文件指针中定位 
    rewind — 倒回文件指针的位置  如果将文件以附加（"a" 或者 "a+"）模式打开，写入文件的任何数据总是会被附加在后面，不管文件指针的位置。 
<?php
    $fp = fopen('test3.txt', 'r');
    echo ftell($fp).'<br>';
    fseek($fp,4);
    echo ftell($fp).'<br>';
    echo fread($fp,11).'<br>';
    fseek($fp,-3,SEEK_END);
    echo fread($fp,3).'<br>';
    rewind($fp);
    echo ftell($fp).'<br>';
    fclose($fp);

锁定机制:
    flock — 轻便的咨询文件锁定  bool flock  ( resource $handle  , int $operation  [, int &$wouldblock  ] )

文件上传:
    客户端form表单
    服务器对上传文件的操作
    PHP配置文件相关选项:
    指令名          默认值   功能描述
    file_uploads   ON    是否开启上传
    upload_max_filesize   2M  限制上传文件的最大值,必须小于 post_max_size
    post_max_size    8M       限制POST方法接受信息的最大值, 必须大于 upload_max_filesize
    upload_tmp_dir    NULL    上传文件存放的临时路径,可以是绝对路径, 默认NULL则使用系统临时目录
    
    函数:
    move_uploaded_file — 将上传的文件移动到新位置

文件下载:
<meta charset="utf-8" />
<a href="test.rar">测试下载1</a>
<a href="test.php">测试下载2</a>
<?php
    //文件下载
    $filename = "test.php";
    $basename = pathinfo($filename);
    header("Content-Type:text/html");
    header("Content-Disposition:attachment;filename=".$basename["basename"]);

    //指定下载文件的描述信息
    header("Content-Length:".filesize($filename)); //指定文件大小
    readfile($filename);//输出内容;