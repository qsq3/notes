<?php
数据库:
    数据字典: http://faq.comsenz.com/library/database/x3/x3_index.htm

    用户表: common_member

    eg: 查找金钱积分: 后台 - 全局 - 积分设置 - 找到金钱为第二套积分 extcredits2 - 到数据字典中查找 extcredits2 - 找到其所在表为用户统计表(其他几个日志规则的不用) common_member_count  - 去数据库中找到对应表 common_member_count  - 就可以修改了 - 不建议直接修改数据库

数据库操作:
    为了方便测试, 把操作代码写在了 discuztest\source\plugin\plugintest\testnav.inc.php中
    对应数据库中 - 新建表: 前缀_test_db  字段数 2 - 设置属性  - 
    名字     类型            长度       排序规则         属性     空(是否允许为空)   索引    A_I(组件)
    id       INT             10                       UNSIGNED                 PRIMARY   勾选
    name    CHAR(字符串)      20     utf8_general_ci
    
    表整理类型 Collation : utf8_general_ci
    存储引擎 Storage Engine: MylSAM

    模型数据库方法目录 根目录/source/class/discuz/discuz.database.php

插入:
    DB::insert( $table, $data, $return_insert_id, $replace, $silent );
    参数解释:
        $table : 插入数据的表(没有前缀)
        $data : 插入的数据,字段对应值,一般为数组,
        $return_insert_id : 是否返回插入数据的ID,填 true 会返回 id;
        $replace : 是否使用 replace into ,(当原表中有不能重复的字段, 则替换更新,相当于update;否则等同insert into)
        $silent : 操作失败是否不提示
eg: 
    echo DB::insert('test_db',array(
        'id' => '2',
        'name' => 'tesss3',

    ),true,true); 


删除:
    DB::delete( $table, $condition, $limit, $unbuffered);
    参数解释: 
        $table : 操作的数据表(没有前缀)
        $condition : 删除的条件
        $limit : 删除满足条件的条目数
        $unbuffered : 是否使用无缓存查询;优点:节省内存;缺点:一些缓存相关方法不能用
eg: DB::delete('test_db', 'id>2', 1,true); 

更新:
    DB::update( $table, $data, $condition, $unfuffered, $low_priority)
    参数解释: 
        $table : 操作的数据表(没有前缀)
        $data : 更新的数据,字段对应值
        $condition : 更新的条件
        $unfuffered : 是否使用无缓存查询
        $low_priority : 是否使用无锁表更新,使用情况:只有一个用户,比如升级的时候
eg: DB::update('test_db', array(
        'name' => 'zzz',
    ), 'id=6' ) ; //注意 这里用 = 号,而不是 ==号;

绑定查询:
    表达式      数据处理                 解释
    %t          DB::table()          自定添加表前缀
    %d          intval()             对数据进行整型操作
    %s          addslashes           转义(防止注入)
    %n          IN(1, 2, 3)          集合查询
    %f          sprintf('%f', $var)  使用sprintf格式成浮点型
    %i          不做任何处理          
 
    
查询操作
    单条 :   DB::fech_first($sql, $arg, $silent);
    多条 :   DB::fetch_all($sql, $arg, $keyfield, $silent);
    单字段 : DB::result_first($sql, $arg, $silent);
    
        $sql : 查询数据的sql语句
        $arg : 绑定查询的参数
        $keyfield : 给返回的一维索引的字段名称赋值的变量 (注意:因为是索引,所以不能重复,一般用'id'之类)
        $silent : 操作失败是否不提示

数据库自定义query(增删改查): DB::query( $sql, $arg, $silent, $unfuffered );返回一个资源;
    $sql : 查询数据的sql语句,内含形参
    $arg : 绑定查询的实参: array(数据表名, 条件等),需和sql语句的形参对应;
    $silent : 操作失败是否不提示
    $unfuffered : 是否使用无缓存查询

资源集转换结果集: DB::fetch( $resourceid, $type )
    $resourceid : 数据库查询的query资源
    $type : 第二个参数为取出的数组类型 : 不填: 默认关联索引; MYSQL_NUM: 数字索引; MYSQL_BOTH:两个索引; 

单字段资源集转换结果集: DB::result( $resourceid , $row ); 常用于获取数据表的统计值
    $resourceid : 数据库查询的query资源;
    $row : 指定行的第一个字段;
    
资源集行数计算: DB::num_rows($resourceid); 
    $resourceid : 数据库查询的query资源;//速度较慢,小数量情况使用, 大数量还是使用SQL语句 SELECT count(*) ,然后result转换

资源集释放: DB::free_result($query);
    $query : 执行SQL语句的query资源

按字段排序: DB::order($field, $order);
    $field : 需排序的字段
    $order : 排序方式: DESC - 倒序 ,ASC - 正序;

取值区间设定: 
    DB::limit($start , $limit); //从第$start条开始,取几条
    DB::limit( $limit); //取前几条
    $start : 开始值;
    $limit : 条目数;

字段拼接:
    DB::implode($array , $glue);
    $array : 需拼接的字段数组;
    $glue : 字段拼接的字符串;

字段数据设定:
    DB::field($field,$val,$glue);
    $field : 需处理的字段名称;
    $val : 字段对应的值;
    $glue : 连接字段与值得类型;

eg: //单行查询
    $id = 4;//$_GET['id']; 
    $data = DB::fetch_first("SELECT * FROM %t WHERE id = %d", array(
        'test_db', 
        $id,
        ));
    //debug( $data );

    //多行查询
    $id2 = 6;
    $data = DB::fetch_all("SELECT * FROM %t WHERE id >= %d AND id <= %d", array(
        'test_db', 
        $id,
        $id2,
        ),'id');

    //单字段查询,一般用于统计查询: 
    echo DB::result_first("SELECT name FROM %t WHERE id = %d", array(
        'test_db',$id
    ));

    //获取总条目数
    echo DB::result_first("SELECT COUNT(*) FROM %t", array(
        'test_db'
    ));

    //最大ID
    echo DB::result_first("SELECT MAX(id) FROM %t", array(
        'test_db'
    ));

    //查询name , %s对应字符串
    $data = DB::fetch_first("SELECT * FROM %t WHERE name=%s", array(
        'test_db' , 'ddd'
    ));

    //查询集合+ query自定义查询获取资源 + fetch转换结果集
    $resource = DB::query("SELECT * FROM %t WHERE id IN (%n)", array(
        'test_db', array(2,3,5,6,7,8,9)
    ));
    //第二个参数: 不填: 默认关联索引; MYSQL_NUM: 数字索引; MYSQL_BOTH:两个索引; 
    while($res = DB::fetch($resource ,MYSQL_BOTH)){
        $aaa[] = $res;
    }
    
    //query自定义删除
    $d = 8;
    DB::query("DELETE FROM %t WHERE id = %d", array(
        'test_db', $d
    ));

    //debug($aaa);
    
    echo '1'.'<br/>';

    //单字段资源集转换结果集: DB::result
    $resource = DB::query("SELECT name FROM %t WHERE id > %d ORDER BY id ", array(
            'test_db', 2)
        );
    $data = DB::result( $resource , 1);

    //获取count统计值
    $resource2 = DB::query("SELECT count(*) FROM %t WHERE id < %d ORDER BY id ", array(
            'test_db', 10
    ));
    $data2 = DB::result( $resource2 , 0);
    
    //释放query
    //DB::free_result($resource);

    //行数计算
    //$data = DB::num_rows($resource); 
    
    //排序 + 取值区间;
    $query = DB::query("SELECT name FROM %t WHERE id > %d ORDER BY".DB::order('id', 'DESC').DB::limit(1,3) , array(
                'test_db', 0)
    );
    while($res = DB::fetch($query )){
        $result[] = $res ;
    }

    //debug( $result );

    //字段拼接:implode
    echo DB::implode(array(
        'id' => 5,
        'name' => 'e55'
    ), 'AND'); 
    //`id`='5' AND `name`='e55'

    //拼接应用
    DB::query("UPDATE %t SET".DB::implode(array(
        'name' => 'implodeUPDATE',
        'id' => 22,
    )).'WHERE id=%d', array(
        'test_db',
        8,
    ));
    //mySQL语句实现,效果同上
    DB::query("UPDATE %t SET name=%s, id=%d WHERE id=%d",array(
        'test_db',
         'implodeUPDATE2',
         23,
         6
    ));
    
    //字段数据设定
    echo DB::field('id' , 99 , '='); // `id`='99'
    //应用:
    DB::query("UPDATE %t SET".DB::field('id' , 99 , '=')."WHERE id=%d", array(
        'test_db',
        3
    ));

MVC开发思想简介:
    V : view 视图 : template 模板目录

    C : controller 控制器: 

    M : model 模型 :
    
        内置模型目录: 产品根目录/source/class/table/table_xxx.php ;
        内置模型调用: C::t('模型类名')->模型方法(); //类名为去掉前缀table

        插件模型目录: 产品根目录/source/plugin/插件目录/table/table_xxx.php ;
        插件模型调用: C::t('#插件标识符#模型类名')->模型方法
    
    模型基类属性:
    属性名                  属性值
    $_table              数据表名称
    $_pk                 数据表主键名称
    $_pre_cache_key      数据缓存key前缀
    
    模型数据库方法(DB方法)目录 根目录/source/class/discuz/discuz.database.php

    模型基类(基类方法)目录: 根目录/source/class/discuz/discuz.table.php

    模型基类CURD方法(增删改查):
    insert()    插入数据;
    delete()    删除;
    update()    更新;
    fetch()     根据主键值查询数据;源码利用了DB::fetch_first()方法;
    fetch_all() 根据主键值查询数据组;源码利用了DB::fetch_all()方法;
    range()     查询指定范围数据; 源码利用了DB::fetch_all()方法;
    count()     计算数据表数据总数;

    模型基类其他方法:
    truncate()  清空数据表
    optimize()  优化数据表
    checkpk()   检查主键是否设置
    fetch_all_field()  取出所有字段
    getTable()  获取表名称

eg:
自定义调用路径,操作代码写在了: discuzt est/source/plugin/plugintest/testnav.inc.php
<?php
    echo '<p>1</p>';
    //调用内置模型的方法
    //$data = C::t('common_credit_rule')->fetch_all_by_action('reply');

    //调用插件模型的方法
    //C::t('#plugintest#test_db')->test();
    
    //从模型中调用数据库操作方法,增
    //C::t('#plugintest#test_db')->add_name('test add name');
    
    //从模型中调用数据库操作方法,改
    //C::t('#plugintest#test_db')->change_name_by_id(6, 'test change name');
    C::t('#plugintest#test_db')->change_name_by_oldname('test change oldname基', 'test change oldname');

    //从模型中调用数据库操作方法,删
    //C::t('#plugintest#test_db')->delete_by_id(6);

    //从模型中调用数据库操作方法,查,单条   
    //$data = C::t('#plugintest#test_db')->fetch_data_by_id(5);
    //从模型中调用数据库操作方法,查,单条 ,也可直接调用fetch(),源码也是利用fetch_first;
    //$data = C::t('#plugintest#test_db')->fetch(5);
    
    //从模型中调用数据库操作方法,查,多条   
    //$data = C::t('#plugintest#test_db')->fetch_all_data_by_id(array(1,2,3,4,5,6));
    //从模型中调用数据库操作方法,查,多条 ,也可直接调用fetch(),源码也是利用fetch_all;
    //$data = C::t('#plugintest#test_db')->fetch_all(array(1,2,3,4,5,6));
    
    //count()计数,直接调用基类方法;
    $data = C::t('#plugintest#test_db')->count();
    
    //range()指定范围
    $data = C::t('#plugintest#test_db')->get_last_num_name(5);



    //其他方法:

    //truncate() 清空数据表
    // C::t('#plugintest#test_db')->truncate();
    
    //optimize()  优化数据表
    C::t('#plugintest#test_db')->optimize();

    //checkpk()   检查主键是否设置,失败会抛出异常;像count()等需要主键的方法内部其实已经调用了这个方法;
    C::t('#plugintest#test_db')->checkpk();

    //fetch_all_field()  取出所有字段
    //$data = C::t('#plugintest#test_db')->fetch_all_field();

    //getTable()  获取表名称
    //$data = C::t('#plugintest#test_db')->getTable();
    
    echo DB::query("UPDATE %t SET".DB::implode(array(
        'name' => 'implodeUPDATE',
        'id' => 22,
    )).'WHERE id=%d', array(
        'test_db',
        8,
    ));

    debug($data);


自定义模型路径:  discuztest/source/plugin/plugintest/table/table_test_db.php ;
<?php

//常量判断, 防止用户跳过主程序直接执行模型
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

//所有模型都需继承 discuz_table , 模型名需和数据表名保持一致;
class table_test_db extends discuz_table
{
    //构造方法:
    public function __construct() {

		$this->_table = 'test_db'; //数据表名称,模型名需和数据表名保持一致;
		$this->_pk    = 'id'; //数据表主键名称
        //$this->_pre_cache_key = 'test_db_'; //数据缓存key前缀

		parent::__construct();
	}
    
    //测试
    public function test (){
        echo 'this is a test';
    }
    
    //操作数据库 : 增 : 编写add_name方法,
    public function add_name($name){
        //两种方式, 
        //直接用DB方法操作数据库
        DB::insert('test_db',array(
        'name' => $name.'DB',
        )); 

        //调用模型基类database里提供的方法,从database源码里可以看出,这里不需要填数据表名test_db
        $this->insert(array(
            'name' => $name.'基类方法_增',
        ));

    }

    //改
    public function change_name_by_id($id, $name){
        $this->update($id, array(
            'name' => $name.'基类方法_改',
        ));//可以是单条string ,也可以是多条的数组;
    }

    public function change_name_by_oldname($oldname, $name){
        DB::update($this->_table,  array(
            'name' => $name.'2',
        ),DB::field('name',$oldname,'=') );
        //也可用数组形式 array(name => $oldname);
        //'name = '.$oldname这样直接拼接不安全;
    }
 
    //删
    public function delete_by_id($id){
        $this->delete($id);//可以是单条string ,也可以是多条的数组;
    }

    //查 单条
    public function fetch_data_by_id($id){
        echo $id;
        return $this->fetch($id);
    }

    //查 多条
    public function fetch_all_data_by_id($id){
        echo $id;
        return $this->fetch_all($id);
    }
    
    //range()指定范围
    public function get_last_num_name($num){
        return  $this->range(0,$num,DESC);
    }
    
    //其他方法:
    


}