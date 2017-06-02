;(function(window,undefined){
	var reg = document.getElementById("register_form");
	var submit = document.getElementById("submit");
	var timer1 = new Date();
	submit.onclick = function(event){
		event.preventDefault();
		if ((new Date() - timer1) < 500)
		{
			return;
		}
		timer1 = new Date();
		var insertJson = {
			"tel" : reg.tel.value,
			"pw" : reg.pw.value,
			"uname" : reg.uname.value,
			"rTel" : reg.rTel.value
		}
		for (var key in insertJson)
		{
			if ( !insertJson[key] && key != "rTel")
			{
				alert("内容不能为空");
				return;
			}
		}
		KSstorge.insert("user",insertJson);
		KSstorge.update("user",{"active" : 0});
		KSstorge.update("user",{"active" : 1}, {"tel" : insertJson.tel});
		window.location.href = 'usercenter.html';
	}
})(window);