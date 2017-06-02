window.onload = function(){
  var oSection = document.getElementsByTagName('section')[0];
  var arr = [];
  var arrImg = [ /*'img/yuechen.jpg','img/lmj.jpg',*/'img/xin.png',/*'img/ciyuan.jpg','img/heiying.jpg','img/yutian.jpg','img/tangtang.jpg',/*'img/xumoting.jpg','img/yinyue.jpg',*/'img/xuanmo.jpg' ];
  var arrTitle = [ /*'<h2>越尘</h2>','<h2>老喵君</h2>',*/'<h2>信仰</h2>',/*'<h2>二次元</h2>','<h2>黑影</h2>','<h2>夏雨天</h2>','<h2>糖糖</h2>',/*'<h2>徐莫庭</h2>','<h2>音乐</h2>',*/'<h2>轩陌</h2>' ];
  var arrUrl = [ /*'yuechen-homework/index.html','laomiaojun-homework/index.html',*/'xin-homework/index.html',/*'http://www.weekscosplay.com/h5web/no-01.html','heiying-homework/index.html','yutian-homework/index.html','tangtang-homework/index.html',/*'xumoting-homework/index.html','yinyue-homework/index.html',*/'xuan-homework/index.html' ];
  for( var i=0; i<arrTitle.length; i++ ){
    arr[i] = '<article><a href="' + arrUrl[i] + '" target="_blank"><img src="' + arrImg[i] + '" alt="" />' + arrTitle[i] + '</a></article>';
  }
  oSection.innerHTML = arr.sort( randomSort ).join('');
  var h = '<p style="position: absolute;top: 256px;left: 30%;color:#fff;font-size: 24px;">白虎联盟各成员作业</p>';
  $('section').append(h);
  function randomSort( a , b ){
    return Math.random() >.5 ? -1 : 1;
  }
    /*环形排列*/
  var aTcle=oSection.getElementsByTagName("article");
  var radius = 200;//定义圆形半径
  var radian = 360/aTcle.length*Math.PI/180;//每一个article对应的弧度;
  for(var i=0;i<aTcle.length;i++){
    aTcle[i].index=i;
    _left = Math.sin((radian*i))*radius+200;
    _top = Math.cos((radian*i))*radius+200;
    aTcle[i].style.cssText = 'top:'+_top+'px;left:'+_left+'px;';
  }

	
	setTimeout(function(){
  	$('section').addClass('show');
  },800);

	  
  $(window).resize(function(){
  	if( $(window).width() < 766 ){
		  setTimeout(function(){
		  	$('section').addClass('show');
		  },800);
  	}else{
  		$('section').removeClass('show');
  	}
  });


}
