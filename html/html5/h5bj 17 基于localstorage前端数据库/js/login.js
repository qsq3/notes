
;(function(window,undefined){
	console.log(KSstorge.select("user"));
	var res = KSstorge.select("user" , null, {"active" : 1});
	if (res[0])
	{
		window.location.href = 'usercenter.html';
	}
	var login = document.getElementById("loginForm");
	var timer2 = new Date();
	document.getElementById("loginBtn").onclick = function(event){
		event.preventDefault();
		if ( new Date() - timer2 < 500)
		{
			return;
		}
		timer2 = new Date();
		var tel = login.tel.value;
		var pw = login.pw.value;
		res = KSstorge.select("user" , "pw", {"tel" : tel});
		
		if ( res[0] && res[1] == pw )
		{
			console.log( res[0] + " : " +res[1]);
			KSstorge.update("user", {"active" : 1}, {"tel" : tel});
			window.location.href = 'usercenter.html';
			
		} else {
			alert("用户名或密码错误!");
			return;
		}

	}
	
})(window);