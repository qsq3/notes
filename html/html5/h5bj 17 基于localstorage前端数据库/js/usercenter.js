;(function(window,undefined){
	var res = KSstorge.select("user" , null, {"active" : 1});
	console.log(res);
	if (!res[0])
	{
		window.location.href = 'login.html';
	}
	document.getElementById("logout").onclick = function () {
		KSstorge.update("user",{"active" : 0});
		window.location.href = 'login.html';
	}

})(window);