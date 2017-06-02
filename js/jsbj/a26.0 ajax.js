/*
	@ 调用方法   ajax( 对象实参 );
	@ 对象实参需要传的属性：
		method : 访问方式（选填），默认'get',
		url : 访问地址（必填）,
		data : 传输数据（选填），需要传数据时才填,
		aysn : 是否异步（选填），默认true,
		success : 请求成功后执行的函数，第一个形参代表返回的数据,
		error : 请求失败后执行的函数，第一个形参代表错误状态码

        ajax({
				method : 'post',
				url : 'test.php',
				success : function(data){
					console.log( data );
				}
        });

        var oBtn = document.getElementById('btn1');
        oBtn.onclick = function(){
            ajax({
                'method' : 'get',
                'url' : 'array.php',
                'data' : 'user=afei&pw=123',
                'success' : function(d){
                    var arr = eval(d);
                    alert (arr[0].name);
                },
                'error' :  function(){
                    alert('error');
                }
            });
        }
*/

/*封装
    方法
    路径
    是否异步
    数据
    请求成功以后
    请求不成功以后
*/
function ajax(aJson){
    var xhr = window.XMLHttpRequest ? new XMLHttpRequest(): new ActiveXObject('Microsoft.XMLHttp');
    var method = aJson.method || 'get',
        url = aJson.url,
        aysn = aJson.aysn || true,
        data = aJson.data || '',
        success = aJson.success,
        error = aJson.error;
    if (method.toLowerCase() == 'get'){
        url += '?'+data+'&'+new Date().getTime();
    };
    xhr.open( method , url , aysn );
    xhr.setRequestHeader('content-type' , 'application/x-www-form-urlencoded');
    xhr.send(data);
    xhr.onreadystatechange = function(){
        if ( xhr.readyState == 4 )
        {
            if ( xhr.status >= 200 && xhr.status<300 )
            {
                success && success(xhr.responseText);
            }
            else
            {
                error && error();
            };
        };
    };
};			


//输入data为json格式;
function ajax(mJson){
    var xhr = window.XMLHttpRequest ? new XMLHttpRequest(): new ActiveXObject('Microsoft.XMLHttp');
	var method = mJson.method || 'get';
	var url = mJson.url;
	var data = '';
	var aysn = mJson.aysn || true;
	var success = mJson.success;
	var error = mJson.error;
	if ( mJson.data )
	{
		var arr = [];
		for (var key in mJson.data )
		{
			arr.push( key + '=' + mJson.data[key] );
		};
		data = arr.join('&');
	};
	if ( data && method.toLowerCase()=='get' )url += '?' + data;
	xhr.open( method , url , aysn );
	xhr.setRequestHeader('content-type' , 'application/x-www-form-urlencoded');
	xhr.send(data);
	xhr.onreadystatechange = function(){
		if ( xhr.readyState == 4 )
		{
			if ( xhr.status >= 200 && xhr.status < 300 )
			{
				success && success( xhr.responseText );
			}else
			{
				error && error( xhr.status );
			};
		}
	};
};