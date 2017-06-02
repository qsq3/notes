/** 
	空山 2016/10/27 ssmat@qq.com 注意 localStorge 受跨域限制 ,
	可考虑使用 JSON.parse(string) 和 JSON.stringify(json) 简化, 
	替换正则可使用(表示花括号之前的逗号)  /(?=\}),(?=\{)/ 或者(表示花括号外面的逗号): /,(?=[^\}]*(\{|$))/

**/
;(function(window,undefined){
	var KSstorge = {};
	KSstorge = {
		// 字符串格式为 : subkey1=subkeyValue1&subkey2=subkeyValue2;subkey1=subkeyValue1&subkey2=subkeyValue2
		insert : function(table, json){
			var temp = '';
			var val;
			for (var key in json )
			{
				if (temp){
					temp += ("&" + key + "=" + json[key]);
				}
				else{
					temp = (key + "=" + json[key]);
				}
			}
			if( val = localStorage.getItem(table) ) {
				val += (";" + temp);
			} else {
				val = temp;
			};
			localStorage.setItem(table,val);
		},
		select : function(table, target, where){
			var val = localStorage.getItem(table) || "";
			//var val = "subkey1=subkeyValue1&subkey2=subkeyValue2;subkey1=subkeyValue1&subkey2=subkeyValue2";
			if(!val) return [0, "localStorage无返回数据"];
			if(!where) return [0, "缺少查询条件 : " + val];
			var valArr = KStoObj(val);
			var pkey, pvalue;
			for (var key in where )
			{
				pkey = key;
				pvalue = where[key];
			}
			for (var i=0; i<valArr.length ; i++ )
			{
				for (var key in valArr[i] )
				{
					if ( key == pkey && valArr[i][key] == pvalue)
					{
						
						if(target && ((typeof target).toLowerCase() === "string" )){
							return [1, valArr[i][target]];
						}else {
							return [1, valArr[i]];
						}
					}
				}
			}
			return [0, "localStorage无匹配数据"];
		},
		update : function (table, reset, where){
			var val = localStorage.getItem(table) || "";
			if(!val) return [0, "localStorage无返回数据"];
			var pkey, pvalue;
			if ( where )
			{
				for (var key in where )
				{
					pkey = key;
					pvalue = where[key];
				};
			}
			var flag = false;
			var valArr = KStoObj(val);
			for (var i=0; i<valArr.length ; i++ )
			{
				if( where ){
					for (var key in valArr[i] )
					{
						if ( key === pkey && valArr[i][key] === pvalue)
						{
							flag = true;
							for ( var j in reset )
							{
								valArr[i][j] = reset[j];
							}
						}
					}
				} else {
					flag =true;
					for ( var j in reset )
					{
						valArr[i][j] = reset[j];
					}
				}
			};
			var newVal = KStoStr(valArr);
			if (flag && newVal !== val)
			{
				localStorage.setItem(table, newVal);
				return [1, "localStorage匹配数据更新"];
			}
			return [0, "localStorage无匹配数据"];
		}
		
	}
	function KStoObj ( str ) {
		if (!str)
		{
			alert("KStoAJson无传入数据");
			return;
		}
		var arr = str.split(";");
		for(var i=0; i<arr.length; i++){
			var subArr = arr[i].split("&");
			//var subJson = {string: arr[i]};
			var subJson = {};
			for(var j=0; j<subArr.length; j++){
				var temp = subArr[j].split("=");
				subJson[temp[0]] = temp[1];
			}
			arr[i] = subJson;
		}
		return arr;
	}

	function KStoStr ( obj ) {
		if (!obj || obj.constructor !== Array )
		{
			alert("KStoStr无数据或格式错误");
			return;
		}
		var str = "";
		for(var i=0; i<obj.length; i++){
			var subStr = "";
			for ( var key in obj[i] )
			{
				if ( !subStr ){
					subStr += ( key + "=" + obj[i][key]);
				} else {
					subStr += ("&" +  key + "=" + obj[i][key]);
				}
				
			}
			if ( !str ){
				str += subStr;
			} else {
				str += (";" + subStr);
			}
		}
		return str;
	}
	window.KSstorge = window.KSstorge || KSstorge;
})(window);