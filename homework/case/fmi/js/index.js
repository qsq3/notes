/**
 * 
 * @authors Your Name (iqianduan@126.com)
 * @date    2016-05-14 16:00:33
 * @version $Id$
 */
$(function(){
    //阻止冒泡
    function cBubble(event){
        if (event.stopPropagation) { 
                event.stopPropagation(); 
        }else if (window.event) { 
            window.event.cancelBubble = true; 
        };
    };
    //头部nav二级菜单
    (function(){
        var $pro = $('.nav .pro li');
        var $proSub = $('.nav .pro_sub li');
        var index = 0;
        $pro.hover(function() {
            index = $(this).index();
            $proSub.eq(index).show().siblings().hide().parent().parent().stop().slideDown();
        }, function() {
            $proSub.parent().parent().stop().slideUp();
        });
        $proSub.parent().parent().hover(function() {
            $(this).stop().slideDown();
        }, function() {
            $(this).stop().slideUp();
        });
    })();
    //头部nav search
    (function(){
        var $txt = $('.nav .search .txt input');
        var $txtSub = $('.nav .search .txt_sub');

        $txt.focus(function(){
            $(this).parent().parent().addClass('focus');
            $txtSub.slideDown();
        });
        $txt.blur(function(event) {
            $(this).parent().parent().removeClass('focus');
            $txtSub.slideUp();
        });

    })();
    //banner轮播图
    (function(){
        var banner = new Slider({
            wrap : $('.banner .slide-wrap'),
            imgmode : 'fade', 
            tabmode : 'click', 
            btnmode : 'click',
            dur : 500
        });
        banner.init();
    })();
    //star
    (function(){
        var slideImg = $('.star .slide-img');
        var page = 2;
        var imgL = index_data.star.imgSrc.length/page;
        var n = 0;
        for(var j=0;j<page;j++){
            var oLi = document.createElement('li');
            for (var i = 0; i < imgL; i++) {

                n= i+j*imgL;

                var oDiv = document.createElement('div');
                oDiv.className = 'tdA';
                oDiv.style.borderColor = index_data.star.borderColor[i];
                (i==0)&&(oDiv.style.marginLeft = 0);

                var oA = document.createElement('a');
                oA.href = 'javascript:;';
                var oAImg =  new Image(160, 160);
                oAImg.src = index_data.star.imgSrc[n];
                oAImg.alt =  '';
                oA.appendChild(oAImg);

                var title = document.createElement('p');
                title.className = 'title';
                title.innerHTML =index_data.star.title[n];
                oA.appendChild(title);
                oDiv.appendChild(oA);

                var details = document.createElement('p');
                details.className = 'details';
                details.innerHTML =index_data.star.details[n];
                oDiv.appendChild(details);

                var price = document.createElement('p');
                price.className = 'price';
                price.innerHTML =index_data.star.price[n]; 
                oDiv.appendChild(price);

                oLi.appendChild(oDiv);
            };
            slideImg.append(oLi);
        };
        //轮播
        var slideStar = new Slider({
            wrap : $('.star .slide-wrap'),
            tabmode : 'click'
        });
        slideStar.init();
    })();
    //smart
    (function(){
         var $Box = $('.smart .col_b');
         var page = 1;
         var imgL = index_data.smart.imgSrc.length/page;
         var n = 0;
         var cols = 4;
         for(var j=0;j<page;j++){
             var $Div = $('<div></div>');
             for (var i = 0; i < imgL; i++) {
                 n= i+j*imgL;
                 var rowA = (i<cols)? 'row_a' : '';
                 var $tdA = $("<div class= 'tdA "+rowA +
                     "'><a href='javascript:;'><img src='"+ index_data.smart.imgSrc[n]+ 
                     "' height='160' width='160' alt='' /><p class='title'>"+index_data.smart.title[n]+
                     "</p></a><p class='details'>"+index_data.smart.details[n]+
                     "</p><p class='price'>"+index_data.smart.price[n]+"</p></div>");

                 (index_data.smart.flag[n]) &&($tdA.append("<div class = 'flag " +index_data.smart.flag[n]+"'></div>"));
                 $Div.append($tdA);

             };
             $Box.append($Div);
         };
    })();
    // 智能硬件
    (function(){
         var $Box = $('.match .col_b');
         var page = index_data.match.attr.length;
         var imgL = index_data.match.hot.title.length;
         var n = 0;
         var cols = 4;
         for(var j=0;j<page;j++){
             var $Div = $('<div></div>');
             for (var i = 0; i < imgL; i++) {
                 var rowA = (i<cols)? 'row_a' : '';
                 var $tdA = $("<div class= 'tdA "+rowA +
                     "'><a href='javascript:;'><img src='img/match/"+ index_data.match.attr[j]+ "/" +(i+1)+".jpg' height='150' width='150' alt='' /><p class='title'>"+index_data.match[index_data.match.attr[j]].title[i]+
                     "</p></a><p class='price'>"+index_data.match[index_data.match.attr[j]].price[i]+"</p><p class='details'>"+index_data.match[index_data.match.attr[j]].details[i]+
                     "人评价</p><div class='hide'><p class='review'>这个小巧玲珑啊，比10400安的小了好多，感觉不错，...</p><p class='author'> 来自于 prinoac 的评价 </p></div></div>");
                if (i == imgL-1 ){
                    $tdA = $("<div class= 'tdA small row_a'><a href='javascript:;'><img src='img/match/"+ index_data.match.attr[j]+ "/" +(i+1)+".jpg' height='80' width='80' alt='' /><p class='title'>"+index_data.match[index_data.match.attr[j]].title[i]+
                     "</p></a><p class='price'>"+index_data.match[index_data.match.attr[j]].price[i]+"</p></div><div class='tdA small row_b'><a href='javascript:;'><i class='iconfont'>&#x3435;</i><p class='title'>浏览更多</p></a><p class='details'>"+$('.match .thA .fr a').eq(j).html()+"</p></div>");
                };
                 $Div.append($tdA);
             };
             $Box.append($Div);
         };
    })();
    (function(){
        $('.match .thA .fr a').mouseenter(function(event) {
            var index = $(this).index();
            $(this).addClass('classOn').siblings().removeClass('classOn');
            $('.match .col_b').children().eq(index).show().siblings().hide();
        });
    })();
    //内容
    (function(){
    var slideContA = new Slider({
            wrap : $('.cont .first.slide-wrap'),
            tabmode : 'click',
            automode : 'no'
        });
    slideContA.init();

    var slideContB = new Slider({
            wrap : $('.cont .second.slide-wrap'),
            tabmode : 'click',
            automode : 'no'
        });
    slideContB.init();

    var slideContC = new Slider({
            wrap : $('.cont .third.slide-wrap'),
            tabmode : 'click',
            automode : 'no'
        });
    slideContC.init();

    var slideContD = new Slider({
            wrap : $('.cont .forth.slide-wrap'),
            tabmode : 'click',
            automode : 'no'
        });
    slideContD.init();

    })();

    // 视频
    (function(){
        var $hide = $('.video .v_hide');
        var $con = $('.video .v_hide .v_h_con');
        function setSize(){
            $hide.width($(window).width());
            $hide.height($(window).height());
        };
        setSize();
        $(window).resize(setSize);
        $('.video .v_hide .close').click(function() {
            $con.animate({opacity: 0, top: '-300px'}, 500,function(){
                $hide.hide();
            });
        });
        $('.video .videoTrigger').click(function() {
            $hide.show();
            $con.animate({top:'50%' ,opacity: 1}, 500);
        });

    })();
    //添加到购物车
    (function(){
        var $product= $('.price');
        var $pNum = $('.header .h_r_c_num');
        var pNumLeft = $pNum.offset().left;
        var $cInfo0 = $('.header .c_n_0');
        var $cInfoa = $('.header .c_n_a');
        var $cNum = $('.header .c_n_a .num');
        var $cAmount = $('.header .c_n_a .price'); 
        var amount = 0 ,sum =0;

        $product.siblings().find('img').click(function(){
            var top = $(this).offset().top-$(document).scrollTop()-50;
            var left = $(this).offset().left-$(document).scrollLeft();
            var $img = $(this).clone().css({position : 'fixed',top : top ,left : left, display:'block','z-index':98
                });
            sum++;
            var price = parseInt($(this).parent().siblings('.price').html());
            (!isNaN(price))&&(amount += price); 
            $('body').append($img);
            $img.animate({top: -100, left:pNumLeft,opacity:0},500,function(){
                $(this).remove();
            });
            $pNum.html(' '+sum+' ');
            $cNum.html(' '+sum+' ');
            $cAmount.html(' '+amount+' ');
            if (sum) {
                $pNum.css('color','#f60');
                $cInfo0.hide();
                $cInfoa.show();
            };
        });

    })();
    //
})

