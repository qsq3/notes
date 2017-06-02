1 安装 :
 1.新建对应数据库用户 - 2.新建对应数据库 - 3.编辑用户权限

2. 修改后台文件 admin.php 的文件名

3. 删除: 1.目录 2.数据库  3.数据库用户

目录：
template 默认模板目录
    defaul --
        common  -公共模板
            common.css - 公共样式
            module.css - 模板样式
            header.htm - 头部模板
        forum -- 论坛模板
        group  -- 群组
        home  -- 个人空间
        member - 用户功能
        mobile -  手机模板
        portal - 门户
        
        preview.jpg 预览图
        ***.xml -- 模板变量XML文件
        修改参数:

        父ID    id          默认值            参数作用
        Data    name        默认风格          风格名称
        Data    templateid    1              风格ID值
        Data    tplname     默认模板套系       风格名称
        Data    directory   ./template/default  风格目录
        Data    copyright    康盛               风格版权

自定义模板() -- 默认模板;
 界面 - 风格管理 - 选择模板
 discuz在进行模板显示时,如果检测不到当前设置的模板风格文件,会重定向到默认风格;

 新建模板 进行修改:
    新建template下自定义模板目录 test
    拷贝 discuz_style_default.xml 文件至该目录下, 并修改文件名为 discuz_style_test.xml;
    用记事本编辑打开,并修改前面的参数, 注意编码格式为ISO-8859-1
        //楼上正解补充他们需要用ISO8859-1编码那你发送前将你的UTF－8转为ISO8859-1 str = new String(str.getBytes("UTF-8"), "ISO-8859-1");将str的值发给他们就行了接收的话按楼上所说的String words = new String(str.getBytes("iso-8859-1"),"utf-8")


后台修改:
    宽屏和普屏的区别;界面 - 界面设置 
    默认左侧导航: 界面 - 界面设置 - 主题列表页 - 左侧版块导航宽度 : 0;
    导航 : 界面 - 导航设置 - 主导航
    版块:  论坛 - 版块管理 - 添加新版块;
    logo:  界面 - 风格管理 - 编辑(当前的风格) - 站点logo // 

css修改:
    defaul --
        common  -公共模板
            extend_common.css - 附加公共样式
            extend_module.css - 附加模板样式
    discuz x模板引擎搜索到 extend_xxx.css 文件后, 会将其与原始 xxx.css 进行拼接,生成新的css缓存;

    界面 - 风格管理 - 更新css缓存

    discuz的css语法引擎可以定制对应模块的入口文件(即.php脚本文件)

    制作模板时CSS书写要点：
    1、命名方式尽量不通用，使用自己的前缀。例如:（.header => .cr180_header / .footer => .cr180_footer / .nav => .cr180_nav ......）
    2、全局框架中慎用 !important 例如:（.header .nav {width:100% !important;}）
    3、a标签状态属性css书写有顺序（a:link / a:visited / a:hover / a:active ）
    4、属性继承顺序（先id后class，载入顺序后前/右左）
    5、如果你给框架定义了宽高时尽量使用overflow:hidden
    6、如果子框架有浮动属性时，父框架最好定义宽高（哪怕是auto！）或清除浮动
    7、为了提高日后维护效率，书写的代码一定要有缩进规范
    8、IE6浏览器中浮动框架外边距加倍时，记得给出问题的框架增加_display:inline属性！ 

    Discuz! X的CSS加载机制 
    首先，每个页面都会加载以下两个css，data/cache/style_1_common.css和data/cache/style_1_forum_index.css。

    先讲讲这两个文件名的命名规则：第一个是整站通用的css，所以命名为common.css，然后前面的代号是你使用了哪套风格，所以style_1_common.css表示是第一套风格的共用的css；第二个是表示forum的index页面风格，也就是论坛的首页风格。

    下面讲一下那两个css是如何生成的。
    首先，那两个css是程序生成的css缓存，所以你要改css的话，不能直接改那两个文件，否则一更新缓存，之前的改动就无效了。大家可以看到template对应的每套模板中，就拿自带的default模板举例吧，default模板中，带有一个common的文件夹，里面有css文件，common.css对应的就是生成缓存的style_1_common.css文件，style_1_forum_index.css对应的是module.css。

    common.css没有什么特别之处，里面也有css的说明，跟普通的css差不多。
    大家打开module.css，可以看到有这样的说明，
    /** group::index **/
            /* 群组 index 模块使用的CSS */
    /** end **/
    复制代码
    /** group::index **/开始到/** end **/结束，说明是group频道的index模块使用的CSS，也就是群组频道对应的首页模板将使用的CSS。
    再举个例子，/** misc::invite,group,forum::viewthread **/开始到/** end **/结束，说明是misc频道的invite模块、group频道的全部模块和forum频道的viewthread模块使用的CSS。
    下面讲讲缓存css是如何生成的，common.css比较简单，就是直接读取，然后生成到data/cache目录下。每个频道模块独立的css，会先将module.css在data/cache下生成一个对应的风格id下的缓存的css，然后当你访问某个频道时，会生成对应频道下的css，此时，刚才介绍的那些标识就起作用了。程序会根据/** group::index **/和/** end **/这种标识，拆分出哪些频道、哪些模块该需要哪些css。

    程序部分就不介绍了，程序的代码主要在source/class/class_template.php文件处理，有兴趣的同学可以深入研究一下

模板标签:
模板路径:
    引擎入口(即.php脚本文件)函数:source/function/function_core.php 里的 function template(){};
    模板文件目录: template/default/forum  //论坛部分的模板文件
    模板文件: .htm
    缓存文件: data/cache 必须可写;

    路径定位: 测试办法: 更改forumdisplay.htm的内容看下
      一般情况:
          URL:   域名/forum.php?mod=forumdisplay
                    模板目录名       模板文件名
          文件路径:template/test(模板名)/forum(模板目录名)/forumdisplay.htm(模板文件名)

      特殊情况:
            URL: 域名/home.php?mod=space$do=pm
                     模板目录名    模板文件名
            文件路径:template/test(模板名)/home(模板目录名)/space_pm.htm(模板文件名)
    修改办法:
        自定义模板目录下 - 新建同名文件 

模板标签:
子模板加载标签,
    原理:
        头部模板: common/header.htm; <?php include 'head.php' ?>
        主体模板:                             
        底部模板: common/footer.htm; <?php include 'foot.php' ?>
    
    调用方法:
    {template 子模板目录/子模板文件名}    //
    {subtemplate 子模板目录/子模板文件名} //会将主模板和子模板编译在一起,少了一个include文件加载过程;3.0之前这个不支持ajax;

    实例:
        引入头部和底部:
        {template common/header}
        test
        {template common/footer}
    当前模板目录下找不到对应模板文件就会重定向到默认模板目录下的

变量输出标签:
    作用:输出变量值,支持多维数组,变量嵌套;
    使用方法: {$变量名} 或 $变量名;
    需要写在php文件中

    实例
    {template common/header}
        <p>{$_G['uid']}</p>  //当前用户ID,2.5版本 ,2.0之前为$_G['gp_uid']
        <p>{$_G['username']}</p>  //当前用户名
    {template common/footer}

常量输出标签:
    使用方法: {常量名}
     实例
        <p>{TIMESTAMP}</p>  //时间戳, 1970到现在的秒数;
        <p>{DISCUZ_ROOT}</p> //discuz根目录绝对路径;

万能输出标签 echo :
    支持 任意值/变量/常量/函数返回值/对象属性/对象方法/PHP语句等;
    方法: {echo 代码}
    实例  
        {echo $_G['username']} //用户名
        
        //第一个是需要加密的字符串 ,第2个是选择 加密 或者 解密 , 第3个是用什么来加密, 第4个是过期时间; 
        {echo authcode('需要加密的字符串','ENCODE','ks')} 
        
        {echo 1+2} ;

执行代码标签 eval
    单行:
    执行任意单行PHP代码 : {eval 任意PHP代码};
    实例: {eval $a = "abc" } //赋值
          <p>{$a}</p>    //输出变量;

    多行(2.5以后新增):
        {eval}
            PHP代码
            PHP代码
        {/eval}
    实例:
    {eval}
        function fn () {
            echo 'this is a test';
        }
    {/eval}
    <p>{eval fn()}</p>
    
输出头像标签:
    输出指定用户的头像,img标签格式,支持大中小三种尺寸,
    {avatar(用户ID,'big')}
    {avatar(用户ID,'medium')}
    {avatar(用户ID,'small')}

循环数组标签: 
    对PHP数组遍历;
    {loop $数组名 $索引 $值} {/loop}
    {loop $数组名 $值} {/loop}

    实例:   
        {eval}
            $a = array(
                'aa' => 'dz',
                'bb' => 'bc'
            );
        {/eval}
        <ul>
            {loop $a $k $v}
                <li>{$k}-{$v}</li>
            {/loop}
        </ul>

逻辑判断标签
    流程控制处理
    {if 条件}
    {elseif 条件}
    {else}
    {/if}

    实例:
         {eval}
            $a = array(
                'aa' => 'dz',
                'bb' => 'bc'
            );
        {/eval}
       <ul>
            {if $a['aa'] == 'da'}
                var a.aa is da;
            {elseif $a['bb'] == 'bc'}
                var a.bb is bc;
            {else}
                var none;
            {/if}
        </ul>

时间输出标签 date
    {date(时间戳)}
    实例: {date(time())}

广告调用 ad
    {ad/广告标识符}
    运营 - 站点广告 - 广告位 - 添加自定义广告 - 编辑 -内部调用/外部调用 <!--{ad/custom_1}-->

数据调用 block
    门户 - 模块管理 - 数据调用 - 选择模块分类 - 添加调用 - 
    内部调用<!--{block/3}-->/外部调用 -更新 
    修改样式,链接等: 模块属性 - 编辑  也可修改 模块模块
    优先内部调用;

变量拼接: block
    拼接php与html混编代码至指定变量中;
    {block 变量名(不带$)} 混编代码 {/block}
    实例:
    {block test}  
    <ul>
        <li>111</li>
        <li>222</li>
    </ul>
   {/block}
   {$test}

钩子调用 hook
    结合插件系统,输出插件指定嵌入点的返回值;
    {hook/模块名称_自定义名称}
    eg:
    {hook/forumdisplay_testa}

输出换行标签: {LF}
    输出类Unix换行符,主要用在邮件模板

DIY调用 diy
    创建diy调用容器,实现diy拖动效果
    方法:
    <!--[diy=diy的id值]-->
        <div id="diy的id值" class="area"></div>
    <!--[/diy]-->   


插件创建:
    应用 - 应用中心 - 插件 - 启用 - 设置 
    目录: source - plugin
    缺点: 基于系统,升级兼容性问题,影响功能;
    功能:
        用户功能: 
            1. 页面显示嵌入点;
            2. 前台功能入口;
            3. 菜单选项模块;
        管理功能:
            1. 后台管理功能入口;
        数据功能:
            1.论坛主要数据处理模块;

系统开发的三种状态
配置文件路径: /config/config_global.php
变量: $_config['plugindeveloper']
状态: 
    NULL: 不开启插件开发模式, 不开启嵌入点;
    1 : 开始插件开发模式, 不开启嵌入点;
    2 : 开启插件开发模式, 开启嵌入点;
工具 - 更新缓存

    新建插件后 - source - plugin 下新建对应目录名

创建插件模块:
    后台对应插件 - 设计 - 模块
    discuz - source - plugin 下对应目录名 - 新建对应文件名的文件
创建插件变量:
    后台对应插件 - 设计 - 变量

插件嵌入点:
    嵌入点是 discuz程序提供的底层功能接口. 开发者通过在插件中定义嵌入点, 可以实现: 页面变化, 数据处理, 代码功能修改等程序效果;
    类型:
        1. 页面嵌入点: 修改页面显示; string, array等
        2. 信息提示嵌入点: 修改showmessage();
        3. 广告嵌入点: 处理广告位数据; ad
        4. 功能嵌入点: 处理主题, 帖子, 头像等数据;
    
    一. 页面嵌入点:

        1.先新增插件的页面模块:  
            后台对应插件 - 设计 - 模块- 新增 页面嵌入 普通版 
            source - plugin 下对应目录名 - 新建对应文件名的文件

        2. 类型:
            1. 全局页面嵌入点: 运行位置: 公共模板页面;
            2. 普通页面嵌入点: 运行位置: 普通模块模板页面;
            3. 输出前置页面嵌入点: 运行位置: 模块与模板之间,处理数据;

        3.页面嵌入点类的命名规则:
            1. 全局页面嵌入点类 (必须): 
                class plugin_插件标识符{} 

                eg: class plugin_plugintest{ }

            2. 普通嵌入点类(需继承全局类): 
                class plugin_插件标识符_入口(即.php脚本文件)文件名{} extends class plugin_插件标识符;

                 注意:首页是隐掉了 ?mod=index 的参数的;
                eg:  URL: localhost/discuztest/forum.php
                    (这里forum即为入口(即.php脚本文件)文件名,mod文件名默认index地址栏中会省略;)
                     class plugin_plugintest_forum extends plugin_plugintest{  }
        
        4.页面嵌入点方法的命名规则:
            模块名(即为URL里的 "mod=" 后面的文件名,默认index地址栏中会省略)
            1. 全局页面嵌入点方法: function global_任意 () {}
            2. 输出前置页面嵌入点方法: function 模块名_任意_output () {}
            3. 普通页面嵌入点方法: function 模块名_任意 () {}
            新增方法后需 工具 - 更新缓存  (代码错误不会显示更新完成的绿字)
            
        5. 页面嵌入点的两种返回值类型:
            1. 字符串类型: 普通数据显示
                eg: [string global_login_extra]
            2. 数组类型: 列表数据显示:
                eg: [array forumdisplay_thread_subject/0]

        6. 插件模板的定义规则: include template(插件标识符:模板目录名/模板名称)
            eg: include template('plugintest:forum/testmodule');
                对应目录: 插件目录/plugintest/template/forum/testmodule.htm
        
        7. block 标签的应用: 将显示的内容,存储到指定变量中;
            eg: <!--{block 变量名(这里变量名不带$,调用时需要带$)}-->
                    任意HTML内容
                <!--{/block}-->

    二. 公共嵌入点:
        方法名: common();
        声明位置: 公共嵌入点类;
        调用位置: 所有嵌入点之前;
        参数: 无;

    三. 信息提示嵌入点: 对应脚本文件中修改showmessage();
        方法名: 模块名_任意名称_message()
        声明位置: 脚本嵌入点类; 
        调用位置: 当前脚本提示用户信息时;
        参数: 方法参数;
        eg: 
    
    四. 广告嵌入点: 处理广告位数据; ad
        方法: ad_广告嵌入点名称();
        声明位置: 全局嵌入点类, 脚本嵌入点类;
        调用位置: 对应广告位;
        参数: 方法参数;
        注意: 调试模式下不能显示;
    
    五. 文本解析嵌入点: 
        方法: discuzcode();
        声明位置: 全局嵌入点类;
        调用位置: 主题文本解析时;
        参数: $_G['discuzcodemessage'], 方法参数;

    六. 主题删除嵌入点(两次调用): 
        方法: deletethread();
        声明位置: 全局嵌入点类;
        调用位置: 主题被删除前,后时;
        参数: $_G['deletethreadtids'], 方法参数;
        URL里面的tid 即为主题的 ID值;
        对应数据库中的表: 前缀_forum_thread
    
        array
        (
            'param' => deletethread() 函数的参数数组,

            'step' => 删除的步骤
                'check' 检测步骤
                'delete' 删除步骤
        )


    七. 帖子删除嵌入点(两次调用): 
        方法: deletepost();
        声明位置: 全局嵌入点类;
        调用位置: 帖子被删除前,后时;
        参数: $_G['deletepostids'], 方法参数;

    
    八. 头像显示嵌入点: avatar()
        方法: avatar();
        声明位置: 全局嵌入点类;
        调用位置: 头像显示时;
        参数: $_G['hookavatar'], 方法参数;

eg: 
//新建  discuz/source/plugin/plugintest(自定义插件名)/testhook.class.php(对应插件下的页面模块名) 
<?php
    //全局嵌入点类(公共嵌入点类)
    class plugin_plugintest
    {
        //公共方法,这里给全局变量赋值:
        function common() {
            global $_G;
            $_G['test'] = 'testcommon';
        }
        
        //全局方法 ,这里调用测试模板文件
        /*插件模板文件.htm中:
         <!--{block str}-->
            <h2>测试模板文件1</h2>
        <!--{/block}-->
        */
        function global_cpnav_extra1(){
            include template('plugintest:forum/testmodule');
            return $str;
        }

        //广告嵌入点
        function ad_headerbanner () {
            return '<a href="http://www.baidu.com" target="_blank"> 广告测试</a>';
        }
        
        //文本解析嵌入点:
        function discuzcode(){
            global $_G;

            $_G['discuzcodemessage'] .= ' - 这里是在文本后面追加的文本,对主题和回复帖都有作用';
        }

        //主题删除嵌入点 ,两次调用
        function deletethread($p){
            global $_G;

            //debug($_G['deletethreadtids']);
            $id = $_G['deletethreadtids'][0]; //获取删除主题的第一个的id值
            
            //下面为获取 删除贴作者名称 的 数据查询表达式, 
            //array中,forum_thread 为数据库表的名称(去掉前缀), 第二个为要删除的id
            $author = DB::result_first('SELECT author FROM %t WHERE tid=%d', array('forum_thread',$id));
            //debug($author);
            
             //通过传参(二维数组)判断调用时的状态(删帖前,删帖后);
            if ($p['step'] == 'check'){
                //code
            } elseif ($p['step'] == 'delete') {
                //code
            }

        }
        
        //头像嵌入点
        function avatar($p){
            global $_G;
            $_G['hookavatar'] = '<img src="http://localhost/testtouxiang'.$p['param'][0].'.png?" />';
            //debug($p); //$p为所有头像用户的id值的数组;
        }

    }
    
    //普通嵌入点类(脚本嵌入点类)
    class plugin_plugintest_forum extends plugin_plugintest
    {
        //信息提示嵌入方法:
        /*先在对应脚本文件添加showmessage()方法,
        eg:dicuze/forum.php 中添加: showmessage('123','home.php');
        */
        function index_testmessage_message($p){
            //debug($p); //调试打印其内容
            //echo $p['param'][0]; 
            exit;
        }

        //前置页面嵌入方法
        function index_qianzhitest1_output(){
            echo "可输出任意内容,会在模板最前面,但一般不会这样用,程序运行之后,模板调用之前执行,一般用来做数据处理";
            //程序运行之后,模板调用之前执行,
            global $_G;
            $_G['member']['username'] = 'hehe';
        }

        //普通方法
        function index_status_extra(){
            global $_G;
            return $_G['test'].'测试普通方法';
        }

        //返回数组类型
        function forumdisplay_thread_subject () {
            return array(
                0 => '第一个主题',
                1 => '第二个主题'
            ); 
        }

    }
?>

新建单页入口文件:

eg: 
//根目录下,新建入口脚本文件: 根目录/cr180.php
<?php

define('APPTYPEID', 180);
define('CURSCRIPT', 'cr180');

/*******必须的内容******/
require './source/class/class_core.php';
$discuz = C::app();
$cachelist = array('grouptype', 'groupindex', 'diytemplatenamegroup');
$discuz->cachelist = $cachelist;
$discuz->init();
/*******必须的内容******/

//插件钩子
runhooks();

$navtitle = '页面标题';//str_replace('{bbname}', $_G['setting']['bbname'], $_G['setting']['seotitle']['group']);
$metakeywords = '页面关键词(SEO)';
$metadescription = '页面介绍(SEO)';

//数据库操作
$query = DB::query("SELECT * FROM ".DB::table('forum_thread')." WHERE fid=2 AND closed=0 ORDER BY dateline DESC LIMIT 0 ,10");
while($value = DB::fetch($query)){
	$data[] = $value;
}

//print_r($data);

include template('diy:cr180/index');//载入模板文件 路径:根目录/template/default/cr180/index.htm;
?>

//然后对应目录下新建模板文件: 路径:根目录/template/default/cr180/index.htm;

<!--{subtemplate common/header}-->
<div>引入头部</div>
<ul>
    <li>1</li>

    <li>这是diy嵌入框架</li>
    <li>
        <!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
    </li>

    <!--数据库中取数据,循环输出 -->
    <!--{loop $data $value}-->
    <li><a href="forum.php?mod=viewthread&tid=$value[tid]" target="_blank">$value[subject]</a></li>
    <!--{/loop}-->

    <li>2</li>
</ul>

<div>引入底部</div>
<!--{subtemplate common/footer}-->