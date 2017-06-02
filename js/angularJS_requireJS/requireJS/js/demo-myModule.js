/*一. 自定义模块*/
//如果这个模块还依赖其他模块，那么define()函数的第一个参数，必须是一个数组，指明该模块的依赖性。
//注意这里相对路径的基础目录不是 myModule.js所在位置,而是config中定义的基础路径的位置

/*define("foo/title",[./lib/jquery.min"], function(jQuery){
一些define()中包含一个模块名称作为首个参数,这些常由优化工具生成。你也可以自己显式指定模块名称，但这使模块更不具备行移植性
这里用jQuery传参是错误的, 因为JQ本身不会 return jQuery. 而是保存在window.jQuery中;,"./lib/jquery/jquery.min"
*/
define(["jquery"], function(){
	//测试
	$(function(){
		alert("这是自定义模块在执行,: "+$);
	})

	//模块函数
	var add = function (x,y){
　　　　　 　return x+y;
　　};

	/*对模块的返回值类型并没有强制为一定是个object，任何函数的返回值都是允许, 这里返回一个对象,在主函数中用 形参.方法() 调用; */
	return {
		add : add
	}

	/*
	生成相对于模块的URL地址：你可能需要生成一个相对于模块的URL地址。
	你可以将”require”作为一个依赖注入进来，然后调用require.toUrl()以生成该URL

	define(["require"], function(require) {
		var cssUrl = require.toUrl("./style.css");
		var link = document.createElement("link");
		link.type = "text/css";
		link.rel = "stylesheet";
		link.href = cssUrl;
		document.getElementsByTagName("head")[0].appendChild(link);
	});

	*/

	/*
	循环依赖
	如果你定义了一个循环依赖（a依赖b，b同时依赖a），则在这种情形下当b的模块函数被调用的时候，它会得到一个undefined的a。b可以在模块已经定义好后用require()方法不规则获取（记得require作为依赖注入进来）
	*/
});
