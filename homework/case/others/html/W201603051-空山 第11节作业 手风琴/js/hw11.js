$(function(){
	var _index = 0;
	var L = $("#main ul li").size();
	var timer;

	function timerun(){
		timer =  setInterval(function(){
		_index++;
		play1();
		},2000
	)};

	function play1(){
		if(_index<0){_index=L-1};
		_index%=L;
		$("#main ul li").eq(_index).find("img").addClass("act1").parent().parent().siblings().find("img").removeClass("act1");
		$("#main ul li").eq(_index).stop().animate({"width":"538px"},500).siblings().stop().animate({"width":"106px"},500);
		$("#footer .page a").eq(_index).addClass("act2").siblings().removeClass("act2");
	};

	timerun();
	$("#main ul li").mouseenter(function(){
		clearInterval(timer);
		_index = $(this).index();
		play1();
	});
	$("#main ul,#footer").hover(function(){
		clearInterval(timer);
	},function(){
		timerun();
	});

	$("#footer .page a").click(function(){
		_index = $(this).index();
		play1();
	});
	$("#footer .pagedown a").click(function(){
		_index++;
		play1();
	});
	$("#footer .pageup a").click(function(){
		_index--;
		play1();
	});

});