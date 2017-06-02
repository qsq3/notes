(function($,window){
	//轮播图
	function slider (json){
		var wrap = json && json.wrap;
		var img = json && json.img ||wrap.find('.slide-img');
		var tab = json && json.tab ||wrap.find('.slide-tab');
		var btn = json && json.btn ||wrap.find('.slide-btn');
		var index = json && json.index || 0 ;  //初始显示;
		var indexB = index;							//扩展tab图片按钮
		var dur = json && json.duration || 600; //滚动速度
		var delay = json && json.delay || 3000; //自动播放间隔;
		var tabmode = json && json.tabmode ||'mouseover';//tab按钮;
		var tabOn  = json && json.tabOn ||'slide-tab-on';//tab按钮激活样式;
		var btnmode = json && json.btnmode ||'click';//btn按钮;
		var automode = json && json.automode ||'yes';//自动模式;
		var imgmode = json && json.imgmode ||'left';//轮播模式:left;top;fade;
		var timerAuto ,timerTabDelay,timeS = new Date();
		var imgL = img.first().children().length;
		var tabPosition = json && json.tabPosition ||'center';//tab按钮默认自动水平居中;
		var playL = img.width();
		var movemode;
		if(imgmode == 'top'){
			playL = img.height();
		};
		img.children().css({'position':'absolute','display':'none'});
		img.each(function(){
			$(this).children().eq(index).css('display','block' );
		});
		tab.each(function(){
			if (tabPosition == 'center')
			{	
				$(this).css({'margin-left': -($(this).outerWidth())/2 ,'left' : '50%'});
			};
			$(this).children().eq(index).addClass(tabOn).siblings().removeClass(tabOn);
		});
		
		//监听事件
		eve();
		function eve(){

			function tabRun(event){ 
				event = event || window.event;
				cBubble(event);
				clearTimeout(timerTabDelay);
				var time = (dur+100)- (new Date() - timeS);
				var This = $(this);
				var indexT = $(this).index();
				if(time <= 0){	
				timeS = new Date();
				indexB = index;
				index = This.index();
				play();
				}else if(tabmode != 'click'){
					timerTabDelay = setTimeout(function (){
						timeS = new Date();
						indexB = index;
						index = indexT;
						play();
					},time);
				};
			};
			wrap.bind('mouseover',function(){clearTimeout(timerTabDelay)});

			if (tabmode != 'no')
			{	
				tab.each(function(){
					$(this).children()[tabmode](tabRun);	
				});			
			};

			if (btnmode != 'no')
			{	
				btn.each(function(){
					$(this).children()[btnmode](function(){
						var n = $(this).index();

						if((new Date() - timeS) < (dur+100)){
							return;
						};
						timeS = new Date();
						n = n ? 1: -1;
						indexB = index;
						index += n;
						play();
					})
				});

			};
		};
		//自动播放
		if(automode != 'no'){
			function auto (){
				timerAuto = setInterval(function(){
					if((new Date() - timeS) < (dur+100)){
						return;
					};
					timeS = new Date();
					indexB = index;
					index++;
					play();
				},delay);
			}
			auto(); 
			wrap.bind({
				'mouseenter' : function(){clearInterval(timerAuto)},
				'mouseleave' : function(){auto();}
			});
		};
		//运动事件
		function play (){
			var moveL;
			if (indexB == index){
				return;
			}
			indexB<index ? moveL = playL :  moveL = -playL;
			index < 0 && (index = imgL-1);
			index %= imgL;
			imgPlay(moveL);
			tabmove();
			
		};
		function imgPlay (moveL){
			var animateJson={},animateJsonB={}; 
			if (imgmode=='top' ||imgmode=='left' )
			{	
				animateJson[imgmode] = 0;
				animateJsonB[imgmode] = -moveL+'px';
				img.each(function(){
					$(this).children().eq(index).css(imgmode,moveL+'px').css('display','block');
					$(this).children().eq(index).stop().animate(animateJson,dur);
					$(this).children().eq(indexB).stop().animate(animateJsonB,dur,function(){
						img.each(function(){
							$(this).children().eq(index).css(imgmode,0);
						});
					});
				});
			}else if(imgmode=='fade'){
				img.each(function(){
					$(this).children().eq(index).stop().fadeIn(dur);
					$(this).children().eq(indexB).stop().fadeOut(dur,function(){
						img.each(function(){
							$(this).children().eq(index).css('display','block').siblings().css('display','none');
						});
					});	
				});
			}else if(imgmode =='moveshow'){
				var d = Math.floor(Math.random()*4);
				var moveL;
					switch (d)
					{
						case 0:movemode='top';moveL = img.height();break;
						case 1:movemode='top';moveL = -img.height();break;
						case 2:movemode='left';moveL = img.width();break;
						case 3:movemode='left';moveL = -img.width();break;
					};
					animateJsonB[movemode] = -moveL+'px';
					animateJsonB.opacity = 0;
					animateJsonB.filter= 'alpha(opacity=0)';
				img.each(function(){
					$(this).children().eq(index).css({'left':0,'top':0,'display':'block','opacity':1,'filter':'alpha(opacity=100)','z-index':1});
					$(this).children().eq(indexB).stop().css({'z-index':9}).animate(animateJsonB,dur,function(){
						img.each(function(){
							$(this).children().eq(index).css('display','block').siblings().css('display','none');
						});
					});
					
				});
			}else if(imgmode =='moveshowB'){
				var d = Math.floor(Math.random()*4);
				var moveL;
					switch (d)
					{
						case 0:movemode='top';moveL = img.height();break;
						case 1:movemode='top';moveL = -img.height();break;
						case 2:movemode='left';moveL = img.width();break;
						case 3:movemode='left';moveL = -img.width();break;
					};
					
					animateJsonB[movemode] = -moveL+'px';
					animateJsonB.opacity = 0;
					animateJsonB.filter= 'alpha(opacity=0)';
					img.eq(0).children().eq(index).css({'left':0,'top':0,'display':'block','opacity':1,'filter':'alpha(opacity=100)','z-index':1});
					img.eq(0).children().eq(indexB).stop().css({'z-index':9}).animate(animateJsonB,dur,function(){
						img.each(function(){
							$(this).children().eq(index).css('display','block').siblings().css('display','none');
						});
					
				});
			};
		};
		function tabmove(){
			if (tabmode != 'no')
			{	
				tab.each(function(){
					$(this).children().eq(index).addClass(tabOn).siblings().removeClass(tabOn);
				})
			}
		}
	};
	//登录框
	function loginfn (menu,subMenu,lgObj){
		var $pwhide = lgObj.find('#login-pwhide');
		var $pwshow = lgObj.find('#login-pwshow');
		var $pwset = lgObj.find('#showpw');
		var $lgBg = lgObj.children('.loginBg');
		var $lgBox = lgObj.children('.loginBox');

		//登录按钮的事件
		menu.hover(function(){
			subMenu.css('display','block');
		},function(){
			subMenu.css('display','none');
		});
		menu.click(function(){
			lgObj.css('display','block').find('input.login-uname').focus();
			subMenu.css('display','none');
		});
		//登录背景隐藏事件
		$lgBg.click(function(){
			lgObj.css('display','none');
		});
		//登录框事件
		//回车进入密码框
		$lgBox.find('input.login-uname').bind({
			'focus' : function(){this.placeholder='';},
			'blur' : function(){this.placeholder="用户名/邮箱/手机号";},
			'keydown' : function(event){
				if (event.which == 13)
				{	
					if ($pwset.prop('checked'))
					{
						$pwshow.focus();
					}else{
						$pwhide.focus();
					};
				};
			}
		});
		//切换显示密码
		$pwset.click(function(event){  
			//注意,这里用focus结果不同,读取的是之前的值;鼠标点击一个没有焦点的TextBox时，先触发GotFocus事件，然后因为鼠标的点击而自动取消的文本选择并且把光标定位到鼠标点的位置，接着再触发Click事件。也就是说GotFocus事件处理之后鼠标点击使得处理的结果被改变了，而Click事件是在鼠标点击之后触发的，所以不受影响。
			cBubble(event);
			if ($pwset.prop('checked')){	
				$pwhide.css('display','none');
				$pwshow.val($pwhide.val()).css('display','block').focus();
			}else{
				$pwshow.css('display','none');
				$pwhide.val($pwshow.val()).css('display','block').focus();
			};
		});
		//拖拽登录框
		$lgBox.mousedown(drag);
		function drag(event){
			var This = $(this);
			event = event || window.event;
			var xBegin = event.pageX; 
			var yBegin = event.pageY;
			var leftBegin = parseInt(This.css('left'));
			var topBegin = parseInt(This.css('top'));
			$(this).css('cursor','move');
			lgObj.mousemove(dragmove);
			lgObj.mouseup(function(){
				This.css('cursor','auto');
				lgObj.unbind('mousemove',dragmove);
			});
			function dragmove(event){
				event = event || window.event;
				var leftNow = leftBegin + (event.pageX - xBegin);
				var topNow = topBegin + (event.pageY - yBegin);
				(leftNow <= 0) && (leftNow =0);
				(leftNow >= (lgObj.width() - This.outerWidth())) && (leftNow = (lgObj.width() - This.outerWidth()));
				(topNow <= 29) && (topNow = 29);
				(topNow >= (lgObj.height() - This.outerHeight())) && (topNow = (lgObj.height() - This.outerHeight()));
				This.css({'left':leftNow+'px','top':topNow+'px'});
			};
		};
	};
	//TopLogo二级菜单
	function togTitle(nav ,classOn ,index){
		nav.mouseenter(function(){ 
			$(this).html($(this).attr('entitle')).parent().addClass(classOn).siblings().removeClass(classOn).children('a').each(function(){
				$(this).html($(this).attr('chtitle'));
			});
		});
	};
	function topNav(nav ,subnav,classOn){	//
		var index = 0;
		nav.mouseenter(function(){ 
			index = $(this).parent().index();
			$(this).html($(this).attr('entitle')).parent().addClass(classOn).siblings().removeClass(classOn).children('a').each(function(){
				$(this).html($(this).attr('chtitle'));
			});
			subnav.eq(index).show().siblings().hide().parent().stop().slideDown();
		});
		nav.parents('.main').mouseleave(function(){
			subnav.hide().parent().stop().slideUp();
			nav.eq(index).html(nav.eq(index).attr('chtitle')).parent().removeClass(classOn);
			
		})
	};
	//二级菜单
	
	function baikeMenu(menu ,submenu,classOn){	//
		var index = 0;
		menu.mouseenter(function(){ 
			index = $(this).index();
			$(this).addClass(classOn).siblings().removeClass(classOn);
			submenu.eq(index).show().siblings().hide();
		});
	};
	//搜索栏
	function searchbox (searchform){
		var btnBox = searchform.find('.search-submit');
		var btn = searchform.find('.search-submit input');
		var text = searchform.find('.search-text');
		btnBox.click(function(){
			btn.show();
			text.parent().addClass("searchOn");
			text.focus().stop().animate({'width':'138px'},500);
			
		});
		text.blur(function(){
			btn.hide();
			text.stop().animate({'width':'0'},500,function(){
			text.parent().removeClass("searchOn");
			});
		});
	};
	//阻止冒泡:
	function cBubble(event){
		if (event.stopPropagation) { 
				event.stopPropagation(); 
		}else if (window.event) { 
			window.event.cancelBubble = true; 
		};
	};
	$(function(){
		//登录
		loginfn($('.header-login'),$('.header-login .header-menu'),$('.login'));
		//头部二级菜单
		topNav($('.topLogo-navL a') , $('.topLogo-subnav li'),'topLogo-nav-on');
		//简单二级菜单
		//百科
		baikeMenu($('.bkMenu b'),$('.bkSubMenu .pannel'),'menu-on');
		//推荐
		baikeMenu($('.recommend .rec-th .title'),$('.recommend .rec-tb .tb-txt'),'on');
		//底部
		baikeMenu($('.foot .link .title span'),$('.foot .link .t_list'),'on');
		//头部搜索栏
		searchbox($('.topLogo-nav .search'));
		//轮播:
		//头部Logo轮播; 
		slider({
			wrap : $('.banner .slide-wrap'),
			duration : 1000,  //轮播速度
			delay : 3000,	//自动间隔时间;
			imgmode : 'left',  // 轮播模式
			tabmode : 'hover', // hover,click,no
			btnmode : 'click',    //hover,click,no
			automode : 'yes'	//yes ,no
		});
		//焦点标题轮播
		slider({
			wrap : $('.tfocus .thA .horn-con'),
			delay : 2000,
			imgmode : 'top',  
			tabmode : 'no', 
			btnmode : 'no',   
			automode : 'yes'
		});
		//焦点col-a row-a轮播
		slider({
			wrap : $('.tfocus .col-a .slide-wrap'),
			automode : 'no'
		});
		//焦点tbC轮播
		slider({
			wrap : $('.tfocus .tbC .slide-wrap'),
			automode : 'no'
		});
		//大明星col-ab轮播
		slider({
			wrap : $('.stars .col-ab .slide-wrap'),
			imgmode : 'fade'
		});
		//爱时尚轮播
		slider({
			wrap : $('.fashion .col-a .slide-wrap'),
			automode : 'no'
		});
		//要漂亮轮播
		slider({
			wrap : $('.beauty .col-a .slide-wrap'),
			automode : 'no'
		}); 
		slider({
			wrap : $('.beauty .embBox .slide-wrap'),
			automode : 'no',
			btn : $('.beauty .embBox .slide-btn')
		});
		slider({
			wrap : $('.beauty .tbC .slide-wrap')
		});
		//乐生活轮播
		slider({
			wrap : $('.lohas .tbA .slide-wrap'),
			automode : 'no'
		});
		slider({
			wrap : $('.plastic .col-a .slide-wrap'),
			automode : 'no'
		});
		slider({
			wrap : $('.plastic .col-c .slide-wrap'),
			btnmode : 'no'
		});
		//摩登学院轮播
		slider({
			wrap : $('.modern .row-a .col-a .slide-wrap'),
			automode : 'no'
		});
		slider({
			wrap : $('.modern .mo-star .slide-wrap')
		});

		//悦选轮播
		slider({
			wrap : $('.choice .embBox .slide-wrap'),
			automode : 'no',
			btn : $('.choice .embBox .slide-btn')
		});
		//视觉
		slider({
			wrap : $('.visual .col-a .row-a .slide-wrap'),
			automode : 'no',
			btn : $('.visual .col-a .row-a'),
			btnmode : 'mouseleave',
			imgmode : 'moveshowB'
		});
		slider({
			wrap : $('.visual .col-a .row-b .slide-wrap'),
			automode : 'no',
			btn : $('.visual .col-a .row-b '),
			btnmode : 'mouseleave',
			imgmode : 'moveshowB'
		});
		slider({
			wrap : $('.visual .col-b .row-a .slide-wrap'),
			automode : 'no',
			btn : $('.visual .col-b .row-a '),
			btnmode : 'mouseleave',
			imgmode : 'moveshowB'
		});
		slider({
			wrap : $('.visual .col-b .row-b .slide-wrap'),
			automode : 'no',
			btn : $('.visual .col-b .row-b '),
			btnmode : 'mouseleave',
			imgmode : 'moveshowB'
		});
		slider({
			wrap : $('.visual .col-b .row-c .slide-wrap'),
			automode : 'no',
			btn : $('.visual .col-b .row-c '),
			btnmode : 'mouseleave',
			imgmode : 'moveshowB'
		});
		slider({
			wrap : $('.visual .col-c .row-a .slide-wrap'),
			automode : 'no',
			btn : $('.visual .col-c .row-a '),
			btnmode : 'mouseleave',
			imgmode : 'moveshowB'
		});
		slider({
			wrap : $('.visual .col-c .row-b .slide-wrap'),
			automode : 'no',
			btn : $('.visual .col-c .row-b '),
			btnmode : 'mouseleave',
			imgmode : 'moveshowB'
		});
		//推荐

		slider({
			wrap : $('.recommend .col-a .slide-wrap')
		}); 
		slider({
			wrap : $('.recommend .col-c .slide-wrap'),
			tabPosition : 'right'
		});
		//底部轮播
		slider({
			wrap : $('.foot .tagTui .slide-wrap'),
			tabPosition : 'right',
			tab : $('.foot .tagTui .slide-tab')
		}); 
		//右侧悬浮导航
		function slideNav( navLi,smu,slideNav ,classOn,classOnB){
			var step = $('.step') ,stepL = step.length;
			smu.click(function(){
				navLi.parent().toggle();
			});
			var index = 0 , indexB=0;
			navLi.mouseenter(function(){ 
				index = $(this).index();
				$(this).addClass(classOn).children('a').html($(this).children('a').attr('entitle'));
			});
			navLi.mouseleave(function(){
				$(this).removeClass(classOn);
				if ($(this).index() == indexB)
				{
					return;
				};
				$(this).children('a').html($(this).children('a').attr('chtitle'));
			});
			$(window).scroll(function(){
				var d = $(window).scrollTop();
				if (d < step.eq(0).offset().top )
				{
					slideNav.hide();
				}else{
					slideNav.show();
					for (var i=0 ; i<stepL ; i++ )
					{
						if (d<step.eq(i).offset().top)
						{
							indexB = i-1;
							indexB <0 && (indexB = 0);
							break;
						}else{
							indexB = i;
						}
					}
				};
				navLi.eq(indexB).addClass(classOnB).children('a').html(navLi.eq(indexB).children('a').attr('entitle'));
				navLi.eq(indexB).siblings().removeClass(classOnB).children('a').each(function(){
					$(this).html($(this).attr('chtitle'));
				});
			});



		};
		
		slideNav( $('.slideNav .sNav li'),$('.slideNav .smu'),$('.slideNav'),'on' ,'on-b');
	});
})(jQuery,window);