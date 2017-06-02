/**
 *Ajax查询 
 */
function Trim(){
	return this.replace(/\s+$|^\s+/g,"");
}
String.prototype.Trim=Trim;	//过滤两端空格

function getObject(elementId) { 	//获取指定id的object
	if (document.getElementById) { 
		return document.getElementById(elementId); 
	} else if (document.all) { 
		return document.all[elementId]; 
	} else if (document.layers) { 
		return document.layers[elementId]; 
	} 
}

function getObjValue(elementId){	//获取指定id的form组件的值
	if(getObject(elementId).value!=undefined)
		return getObject(elementId).value.Trim();
	else
		return "";
}

function XHR(){	//创建XMLHttpRequest对象
	var xhr;
	try{
		xhr=new XMLHttpRequest();
	}catch(e){
    		var a=['MSXML2.XMLHTTP.5.0','MSXML2.XMLHTTP.4.0','MSXML2.XMLHTTP.3.0','MSXML2.XMLHTTP','MICROSOFT.XMLHTTP.1.0','MICROSOFT.XMLHTTP.1','MICROSOFT.XMLHTTP'];
    		for (var i=0;i<a.length;i++){
      			try{
        			xhr = new ActiveXObject(a[i]);
        			break;
      			}catch(e){}
    		}
  	}
	return xhr;
}

function IsPici(s) 
{ 
var username = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
for (i = 0; i < s.length;i++) 
{ 
//what
var c = s.charAt(i); 
if (username.indexOf(c) == -1) return false; 
} 
return true 
} 

function checkForm(){	//表单的检测
	if(getObjValue("p")=="")
				   {
		alert("请输入产品防伪码！");
		return false;
	}
	
if (!IsPici(getObjValue("p"))) 
{ 
alert("防伪码只能是英文或数字"); 
return false;
} 
	return true;
}

function sendJS() {	//发送
	var xhr=XHR();
	if(xhr&&checkForm()){
		getObject("submit").value="查询中,请稍候...";
		getObject("submit").disabled=true;
		
		xhr.open("POST", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var aIdArray=new Array("flag="+Math.random());
		var aUserArr=["p","IsSearch"];
		var argLen=aUserArr.length;
		for(i=0;i<argLen;i++){
			aIdArray[i+1]="&"+aUserArr[i]+"="+escape(getObjValue(aUserArr[i]));
		}
		
		Tishi=document.getElementById("test"); 
    		var data =aIdArray.join('');
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4){
				if(xhr.status==200){
					var response = xhr.responseText;
                    Tishi.innerHTML=response;
					getObject("submit").value="继续查询";	//禁用发送表单，防止重复提交
					getObject("submit").disabled=false;

					clearForm();				//清除表单的值
					reloadcode();
					
				}else{
					alert("网络传输错误！请重试！");	
				}
			}	
		};
    		xhr.send(data);
  	}
}

function clearForm(){	//清空表单的函数
	getObject("p").value="";
}