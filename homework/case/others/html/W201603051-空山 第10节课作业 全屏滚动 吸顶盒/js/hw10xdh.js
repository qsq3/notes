$(function(){
	/*滚动条置顶事件*/
	$(window).scroll(function(){
		var Top = $(window).scrollTop();
		//document.title = Top;
		if(Top>60){
			$(".nav").addClass("navtop");
			$(".menu>div").css({
					"position":"fixed",
						"top":"60px",
						"right":"0",
						"bottom":"0",
						"left":"0",});
		}else{
			$(".nav").removeClass("navtop");
			$(".menu>div").css("position","static");
			
		}
	})
	/*menu的hover事件*/
	var _index = 0;
	var timer;
	$(".nav>ul>li").mouseenter(function(){
		_index = $(this).index();
		clearTimeout(timer);
		$(this).addClass("liact").siblings().removeClass("liact");
		$(".menu>div").eq(_index).stop(true,true).slideDown().siblings().slideUp();
	});

	$(".menu>div>img").mouseenter(function(){
		clearTimeout(timer);
	});
	
	$(".nav>ul>li,.menu>div>img").mouseleave(function(){
		timer = setTimeout(function(){
				$(".nav>ul>li").removeClass("liact");
				$(".menu>div").stop(true,true).slideUp();
			},
			500
		)
	});




})