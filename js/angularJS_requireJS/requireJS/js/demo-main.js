/*一. config 加载文件调用*/
/*
requirejs默认对文件进行js扩展名处理，如果加上js或者以http、https开头，则不处理,
*/
require.config({
    /*
    通过urlArgs解决requireJS在开发中的缓存问题
    */
    urlArgs: "bust=" +  (new Date()).getTime(),

	/* baseUrl 定义paths的基础路径,注意此处baseUrl的相对路径的基础目录是html文件的位置。
	如果不配置baseUrl，data-main指定的demo.js所在的位置会被默认为paths的基础路径,这里包括了自定义模块的相对基础路径*/
    baseUrl:"../",

	/*paths 定义模块路径, 默认对文件进行js扩展名处理, 如果加上js或者以http、https开头，则不处理? (经测试underscore不能加.js后缀)
    可以配置多个路径，如果远程cdn库没有加载成功，可以加载本地的库
	*/
    paths : {
		"jquery" : ["http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min","./lib/jquery/jquery.min"],
		"jqueryui" : "http://apps.bdimg.com/libs/jqueryui/1.9.2/jquery-ui.min",
		"angular" : ["http://apps.bdimg.com/libs/angular.js/1.5.0-beta.0/angular.min", "./lib/angularjs/angular.min"],
		"underscore" : "http://apps.bdimg.com/libs/underscore.js/1.7.0/underscore",

		//自定义插件
		"myModule" : "./requireJS/js/demo-myModule",

		//插件路径
		"domready" : "./lib/requirejs/domReady",
		"text" : "./lib/requirejs/text",
		"textCss" : "./requireJS/css/testText.css"
	},

	//shim , 加载非规范模块, 每个模块要定义（1）exports值（输出的变量名），表明这个模块外部调用时的名称；（2）deps数组，表明该模块的依赖性。
	shim: {
		//exports值（输出的变量名），
        "underscore" : {
            exports : "_"
        }
		,"angular":{
		    exports: "angular"
	    }
		//deps数组，表明该模块的依赖性
		,"jqueryui" : {
            deps : ["jquery"]
        }
		//也可简写为:  "jquery.form" : ["jquery"]

		,'backbone': {
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'
		}
	}

})

//执行顺序二
require(["myModule"],function(myModule){
    (function(){
        console.log("myModule 第一次加载 完成的回调函数执行 ,这是myModule的返回函数运算结果: " + myModule.add(1,5) +"\n\r 这是弹$的值: "+ $);
    })()
})

//执行顺序三 require可以重复调用, 但是模块只会加载一次;
require(["underscore", "myModule"],function(_, myModule){
    $(function(){
        console.log("underscore 加载 完成的回调函数执行  : " + _);
    })
})

//执行顺序一
//require.js插件  domready插件，可以让回调函数在页面DOM结构加载完成后再运行。
require(['domready!'], function (doc){
	console.log("dom结构加载完成: " + doc);
});

/*
	text插件 html 变量是some/module.html 文件的文本形式  css变量是some/module.css 文件的文本形式
	!strip 尾缀, 对于 HTML/XML/SVG 文件, 它将去除XML申明，这样外部的 SVG 和 XML 文件就能安全地加载到 document 中，
	同样的，如果是 HTML，只有 body 标签内部的部分会被返回
	有跨域问题
*/
require(["myModule", "text!testText.html!strip", "text!textCss"],
    function(module, html, css) {
        console.log(module.add(2,66));
		console.log("css : "+css);
    }
);
