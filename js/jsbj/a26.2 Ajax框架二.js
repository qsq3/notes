/**
 *Ajax��ѯ 
 */
function Trim(){
	return this.replace(/\s+$|^\s+/g,"");
}
String.prototype.Trim=Trim;	//�������˿ո�

function getObject(elementId) { 	//��ȡָ��id��object
	if (document.getElementById) { 
		return document.getElementById(elementId); 
	} else if (document.all) { 
		return document.all[elementId]; 
	} else if (document.layers) { 
		return document.layers[elementId]; 
	} 
}

function getObjValue(elementId){	//��ȡָ��id��form�����ֵ
	if(getObject(elementId).value!=undefined)
		return getObject(elementId).value.Trim();
	else
		return "";
}

function XHR(){	//����XMLHttpRequest����
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

function checkForm(){	//���ļ��
	if(getObjValue("p")=="")
				   {
		alert("�������Ʒ��α�룡");
		return false;
	}
	
if (!IsPici(getObjValue("p"))) 
{ 
alert("��α��ֻ����Ӣ�Ļ�����"); 
return false;
} 
	return true;
}

function sendJS() {	//����
	var xhr=XHR();
	if(xhr&&checkForm()){
		getObject("submit").value="��ѯ��,���Ժ�...";
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
					getObject("submit").value="������ѯ";	//���÷��ͱ�����ֹ�ظ��ύ
					getObject("submit").disabled=false;

					clearForm();				//�������ֵ
					reloadcode();
					
				}else{
					alert("���紫����������ԣ�");	
				}
			}	
		};
    		xhr.send(data);
  	}
}

function clearForm(){	//��ձ��ĺ���
	getObject("p").value="";
}