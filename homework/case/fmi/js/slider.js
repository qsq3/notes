//轮播图构造函数,
(function(){
    function Slider (json){
        this.json = json;
        this.wrap = this.json && this.json.wrap;
        this.img = this.json && this.json.img ||this.wrap.find('.slide-img');
        this.tab = this.json && this.json.tab ||this.wrap.find('.slide-tab');
        this.btn = this.json && this.json.btn ||this.wrap.find('.slide-btn');
        this.dur = this.json && this.json.dur || 500; //滚动速度
        this.automode = this.json && this.json.automode ||3000;//自动模式;
        this.tabmode = this.json && this.json.tabmode ||'click';//tab按钮;
        this.tabOn  = this.json && this.json.tabOn ||'classOn';//tab按钮激活样式;
        this.btnmode = this.json && this.json.btnmode ||'click';//btn按钮;
        this.imgmode = this.json && this.json.imgmode ||'left';//轮播模式:
        this.index = this.json && this.json.index || 0 ;  //初始显示;
        this.imgL = this.img.first().children().length;
        this.indexB = this.index;
        this.timeS = new Date();
    }
    window.Slider = Slider;
    Slider.prototype = {
        constructor : Slider,
        init : function(){
            this.cssReset();
            (this.tab[0]) && this.tabplay();
            (this.btn[0]) && this.btnplay();
            (this.automode !== 'no') && this.autoplay();
        },
        cssReset : function(){
            var This = this;
            this.img.children().css({'position':'absolute','display':'none','left':0,'top':0});
            this.img.each(function(){
                $(this).children().eq(This.index).css('display','block' );
            });
            this.tab.each(function(){
                $(this).children().eq(This.index).addClass(This.tabOn).siblings().removeClass(This.tabOn);
            });
        },
        autoplay : function(){
            var This = this;
            var timerAuto;
            isNaN(This.automode) && (This.automode = 3000);
            function autorun(){
                timerAuto = setInterval(function(){
                    This.timeS = new Date();
                    This.indexB = This.index;
                    This.index++;
                    This.play();
                },This.automode);
            };
            autorun();
            this.wrap.mouseenter(function() {clearInterval(timerAuto)});
            this.wrap.mouseleave(autorun);
            
        },
        tabplay : function(){
            var This = this;
            var timerTabDelay;
            function tabRun(event){ 
                clearTimeout(timerTabDelay);
                var time = (This.dur+100)- (new Date() - This.timeS);
                var indexT = $(this).index();
                function tabRunFn(){
                    This.timeS = new Date();
                    This.indexB = This.index;
                    This.index = indexT;
                    This.play();
                };
                if(time <= 0){  
                    tabRunFn()
                }else if(This.tabmode !== 'click'){
                    timerTabDelay = setTimeout(tabRunFn,time);
                };
            };
            This.tab.children().mouseleave(function(){clearTimeout(timerTabDelay)});
            This.tab.each(function(){
                $(this).children()[This.tabmode](tabRun);
            }); 
        },
        btnplay : function(){
            var This = this;
            This.btn.each(function(){
                $(this).children()[This.btnmode](function(){
                    var n = $(this).index();
                    if((new Date() - This.timeS) < (This.dur+100)){
                        return;
                    };
                    This.timeS = new Date();
                    n || (n = -1);
                    This.indexB = This.index;
                    This.index += n;
                    This.play();
                });
            });
        },
        play : function (){
            var This = this;
            if (this.indexB == this.index){
                return;
            };
            this.f = (this.indexB < this.index ? 1 : -1);
            this.index < 0 && (this.index = this.imgL-1);
            this.index %= this.imgL;
            (this.tab[0]) && this.tabmove();
            switch(this.imgmode){
                case 'left':
                case 'top':
                    this.imgMove();
                    break;
                case 'fade':
                    this.imgFade();
                    break;
                case 'slip':
                    this.imgSlip();
                    break;
            }
        },
        imgMove : function(){
            var This = this,animateJson = {};
            var moveL = (this.imgmode === 'left') ? this.img.width() : this.img.height();
            moveL = moveL * this.f;
            animateJson[this.imgmode] = '-='+moveL;
            this.img.each(function(){
                $(this).children().eq(This.index).css(This.imgmode,moveL+'px').css('display','block');
                $(this).children().stop().animate(animateJson, This.dur , function(){
                    This.img.each(function(){
                        $(this).children().eq(This.index).css(This.imgmode,0);
                    });
                });
            });
        },
        imgFade : function(){
            var This = this;
            This.img.each(function(){
                $(this).children().eq(This.index).stop().fadeIn(This.dur);
                $(this).children().eq(This.indexB).stop().fadeOut(This.dur,function(){
                    This.img.each(function(){
                        $(this).children().eq(This.index).css('display','block').siblings().css('display','none');
                    });
                }); 
            });
        },
        imgSlip : function(){
            var This = this;
            var d = Math.floor(Math.random()*4);
            var moveL,movemode,animateJson={};
            switch (d)
            {
                case 0:movemode='top';moveL = This.img.height();break;
                case 1:movemode='top';moveL = -This.img.height();break;
                case 2:movemode='left';moveL = This.img.width();break;
                case 3:movemode='left';moveL = -This.img.width();break;
            };
            animateJson[movemode] = -moveL+'px';
            animateJson.opacity = 0;
            this.img.each(function(){
                $(this).children().eq(This.index).css({'left':0,'top':0,'display':'block','opacity':1,'z-index':1});
                $(this).children().eq(This.indexB).stop().css({'z-index':2}).animate(animateJson,This.dur,function(){
                    This.img.each(function(){
                        $(this).children().eq(This.index).css('display','block').siblings().css('display','none');
                    });
                });
                
            });
        },
        tabmove : function(){
            var This = this;
            this.tab.each(function(){
                $(this).children().eq(This.index).addClass(This.tabOn).siblings().removeClass(This.tabOn);
            })
        }
    };

})();
