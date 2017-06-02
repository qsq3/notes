<?php
创建:
    创建流程: 插件设计 - 主导航项目(模块的位置) 

                URL: plugin.php?id=plugintest:testapp
                     入口文件       插件标识符  功能文件名
对应路径:根目录/source/plugin/       plugintest/tesapp.inc.php ;
    
    代码流程图:   
                功能开始
                   |
     显示表单--否--提交
                   |
                   是
                   |
                数据验证
                   |
                写入数据库
                   |
                 提示用户

提交判断函数解析: submitcheck($var,$allowget,$seccodecheck,$secqaacheck);
    $var : 表单元素的name值
    $allowget : 是否允许get提交;
    $seccodecheck : 是否检查验证码;
    $secqaacheck : 是否检查安全问题;
    返回值: 是否为表单提交;

提示信息函数解析: showmessage($message, $url_forward, $values, $extraparam, $custom);
    $message      提示用户信息
    $url_forward  显示信息后跳转链接
    $values       显示信息附加变量数据
    $extraparam   附加信息参数
    $custom       设置为true则显示自定义信息模板,默认模板为: 根目录/template/default/common/showmessage.htm , 
    注意:showmessage()后面的代码是不会执行的;

数据变量获取:
    用户登录标志: $_G['uid']  //未登录为false
    获取配置信息: $_G['config'] // 根目录/config/config_global.php下
    获取用户信息: $_G['member']
    获取Cookie数据: $_G['cookie']
    获取缓存数据: $_G['cache']
    获取GET, POST数据: $_GET

后台管理功能:
    后台链接解析:
            URL:    admin.php?action=setting&operation=basic
                                      文件名   条件名
对应路径:根目录/source/admincp/admincp_setting.php (条件为该php文件内的if判断代码)

插件编写后台管理类型:

内置管理后台:
    由插件系统自动生成的后台管理模块(无需编写文件)
    应用 - 插件 - 设计 - 变量 - 

    在程序中获取内置后台管理数据
        代码: loadcache('plugin');
        变量: $_G['cache']['plugin'][插件标识符]


自定义管理后台:
    开发者在插件中建立的后台管理模块(需要编写文件)
    应用 - 插件 - 设计 - 模块 - 新增 管理中心 -

    自定义后台链接解析:
    根目录/admin.php?frames=yes&action=plugins&operation=config&do(插件id,$pluginid)=14&identifier(插件标识符)=plugintest&pmod(模块名)=admin



      
eg:
    自定义前台插件
    根目录\source\plugin\plugintest\testapp.inc.php
<?php

//内置管理后台
loadcache('plugin');
//debug($_G['cache']['plugin']['plugintest']['badword']);
$badwords = $_G['cache']['plugin']['plugintest']['badword'];
preg_match("/($badwords)/",$_GET['username']);


error_reporting(7);
/**编写提交选项,流程图第一环,注意事项:
    1. submitcheck()函数内填 submit 按钮的 name
    2. 非提交的 form 的 action 填原链接,返回表单地址
    3. 需添加formhash
*/
if (!submitcheck('submitname')) {

    // include template('plugintest:forum/adduser');

    $formhash = FORMHASH;
    echo <<<EOF
    <form action='plugin.php?id=plugintest:testapp' method='post'>
        用户名<input type='text' name='user' value='' /> <br/>
        <input type='hidden' name='formhash' value="$formhash" /> <br/>
        <input type='submit' name='submitname' value='提交' />
    </form>
EOF;
} else {
    
    //获取配置信息:['db']['1']['dbhost']在 根目录/config/config_global.php下查找
    //echo $_G['config']['db']['1']['dbhost'];
    
    /*获取用户信息:
    print_r($_G['member']);
    //cookie
    print_r($_G['cookie']);
    //缓存
    print_r($_G['cache']);
    //POST信息
    print_r($_POST);
    */

    if(!$_G['uid']){
        showmessage('请先登录','member.php?mod=logging&action=login');
    }

    $username = $_GET['user'];
    if(empty($username)){
        showmessage('用户名不能为空');
    }
    
    $id = C::t('#plugintest#test_db')->add_name($username);

    if($id){
        showmessage('添加用户成功','forum.php');
    }

    
}
 
eg: 自定义后台插件 
根目录\source\plugin\plugintest\admin.inc.php
<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if(!submitcheck('submit1')){
    showformheader('plugins&operation=config&do='.$pluginid.'&identifier=plugintest&pmod=admin">');
    showtableheader();
    showsetting('颜色管理','bordercolor','','color','',0,'');
    showtablefooter();
    showsubmit('submit1','提交');

    showformfooter();
} else {
    debug($_GET); 
}

插件语言包: