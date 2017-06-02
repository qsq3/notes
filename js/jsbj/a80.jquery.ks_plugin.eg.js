/**
    JQ扩展插件范式
    作者: 空山 112093112@qq.com;
    时间: 2016/10/1
**/
;(function($,window,document,undefined){
    "use strict";

    //默认参数
    var pluginName = "ks_demo",
        defaults = {
            property1 : "value1",
            property2 : "value2"
        }
    
    //构造函数
    function Plugin (element, options){
        this.$element = $(element);
        this.pluginName = pluginName;
        this.settings = $.extend({}, defaults, options);
        this.init();
        
    };

    Plugin.prototype = {
        constructor : Plugin,
        
        init : function(){
            console.log("init");
            this.render();
        },

        render: function(){
            this.settings.renderYellow.call(this.$element);
        }
    
    };

    //JQ接口
    $.fn[pluginName] = function (options){
        return this.each(function(){
            //若dom的data-plugin_ks_demo属性不存在
            if(!$.data(this, 'plugin_'+pluginName)){
                $.data(this, 'plugin_'+pluginName , new Plugin(this, options));
            }

            //若传入options为字符串;
            if($.type(options) === 'string'){
                
            };
        })
    };

})(jQuery,window,document)