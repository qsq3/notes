日期格式化
使用说明
formatDate(date, fmt)，其中fmt支持的格式有：

y（年）
M（月）
d（日）
q（季度）
w（星期）
H（24小时制的小时）
h（12小时制的小时）
m（分钟）
s（秒）
S（毫秒）
另外，字符的个数决定输出字符的长度，如，yy输出16，yyyy输出2016，ww输出周五，www输出星期五，等等。

代码
完整代码一共30行：

/**
 * 将日期格式化成指定格式的字符串
 * @param date 要格式化的日期，不传时默认当前时间，也可以是一个时间戳
 * @param fmt 目标字符串格式，支持的字符有：y,M,d,q,w,H,h,m,S，默认：yyyy-MM-dd HH:mm:ss
 * @returns 返回格式化后的日期字符串
 */
function formatDate(date, fmt)
{
    date = date == undefined ? new Date() : date;
    date = typeof date == 'number' ? new Date(date) : date;
    fmt = fmt || 'yyyy-MM-dd HH:mm:ss';
    var obj =
    {
        'y': date.getFullYear(), // 年份，注意必须用getFullYear
        'M': date.getMonth() + 1, // 月份，注意是从0-11
        'd': date.getDate(), // 日期
        'q': Math.floor((date.getMonth() + 3) / 3), // 季度
        'w': date.getDay(), // 星期，注意是0-6
        'H': date.getHours(), // 24小时制
        'h': date.getHours() % 12 == 0 ? 12 : date.getHours() % 12, // 12小时制
        'm': date.getMinutes(), // 分钟
        's': date.getSeconds(), // 秒
        'S': date.getMilliseconds() // 毫秒
    };
    var week = ['天', '一', '二', '三', '四', '五', '六'];
    for(var i in obj)
    {
        fmt = fmt.replace(new RegExp(i+'+', 'g'), function(m)
        {
            var val = obj[i] + '';
            if(i == 'w') return (m.length > 2 ? '星期' : '周') + week[val];
            for(var j = 0, len = val.length; j < m.length - len; j++) val = '0' + val;
            return m.length == 1 ? val : val.substring(val.length - m.length);
        });
    }
    return fmt;
}
使用示例
formatDate(); // 2016-09-02 13:17:13
formatDate(new Date(), 'yyyy-MM-dd'); // 2016-09-02
// 2016-09-02 第3季度 星期五 13:19:15:792
formatDate(new Date(), 'yyyy-MM-dd 第q季度 www HH:mm:ss:SSS');
formatDate(1472793615764); // 2016-09-02 13:20:15
日期解析
说明
parseDate(str, fmt)，其中fmt支持的格式有：

y（年）
M（月）
d（日）
H（24小时制的小时）
h（12小时制的小时）
m（分钟）
s（秒）
S（毫秒）
完整代码
完整代码共17行：

/**
 * 将字符串解析成日期
 * @param str 输入的日期字符串，如'2014-09-13'
 * @param fmt 字符串格式，默认'yyyy-MM-dd'，支持如下：y、M、d、H、m、s、S，不支持w和q
 * @returns 解析后的Date类型日期
 */
function parseDate(str, fmt)
{
    fmt = fmt || 'yyyy-MM-dd';
    var obj = {y: 0, M: 1, d: 0, H: 0, h: 0, m: 0, s: 0, S: 0};
    fmt.replace(/([^yMdHmsS]*?)(([yMdHmsS])\3*)([^yMdHmsS]*?)/g, function(m, $1, $2, $3, $4, idx, old)
    {
        str = str.replace(new RegExp($1+'(\\d{'+$2.length+'})'+$4), function(_m, _$1)
        {
            obj[$3] = parseInt(_$1);
            return '';
        });
        return '';
    });
    obj.M--; // 月份是从0开始的，所以要减去1
    var date = new Date(obj.y, obj.M, obj.d, obj.H, obj.m, obj.s);
    if(obj.S !== 0) date.setMilliseconds(obj.S); // 如果设置了毫秒
    return date;
}
示例代码
parseDate('2016-08-11'); // Thu Aug 11 2016 00:00:00 GMT+0800
parseDate('2016-08-11 13:28:43', 'yyyy-MM-dd HH:mm:ss') // Thu Aug 11 2016 13:28:43 GMT+0800
其它日期相关方法
其它自己还简单封装了几个方法，这里干脆一起贴出来了，包括上面的：

/**
 * =====================================
 *               日期相关方法
 * =====================================
 */
;(function($)
{
    $.extend(
    {
        /**
         * 将日期格式化成指定格式的字符串
         * @param date 要格式化的日期，不传时默认当前时间，也可以是一个时间戳
         * @param fmt 目标字符串格式，支持的字符有：y,M,d,q,w,H,h,m,S，默认：yyyy-MM-dd HH:mm:ss
         * @returns 返回格式化后的日期字符串
         */
        formatDate: function(date, fmt)
        {
            date = date == undefined ? new Date() : date;
            date = typeof date == 'number' ? new Date(date) : date;
            fmt = fmt || 'yyyy-MM-dd HH:mm:ss';
            var obj =
            {
                'y': date.getFullYear(), // 年份，注意必须用getFullYear
                'M': date.getMonth() + 1, // 月份，注意是从0-11
                'd': date.getDate(), // 日期
                'q': Math.floor((date.getMonth() + 3) / 3), // 季度
                'w': date.getDay(), // 星期，注意是0-6
                'H': date.getHours(), // 24小时制
                'h': date.getHours() % 12 == 0 ? 12 : date.getHours() % 12, // 12小时制
                'm': date.getMinutes(), // 分钟
                's': date.getSeconds(), // 秒
                'S': date.getMilliseconds() // 毫秒
            };
            var week = ['天', '一', '二', '三', '四', '五', '六'];
            for(var i in obj)
            {
                fmt = fmt.replace(new RegExp(i+'+', 'g'), function(m)
                {
                    var val = obj[i] + '';
                    if(i == 'w') return (m.length > 2 ? '星期' : '周') + week[val];
                    for(var j = 0, len = val.length; j < m.length - len; j++) val = '0' + val;
                    return m.length == 1 ? val : val.substring(val.length - m.length);
                });
            }
            return fmt;
        },
        /**
         * 将字符串解析成日期
         * @param str 输入的日期字符串，如'2014-09-13'
         * @param fmt 字符串格式，默认'yyyy-MM-dd'，支持如下：y、M、d、H、m、s、S，不支持w和q
         * @returns 解析后的Date类型日期
         */
        parseDate: function(str, fmt)
        {
            fmt = fmt || 'yyyy-MM-dd';
            var obj = {y: 0, M: 1, d: 0, H: 0, h: 0, m: 0, s: 0, S: 0};
            fmt.replace(/([^yMdHmsS]*?)(([yMdHmsS])\3*)([^yMdHmsS]*?)/g, function(m, $1, $2, $3, $4, idx, old)
            {
                str = str.replace(new RegExp($1+'(\\d{'+$2.length+'})'+$4), function(_m, _$1)
                {
                    obj[$3] = parseInt(_$1);
                    return '';
                });
                return '';
            });
            obj.M--; // 月份是从0开始的，所以要减去1
            var date = new Date(obj.y, obj.M, obj.d, obj.H, obj.m, obj.s);
            if(obj.S !== 0) date.setMilliseconds(obj.S); // 如果设置了毫秒
            return date;
        },
        /**
         * 将一个日期格式化成友好格式，比如，1分钟以内的返回“刚刚”，
         * 当天的返回时分，当年的返回月日，否则，返回年月日
         * @param {Object} date
         */
        formatDateToFriendly: function(date)
        {
            date = date || new Date();
            date = typeof date === 'number' ? new Date(date) : date;
            var now = new Date();
            if((now.getTime() - date.getTime()) < 60*1000) return '刚刚'; // 1分钟以内视作“刚刚”
            var temp = this.formatDate(date, 'yyyy年M月d');
            if(temp == this.formatDate(now, 'yyyy年M月d')) return this.formatDate(date, 'HH:mm');
            if(date.getFullYear() == now.getFullYear()) return this.formatDate(date, 'M月d日');
            return temp;
        },
        /**
         * 将一段时长转换成友好格式，如：
         * 147->“2分27秒”
         * 1581->“26分21秒”
         * 15818->“4小时24分”
         * @param {Object} second
         */
        formatDurationToFriendly: function(second)
        {
            if(second < 60) return second + '秒';
            else if(second < 60*60) return (second-second%60)/60+'分'+second%60+'秒';
            else if(second < 60*60*24) return (second-second%3600)/60/60+'小时'+Math.round(second%3600/60)+'分';
            return (second/60/60/24).toFixed(1)+'天';
        },
        /** 
         * 将时间转换成MM:SS形式 
         */
        formatTimeToFriendly: function(second)
        {
            var m = Math.floor(second / 60);
            m = m < 10 ? ( '0' + m ) : m;
            var s = second % 60;
            s = s < 10 ? ( '0' + s ) : s;
            return m + ':' + s;
        },
        /**
         * 判断某一年是否是闰年
         * @param year 可以是一个date类型，也可以是一个int类型的年份，不传默认当前时间
         */
        isLeapYear: function(year)
        {
            if(year === undefined) year = new Date();
            if(year instanceof Date) year = year.getFullYear();
            return (year % 4 == 0 && year % 100 != 0) || (year % 400 == 0);
        },
        /**
         * 获取某一年某一月的总天数，没有任何参数时获取当前月份的
         * 方式一：$.getMonthDays();
         * 方式二：$.getMonthDays(new Date());
         * 方式三：$.getMonthDays(2013, 12);
         */
        getMonthDays: function(date, month)
        {
            var y, m;
            if(date == undefined) date = new Date();
            if(date instanceof Date)
            {
                y = date.getFullYear();
                m = date.getMonth();
            }
            else if(typeof date == 'number')
            {
                y = date;
                m = month-1;
            }
            var days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; // 非闰年的一年中每个月份的天数
            //如果是闰年并且是2月
            if(m == 1 && this.isLeapYear(y)) return days[m]+1;
            return days[m];
        },
        /**
         * 计算2日期之间的天数，用的是比较毫秒数的方法
         * 传进来的日期要么是Date类型，要么是yyyy-MM-dd格式的字符串日期
         * @param date1 日期一
         * @param date2 日期二
         */
        countDays: function(date1, date2)
        {
            var fmt = 'yyyy-MM-dd';
            // 将日期转换成字符串，转换的目的是去除“时、分、秒”
            if(date1 instanceof Date && date2 instanceof Date)
            {
                date1 = this.format(fmt, date1);
                date2 = this.format(fmt, date2);
            }
            if(typeof date1 === 'string' && typeof date2 === 'string')
            {
                date1 = this.parse(date1, fmt);
                date2 = this.parse(date2, fmt);
                return (date1.getTime() - date2.getTime()) / (1000*60*60*24);
            }
            else
            {
                console.error('参数格式无效！');
                return 0;
            }
        }
    });
})(jQuery);



(function(window){
var utils = window.utils || {};
window.utils = utils;
utils.str = utils.str || {};
utils.arr = utils.arr || {};
/**   
* 对Date的扩展，将 Date 转化为指定格式的String   
* 月(M)、日(d)、12小时(h)、24小时(H)、分(m)、秒(s)、周(E)、季度(q) 可以用 1-2 个占位符   
* 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)   
* eg:   
* utils.str.pattern(new Date(),"yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423   
* utils.str.pattern(new Date(),"yyyy-MM-dd E HH:mm:ss") ==> 2009-03-10 二 20:09:04   
* utils.str.pattern(new Date(),"yyyy-MM-dd EE hh:mm:ss") ==> 2009-03-10 周二 08:09:04   
* utils.str.pattern(new Date(),"yyyy-MM-dd EEE hh:mm:ss") ==> 2009-03-10 星期二 08:09:04   
* utils.str.pattern(new Date(),"yyyy-M-d h:m:s.S") ==> 2006-7-2 8:9:4.18   
*/

utils.str.patternTime = function (str, fmt) {
    var o = {
        "M+": str.getMonth() + 1, //月份     
        "d+": str.getDate(), //日     
        "h+": str.getHours() % 12 === 0 ? 12 : str.getHours() % 12, //小时     
        "H+": str.getHours(), //小时     
        "m+": str.getMinutes(), //分     
        "s+": str.getSeconds(), //秒     
        "q+": Math.floor((str.getMonth() + 3) / 3), //季度     
        "S": str.getMilliseconds() //毫秒     
    },
        week = {
            "0": "\u65e5",
            "1": "\u4e00",
            "2": "\u4e8c",
            "3": "\u4e09",
            "4": "\u56db",
            "5": "\u4e94",
            "6": "\u516d"
        };
    if (/(y+)/.test(fmt)) {
        fmt = fmt.replace(RegExp.$1, (str.getFullYear() + "").substr(4 - RegExp.$1.length));
    }
    if (/(E+)/.test(fmt)) {
        fmt = fmt.replace(RegExp.$1, ((RegExp.$1.length > 1) ? (RegExp.$1.length > 2 ? "\u661f\u671f" : "\u5468") : "") + week[str.getDay() + ""]);
    }
    for (var k in o) {
        if (new RegExp("(" + k + ")").test(fmt)) {
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        }
    }
    return fmt;
};
utils.str.toDateTime = function (str, dateformat) {
    var date = new Date(parseInt(str.replace("/Date(", "").replace(")/", ""), 10));
    var month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1,
        currentDate = date.getDate() < 10 ? "0" + date.getDate() : date.getDate(),
        hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours(),
        minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes(),
        seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();

    if (dateformat == "yyyy-mm-dd") {
        return date.getFullYear() + "-" + month + "-" + currentDate;
    }
    return date.getFullYear() + "-" + month + "-" + currentDate + " " + hours + ":" + minutes + ":" + seconds;
};
utils.str.htmlEncode = function (str) {
    return str.replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        //s = s.replace(/ /g, "&nbsp;");
        .replace(/'/g, "&apos;")
        .replace(/\"/g, "&quot;")
        .replace(/\\/g, "&#92;");
};
utils.str.htmlDecode = function (str) {
    return str.replace(/&amp;/g, "&")
         .replace(/&lt;/g, "<")
         .replace(/&gt;/g, ">")
    //s = s.replace(/&nbsp;/g, " ");
        .replace(/&#39;/g, "\'")
        .replace(/&quot;/g, "\"")
        .replace(/&#92;/g, '\\');
};
utils.str.cutStrings = function (str, length, hasEllipsis) {
    var newStr;
    if (str.length <= length)
        newStr = str;
    else
        newStr = str.substr(0, length);
    if (hasEllipsis) {
        newStr += "...";
    }
    return newStr;
};
utils.str.trim = function (val) {
    var str = this && this.toString();
    if (!val) {
        return str == '' ? str : str.replace(/(^\s*)/g, '').replace(/(\s*$)/g, '');
    }
    var s = new RegExp('^' + val + '*', 'g'), e = new RegExp(val + '*$', 'g');
    return str == '' ? str : str.replace(s, '').replace(e, '');
};
utils.str.ParseFloatAndToFixed = function (str, i) {
    return parseFloat(parseFloat(str).toFixed(i));
};
utils.str.isNullOrWhiteSpace = function (str) {
    // null、 ''、'   '、undefinded  →→return true
    return str == '' || str.trim() == '';
};
utils.str.startsWith = function (str, start, ignoreCase) { //start：欲判断字符， ignoreCase：是否忽略大小写
    if (str.isNullOrWhiteSpace()) {
        return false;
    }
    if (ignoreCase) {
        str = str.toLowerCase();
        start = start.toLowerCase();
    }
    return str.indexOf(start) == 0;
    //return s.isNullOrWhiteSpace() ? false : (ignoreCase && (s = s.toLowerCase(), start = start.toLowerCase()), s.substr(0, start.length) == start) ? true : false;
};
utils.str.endsWith = function (str, end, ignoreCase) { //end：欲判断字符， ignoreCase：是否忽略大小写
    if (str.isNullOrWhiteSpace()) {
        return false;
    }
    if (ignoreCase) {
        str = str.toLowerCase();
        end = end.toLowerCase();
    }
    if (str.substr(str.length - end.length) == end) { return true; }
    return false;
};
utils.str.contains = function (str, arg) {
    return !!~str.indexOf(arg);
};
utils.str.formatString = function () {
    for (var i = 1, len = arguments.length; i < len ; i++) {
        var exp = new RegExp('\\{' + (i - 1) + '\\}', 'gm');
        arguments[0] = arguments[0].replace(exp, arguments[i]);
    }
    return arguments[0];
};
//数据中是否包括指定对象
utils.arr.contain = function (arr, fun) {
    for (var item in arr) {
        if (fun.constructor == Function) {
            if (fun(item)) return true;
        }
    }
    return false;
};
utils.arr.get = function (arr, fun) {
    for (var i in arr) {
        if (fun.constructor == Function) {
            if (fun(this[i])) return this[i];
        }
    }
    return null;
};
utils.arr.del = function (arr, n) { //n表示第几项，从0开始算起。
    //prototype为对象原型，注意这里为对象增加自定义方法的方法。
    if (n > arr.length - 1) {
        return arr;
    } else {
        //return  n < 0 ? this : this.slice(0, n).concat(this.slice(n + 1, this.length)); 
        var r = n < 0 ? arr : arr.splice(n, 1);//splice 先删除一段，再添加一段元素splice(开始，长度)  ，替换；//xj 
        return arr;
    }
    /*
　　　concat方法：返回一个新数组，这个新数组是由两个或更多数组组合而成的。
　　　　　　　　　这里就是返回this.slice(0,n)/this.slice(n+1,this.length)
　　 　　　　　　组成的新数组，这中间，刚好少了第n项。
　　　slice方法： 返回一个数组的一段，两个参数，分别指定开始和结束的位置。
　　*/
};
utils.arr.removeByValue = function (arr, val) {
    if (!val) {
        return arr;
    }
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] == val) {
            return arr.del(i);
        }
    }
    return arr;
};
utils.arr.indexOf = function (arr, item, strict) { //strict：是否严格相等（===）
    var index = -1,
        length = arr.length;
    strict = strict ? true : false,
    i = 0;
    if (strict) {
        for (; i < length; i++) {
            if (arr[i] === item) {
                index = i;
                break;
            }
        }
    } else {
        for (i = 0; i < length; i++) {
            if (arr[i] == item) {
                index = i;
                break;
            }
        }
    }
    return index;
};


utils.GetRandomUrl = function (url) { //为url添加随机数
    url = url || window.location.href;
    return ~url.indexOf("?") ? url + "&r=" + Math.random() : url + "?r=" + Math.random();
},
utils.Open = function (url) {
    window.open(url);
};
utils.RedirectTo = function (url) { //跳转页面
    window.location.href = url;
    window.event ? window.event.returnValue = false : event.preventDefault(); //for firefox 
};
utils.Cookie = function (cookieName, cookieValue, options) {
    options = options || { path: '/' };
    return $.cookie(cookieName, cookieValue, options);
};
utils.GetUrlParam = function (name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return unescape(r[2]);
    return null;
};
//解决上一个获取中文参数 encodeURI 乱码
utils.GetUrlParam2 = function (paras) {
    var url = location.href,
        paraString = url.substring(url.indexOf("?") + 1, url.length).split("&"),
        paraObj = {},
        j;
    for (var i = 0; j = paraString[i]; i++) {
        paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=") + 1, j.length);
    }
    var returnValue = paraObj[paras.toLowerCase()];
    if (typeof (returnValue) == "undefined") {
        return "";
    } else {
        return returnValue;
    }
};
utils.SetUrlParam = function (name, value, url) {
    url = url ? url : window.location.href;
    var re = new RegExp("(^|&|\\?)" + name + "=([^&]*)(&|$)", "ig"),
        m = url.match(re);
    if (m) {
        return (url.replace(re, function ($0, $1, $2, $3) {
            if (value == undefined || value.isNullOrWhiteSpace()) {
                return $1 == '?' ? $1 : $3; //return ''; 20130910 xj 修正
            } else {
                return ($0.replace($2, value));
            }
        }));
    } else {
        if (value == undefined || value.toString().isNullOrWhiteSpace()) {
            return url;
        } else {
            if (url.indexOf('?') == -1)
                return (url + '?' + name + '=' + value);
            else
                return (url + '&' + name + '=' + value);
        }
    }
};
//设置标签获得焦点时键盘按下事件
utils.SetOnKeyUp = function (tag, opts) {
    opts = jQuery.extend({
        call: function () { return false; },
        params: -1
    }, opts || {});
    $(tag).on("focus", function () {
        this.keyup = function (e) {
            var keycode;
            if (navigator.appName == "Microsoft Internet Explorer") {
                keycode = event.keyCode;
            } else {
                keycode = e.which;
            }
            if (keycode == 13) {
                if (opts.params > 0)
                    opts.call(opts.params);
                else
                    opts.call();
            }
        };
    });
    $(tag).on("blur", function () {
        this.onkeyup = function () {
            return false;
        };
    });
};
utils.ClearForms = function (form) {
    var fr = form || 'body';
    $(':input', $(fr)).each(function () {
        var type = this.type,
            tag = this.tagName.toLowerCase();
        if (type == 'text' || type == 'password' || tag == 'textarea')
            this.value = "";
        else if (type == 'checkbox' || type == 'radio')
            this.checked = false;
        else if (tag == 'select')
            this.selectedIndex = -1;
    });
};
utils.LoadJs = function (path, callback) {
    callback = !(typeof (callback) == "undefined") ? callback : function () {
    };
    var oHead = document.getElementsByTagName('HEAD').item(0);
    var script = document.createElement("script");
    script.type = "text/javascript";
    if (script.readyState) { //IE
        script.onreadystatechange = function () {
            if (script.readyState == "loaded" || script.readyState == "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else { //Others: Firefox, Safari, Chrome, and Opera
        script.onload = function () {
            callback();
        };
    }
    script.src = path + ".js";
    oHead.appendChild(script);
};
utils.LoadCss = function (path) {
    if (!path) {
        throw new Error('argument "path" is required !');
    }
    var head = document.getElementsByTagName('head')[0];
    var links = document.createElement('link');
    links.href = path + ".css";
    links.rel = 'stylesheet';
    links.type = 'text/css';
    head.appendChild(links);
};

//元素操作相关
utils.HtmlUtils = ((function () {
    function getElementPosition(e) {
        var x = 0, y = 0;
        while (e != null) {
            x += e.offsetLeft | 0;
            y += e.offsetTop | 0;
            e = e.offsetParent;
        }
        return { x: x, y: y };
    }
    function getViewPortSize(w) {
        w = w || window;
        if (w.innerWidth != null) return { w: w.innerWidth, h: w.innerHeight };
        var d = w.document;
        if (document.compatMode == "CSS1Compat")
            return { w: d.documentElement.clientWidth, h: d.documentElement.clientHeight };
        return { w: d.body.clientWidth, h: d.body.clientHeight };
    }
    function getScrollOffsets(w) {
        w = w || window;
        if (w.pageXoffset != null) {
            return { x: w.pageXoffset, y: w.pageYoffset };
        }
        var d = w.document;
        if (document.compatMode == "CSS1Compat")
            return { x: d.documentElement.scrollLeft, y: d.documentElement.scrollTop };
        return { x: d.body.scrollLeft, y: d.body.scrollTop };
    }
    function getMousePos(event) {
        var e = event || window.event,
            scroll = getScrollOffsets(),
            x = e.pageX || e.clientX + scroll.x,
            y = e.pageY || e.clientY + scroll.y;
        return { 'x': x, 'y': y };
    }
    function getRect(element) {
        var rect = element.getBoundingClientRect();
        if (typeof rect.width === 'undefined') {
            return {
                width: rect.right - rect.left,
                height: rect.bottom - rect.top,
                top: rect.top,
                bottom: rect.bottom,
                left: rect.left,
                right: rect.right
            };
        }
        return rect;
    }
    function getElementCenterPos(obj, cfg) {
        var $obj = $(obj);
        cfg = cfg || {};
        cfg.maxWidth = cfg.maxWidth || 900;
        cfg.maxHeight = cfg.maxHeight || 800;
        var ww = $obj.width(), //window width
                wh = $obj.height(),
                sch = $(window).height() | 0, //scree clientHeight
                scw = $(window).width() | 0,
                height = wh < sch - 20 && wh > cfg.maxWidth + 20 ? cfg.maxHeight : sch - 20,
                width = ww < scw - 20 && ww > cfg.maxHeight + 20 ? cfg.maxWidth : scw - 20;
        width = width >= cfg.maxWidth ? cfg.maxWidth : width;
        height = height >= cfg.maxHeight ? cfg.maxHeight : height;
        var left = width < scw - 20 ? (scw - width) / 2 : 10,
            top = height < sch - 20 ? (sch - height) / 2 : 10;
        return {
            width: width,
            height: height,
            left: left,
            top: top
        };
    }
    return {
        getElementPosition: getElementPosition,
        getViewPortSize: getViewPortSize,
        getScrollOffsets: getScrollOffsets,
        getMousePos: getMousePos,
        getRect: getRect,
        getElementCenterPos: getElementCenterPos
    };
})());
 
//对$.ajax的封装 
utils.Ajax = function (url, data, callback, cfg) {
    cfg = (cfg || {});
    cfg.hasOwnProperty("async") || (cfg.async = "true");
    cfg.hasOwnProperty("type") || (cfg.type = "post");
    cfg.hasOwnProperty("cache") || (cfg.cache = true);
    cfg.hasOwnProperty("dataType") || (cfg.dataType = "json");//预期服务器返回的数据类型  xml, json, script, or html
    //if (!cfg.hasOwnProperty("contentType")) cfg.contentType = "application/json; charset=utf-8";//发送信息至服务器时内容编码类型。默认值是"application/x-www-form-urlencoded; 
    //cfg.hasOwnProperty("headers") || (cfg.headers = {
    //    "contentType": "application/json; charset=utf-8",
    //    "token": WebJs.Utils.GetCookie('Token') || "token"
    //});
    //if (cfg.hasOwnProperty("crossDomain")) {
    //url = url + (~(url.indexOf("?") >) ? "&" : "?") + "jsonpCallback=?";
    // }
    if (!callback) {
        callback = function () {
        };
    }
    //如果extend存在，证明加载了easyui的，如果不就没有加载easyui 相应的代码就不应该执行
    var extend = WebJs.EasyUiExtend;
    //声明opts 方便调试
    var opts = {
        type: cfg.type,
        url: url,
        async: cfg.async,
        data: data,
        cache: cfg.cache,
        timeout: 6e4,//60000
        //headers: cfg.headers,
        dataType: cfg.dataType,
        //contentType: cfg.contentType,
        beforeSend: cfg.hasOwnProperty("before") ? cfg.before : function () { },
        success: function (result, textStatus, jqXHR) {
            /*if (!!result) {
                try {
                    if (!!result.Type && result.Type == "string") {
                        result = result.Str;
                    }
                } catch (e) {
                }
            }*/
            extend && extend.ajaxLoadEnd();
            if (textStatus == 'success') {
                //setHeader(jqXHR);
                callback(result, jqXHR);
            } else {
                alert('服务端错误');
            }
        },
        error: function (xmlHttpRequest, textStatus, errorThrow) {
            extend && extend.ajaxLoadEnd();
            extend && WebJs.Common.ShowErrors(xmlHttpRequest, textStatus, errorThrow);
        }
    };
    extend && extend.ajaxLoading();
    $.ajax(opts);
};
//内部调用WebJs.Ajax，这里统一处理返回结果的状态
utils.AjaxHandle = function (url, data, callback, cfg) {
    WebJs.Ajax(url, data, function (result, jqXHR) {
        (result && result.Success)
            ? callback(result, jqXHR)
            : WebJs.Dialog.Content(result.Message);
    }, cfg);
};


 //对弹出框做封装 
//以下代码是对ArtDialog(一个弹出框插件)的封装，以方便我们在项目中使用 
//ArtDialog对话框
WebJs.ArtDialog = {
    Tip: function (msg, cfg) {
        cfg || (cfg = {});
        //if (cfg.hasOwnProperty("type") == false) cfg.type = 'warn';
        cfg.hasOwnProperty("lock") || (cfg.fixed = false);
        cfg.hasOwnProperty("fixed") || (cfg.fixed = true);
        cfg.hasOwnProperty("time") || (cfg.time = 1500);
        cfg.hasOwnProperty("title") || (cfg.title = '提示');
        //cfg.content = '<div class="' + cfg.type + '"><img src="/content/image/icon/' + cfg.type + '.gif" class="tips_img">' + msg + "</div>";
        cfg.content = msg;
        return art.dialog(cfg);
    },
    Alert: function (msg, cfg) {
        cfg || (cfg = {});
        cfg.content = msg;
        cfg.hasOwnProperty("lock") || (cfg.lock = "true");
        cfg.hasOwnProperty("fixed") || (cfg.fixed = "true");
        cfg.hasOwnProperty("title") || (cfg.title = "友情提示:");
        return art.dialog(cfg);
    },
    Confirm: function (content, yes, no) {
        var cfg = {
            button: [{
                value: '确定',
                focus: true,
                callback: function () {
                    if (yes && typeof yes == 'function') {
                        yes();
                    }
                    return true;
                }
            }, {
                id: 'button-cancel',
                value: '取消',
                callback: function () {
                    if (no && typeof no == 'function') {
                        no();
                    }
                    return true;//return no&& typeof no == "function" && no(), true;
                }
            }]
        };
        cfg.content = content || 'load……';
        cfg.title = '友情提示';
        return art.dialog(cfg).lock();
    },
    Content: function (content, cfg) {
        cfg || (cfg = {});
        cfg.hasOwnProperty("lock") || (cfg.lock = "true");
        cfg.hasOwnProperty("fixed") || (cfg.fixed = "true");
        cfg.hasOwnProperty("title") || (cfg.title = "友情提示");
        return art.dialog(cfg).content(content);
    },
    Close: function (id) {
        if (id) {
            art.dialog.list(id).close();
        }
        else {
            var list = art.dialog.list;
            for (var i in list) {
                list[i].close();
            }
        }
    }
};

 
 //以下代码是对EasyUi弹窗 的封装  
var WebJs = window.WebJs || WebJs || {};
//对话框 基于EasyUI
WebJs.Dialog = (function () {
    function handleCfg(cfg) {
        WebJs.Data.isOpen = true;//夹杂外部逻辑了
        cfg || (cfg = {});
        cfg.hasOwnProperty("title") || (cfg.title = 'Title' + (+new Date()));
        cfg.hasOwnProperty("modal") || (cfg.modal = true);
        cfg.hasOwnProperty("minimizable") || (cfg.minimizable = false);
        cfg.hasOwnProperty("maximizable") || (cfg.maximizable = true);
        cfg.hasOwnProperty("shadow") || (cfg.shadow = false);
        cfg.hasOwnProperty("cache") || (cfg.cache = false);
        cfg.inline = cfg.inline || true;
        cfg.closed = cfg.closed || false;
        cfg.collapsible = cfg.collapsible || true;
        cfg.resizable = cfg.resizable || true;
        cfg.height = cfg.height || 400;
        cfg.width = cfg.width || 680;
        //控制窗口大小， 当屏幕窗口较小的时候缩小窗口，否则设置为默认
        var wh = $(window).height(),
            ww = $(window).width(),
            height = cfg.height,//cfg.height < wh - 20 && wh > 420 ? 400 : wh - 20,
            width = cfg.width,//cfg.width < ww - 20 && ww > 700 ? 680 : ww - 20,
            left = width < ww - 20 ? (ww - width) / 2 : 10,
            top = height < wh - 20 ? (wh - height) / 2 : 10;
        cfg.height = height;
        cfg.width = width;
        cfg.left = cfg.left || left;
        cfg.top = cfg.top || top;
        return cfg;
    }
    var loadingMessage = '正在加载数据，请稍等片刻......';
    return {
        Tip: function (msg, cfg) {
            var opts = {
                title: '友情提示',
                msg: msg || 'No Msg',
                showType: 'fade',
                timeout: 1500,
                style: {
                    right: '',
                    bottom: ''
                },
                closable: false
            };
            cfg || (cfg = {});
            cfg.hasOwnProperty("title") && (opts.title = cfg.title);
            cfg.hasOwnProperty("width") && (opts.width = cfg.width);
            cfg.hasOwnProperty("timeout") && (opts.timeout = cfg.timeout);
            cfg.hasOwnProperty("showType") && (opts.showType = cfg.showType);
            $.messager.show(opts);
            return false;
        },
        //icon--error,question,info,warning
        //fn：当窗口关闭时触发的回调函数
        Alert: function (msg, icon, fn) {
            $.messager.alert("友情提示:", msg, icon || 'warning', fn);
        },
        //dialog
        AlertDialog: function (id, cfg) {
            var opts = {
                title: '提示框',
                width: 500,
                height: 400,
                cache: false,
                modal: true,
                maximizable: true,
                collapsible: true,
                resizable: true
            };
            cfg || (cfg = {});
            cfg.hasOwnProperty('title') && (opts.title = cfg.title);
            cfg.hasOwnProperty('width') && (opts.width = cfg.width);
            cfg.hasOwnProperty('height') && (opts.height = cfg.height);
            cfg.hasOwnProperty('href') && (opts.href = cfg.href);
            cfg.hasOwnProperty('toolbar') && (opts.toolbar = cfg.toolbar);
            cfg.hasOwnProperty('buttons') && (opts.buttons = cfg.buttons);
            $(id).dialog(opts);
        },
        Confirm: function (content, yes, no) {
            $.messager.confirm("友情提示:", content, function (r) {
                r ? yes() : (typeof no === 'function' && no());
            });
        },
        Content: function (content, cfg, id) {
            cfg = handleCfg(cfg);
            cfg.content = content;
            cfg.loadingMessage = loadingMessage;
            id = id || 'myWindow';
            var oldWindow = $('#' + id), dlg;
            if (oldWindow) {
                dlg = oldWindow;
            } else {
                dlg = $('<div id="' + id + '" class="easyui-window" closed="true"></div>');
                $('body').append(dlg);
            }
            dlg.window(cfg);
            dlg.window('open');
        },
        Open: function (url, cfg, id) {
            cfg = handleCfg(cfg);
            cfg.content = '<iframe scrolling="yes" frameborder="0" src="' + url + '" style="width:100%;height:98%"></iframe>';
            cfg.loadingMessage = loadingMessage;
            id || (id = 'myWindow');
            $('#' + id + '').window(cfg);
            var ieset = navigator.userAgent;
            if (~ieset.indexOf("MSIE 6.0") || ~ieset.indexOf("MSIE 7.0") || ~ieset.indexOf("MSIE 8.0") || ~ieset.indexOf("MSIE 9.0")) {
                setTimeout(function () { $('#' + id + '').window(cfg); }, 0);
            }
        },
        Close: function (id) {
            id || (id = 'myWindow');
            $('#' + id + '').window('close');
            WebJs.Data.isOpen = false;
        }
    };
})();

/*
 关于弹出框插件有很多，这里推荐一个找查件的网址http://www.open-lib.com/   里面的插件进行了分类，很方便我们查找。

对弹出框做封装是进一步方便我们在项目中使用，方便以后更换提示弹框插件。这里其也是为了避免大量的重复代码，本人最见不得重复代码，遇到感觉是重复在写的代码，就会想办法去做封装，当然这个是建立在不牺牲较大性能之上的。 
*/
//常用的验证方法 
utils.Regexp = {
    //email的判断
    Ismail: function (mail) {
        var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        return reg.test(mail);
        //  return (new RegExp(/^\w+((-\w+)|(\.\w+))*\-AT-[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail));
    },
    //验证身份证
    IsIdCardNo: function (num) {
        var factorArr = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1];
        var error,
            varArray = [],
            lngProduct = 0,
            intCheckDigit,
            intStrLen = num.length,
            idNumber = num;
        if ((intStrLen != 15) && (intStrLen != 18)) {
            return false;
        }
        for (var i = 0; i < intStrLen; i++) {
            varArray[i] = idNumber.charAt(i);
            if ((varArray[i] < '0' || varArray[i] > '9') && (i != 17)) {
                return false;
            } else if (i < 17) {
                varArray[i] = varArray[i] * factorArr[i];
            }
        }
        if (intStrLen == 18) {
            var date8 = idNumber.substring(6, 14);
            // ReSharper disable UseOfImplicitGlobalInFunctionScope
            if (checkDate(date8) == false) {
                // ReSharper restore UseOfImplicitGlobalInFunctionScope
                return false;
            }
            for (i = 0; i < 17; i++) {
                lngProduct = lngProduct + varArray[i];
            }
            intCheckDigit = 12 - lngProduct % 11;
            switch (intCheckDigit) {
                case 10:
                    intCheckDigit = 'X';
                    break;
                case 11:
                    intCheckDigit = 0;
                    break;
                case 12:
                    intCheckDigit = 1;
                    break;
            }
            if (varArray[17].toUpperCase() != intCheckDigit) {
                return false;
            }
        } else {
            var date6 = idNumber.substring(6, 12);
            // ReSharper disable UseOfImplicitGlobalInFunctionScope
            if (checkDate(date6) == false) {
                // ReSharper restore UseOfImplicitGlobalInFunctionScope
                return false;
            }
        }
        return true;
    },
    //校验密码：只能输入6-15个字母、数字
    IsPasswd: function (s) {
        var patrn = /^[a-zA-Z0-9]{6,15}$/;
        return patrn.exec(s);
    },
    //校验手机号码：必须以数字开头
    IsMobile: function (s) {
        //00852验证香港区号
        var patrn = /^(13[0-9]|15[012356789]|18[0236789]|14[57]|00852)[0-9]{8}$/;
        return patrn.test(s);
    },
    //1-16个中文
    IsChinese: function (s) {
        var patrn = /^[a-zA-Z\u4E00-\u9FA5]{2,16}$/;
        return !!patrn.exec(s);
    },
    //检查email邮箱
    IsEmail: function (str) {
        var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
        //var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        return reg.test(str);
    },
    //中英文数字下划线1-num个字符
    IsAccount: function (str, num) {
        var reg;
        if (num == 30)
            reg = /^[a-zA-Z0-9_\u4e00-\u9fa5]{1,30}$/;
        else if (num == 510)
            reg = /^[a-zA-Z0-9_\u4e00-\u9fa5]{1,510}$/;
        //var reg = /^[a-zA-Z0-9_]{6,16}$/;
        return reg.test(str);
    },
    //检查长度
    CheckLength: function checkLength(obj, maxlength) {
        if (obj.value.length > maxlength) {
            obj.value = obj.value.substring(0, maxlength);
        }
    },
    IsURL: function (strUrl) {
        var regular = /^\b(((https?|ftp):\/\/)?[-a-z0-9]+(\.[-a-z0-9]+)*\.(?:com|edu|gov|int|mil|net|org|biz|info|name|museum|asia|coop|aero|[a-z][a-z]|((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]\d)|\d))\b(\/[-a-z0-9_:\@&?=+,.!\/~%\$]*)?)$/i;
        return regular.test(strUrl);
    },
    //判断是否有列表中的危险字符
    IsValidReg: function (chars) {
        var re = /<|>|\[|\]|\{|\}|『|』|※|○|●|◎|§|△|▲|☆|★|◇|◆|□|▼|㊣|﹋|⊕|⊙|〒|ㄅ|ㄆ|ㄇ|ㄈ|ㄉ|ㄊ|ㄋ|ㄌ|ㄍ|ㄎ|ㄏ|ㄐ|ㄑ|ㄒ|ㄓ|ㄔ|ㄕ|ㄖ|ㄗ|ㄘ|ㄙ|ㄚ|ㄛ|ㄜ|ㄝ|ㄞ|ㄟ|ㄢ|ㄣ|ㄤ|ㄥ|ㄦ|ㄧ|ㄨ|ㄩ|■|▄|▆|\*|@|#|\^|\\/;
        return re.test(chars) != true;
    }
};

//浏览器判断的封装
WebJs.UsersBrowser = (function () {
    var ua = navigator.userAgent.toLowerCase(); //获取用户端信息
    var info = {
        version: ua.match(/(?:firefox|opera|safari|chrome|msie)[\/: ]([\d.]+)/)[1],
        ie: /msie/.test(ua) && !/opera/.test(ua),  //匹配IE浏览器
        op: /opera/.test(ua),  //匹配Opera浏览器
        sa: /version.*safari/.test(ua),  //匹配Safari浏览器
        ch: /chrome/.test(ua),  //匹配Chrome浏览器
        ff: /firefox/.test(ua) && !/webkit/.test(ua)  //匹配Firefox浏览器
    };
    return info;
})(WebJs);

})(window)



//另一个库
var GLOBAL = {};
GLOBAL.namespace = function(str) {
  var arr = str.split("."), o = GLOBAL,i;
  for (i = (arr[0] = "GLOBAL") ? 1 : 0; i < arr.length; i++) {
    o[arr[i]] = o[arr[i]] || {};
    o = o[arr[i]];
  }
};
//Dom相关
GLOBAL.namespace("Dom");
 
GLOBAL.Dom.getNextNode = function (node) {
  node = typeof node == "string" ? document.getElementById(node) : node;
  var nextNode = node.nextSibling;
  if (!nextNode) {
    return null;
  }
  if (!document.all) {
    while (true) {
      if (nextNode.nodeType == 1) {
        break;
 
      } else {
        if (nextNode.nextSibling) {
          nextNode = nextNode.nextSibling;
        } else {
          break;
        }
      }
    }
    return nextNode;
  }
}
 
GLOBAL.Dom.setOpacity = function(node, level) {
  node = typeof node == "string" ? document.getElementById(node) : node;
  if (document.all) {
    node.style.filter = 'alpha(opacity=' + level + ')';
  } else {
    node.style.opacity = level / 100;
  }
};
 
GLOBAL.Dom.getElementsByClassName = function (str, root, tag) {
  if (root) {
    root = typeof root == "string" ? document.getElementById(root) : root;
  } else {
    root = document.body;
  }
  tag = tag || "*";
  var els = root.getElementsByTagName(tag), arr = [];
  for (var i = 0, n = els.length; i < n; i++) {
    for (var j = 0, k = els[i].className.split(" "), l = k.length; j < l; j++) {
      if (k[j] == str) {
        arr.push(els[i]);
        break;
      }
    }
  }
  return arr;
}
GLOBAL.namespace("Event");
GLOBAL.Event.stopPropagation = function(e) {
  e = window.event || e;
  if (document.all) {
    e.cancelBubble = true;
  } else {
    e.stopPropagation();
  }
};
GLOBAL.Event.getEventTarget = function(e) {
  e = window.event || e;
  return e.srcElement || e.target;
};
 
GLOBAL.Event.on = function(node, eventType, handler) {
  node = typeof node == "string" ? document.getElementById(node) : node;
  if (document.all) {
    node.attachEvent("on" + eventType, handler);
  } else {
    node.addEventListener(eventType, handler, false);
  }
};
 
//Lang相关
GLOBAL.namespace("Lang");
GLOBAL.Lang.trim = function(ostr) {
  return ostr.replace(/^\s+|\s+$/g, "");
};
 
GLOBAL.Lang.isNumber = function(s) {
  return !isNaN(s);
};
 
function isString(s) {
  return typeof s === "string";
}
 
 
 
function isBoolean(s) {
  return typeof s === "boolean";
}
 
function isFunction(s) {
  return typeof s === "function";
}
 
function isNull(s) {
  return s === null;
}
 
function isUndefined(s) {
  return typeof s === "undefined";
}
 
function isEmpty(s) {
  return /^\s*$/.test(s);
}
 
function isArray(s) {
  return s instanceof Array;
}
 
GLOBAL.Dom.get = function (node) {
  node = typeof node === "string" ? document.getElementById(node) : node;
  return node;
}
 
function $(node) {
  node = typeof node == "string" ? document.getElementById(node) : node;
  return node;
}
 
 
GLOBAL.Lang.extend = function(subClass, superClass) {
  var F = function() {
  };
  F.prototype = superClass.prototype;
  subClass.prototype = new F();
  subClass.prototype.constructor = subClass;
  subClass.superClass = subClass.prototype;
  if (superClass.prototype.constructor == Object.prototype.constructor) {
    superClass.prototype.constructor = superClass;
  }
};
 
GLOBAL.namespace("Cookie");
GLOBAL.Cookie = {
  read: function (name) {
    var cookieStr = ";" + document.cookie + ";";
    var index = cookieStr.indexOf(";" + name + "=");
    if (index != -1) {
      var s = cookieStr.substring(index + name.length + 3, cookieStr.length);
      return unescape(s.substring(0, s.indexOf(";")));
    } else {
      return null;
    }
  },
  set: function (name, value, expires) {
    var expDays = expires * 24 * 60 * 60 * 1000;
    var expDate = new Date();
    expDate.setTime(expDate.getTime() + expDays);
    var expString = expires ? ";expires=" + expDate.toGMTString() : "";
    var pathString = ";path=/";
    document.cookie = name + "=" + escape(value) + expString + pathString;
  },
  del: function (name, value, expires) {
    var exp = new Date(new Date().getTime() - 1);
    var s = this.read(name);
    if (s != null) {
      document.cookie = name + "=" + s + ";expires=" + exp.toGMTString() + ";path=/";
    }
  }
};


