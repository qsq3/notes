$(function(){
    (function ($){
        var $pages = $(".page");
        var $pagesLen = $pages.length;
        var index = 0,
            indexB = 0,
            delay = 500,
            timeS = new Date();
        init($pages);
        function init ($pages){
            $pages.hide().each(function(i){
                this.pageNum = i;
                $(this).find(".pageFoot").text(i);
            });
            $pages.eq(index).show();
        };

        $(".next").click(function(){
            if( index < $pagesLen-1 && checkDelay()){
                indexB = index;
                index++;
                turnPage(index,indexB);
            }
        });
        $(".prev").click(function(){
            if( index > 0 && checkDelay()){
                indexB = index;
                index--;
                turnPage(index,indexB);
            }
        });
        $(".jump .btn").click(function(){
            var val = $(".jump input").val();
            if( isNaN(val) || val<0 || val>=$pagesLen || val != parseInt(val) ){
                return;
            };
            indexB = index;
            index = val;
            turnPage(index,indexB);

        });

        function turnPage(index,indexB){
            if (index == indexB){
                return;
            }else if (index > indexB){
                turnNext(index,indexB)
            }else{
                turnPrev(index,indexB)
            };
            $(".footer input").val(index);
        };
        function turnPrev(index,indexB){
            $pages.eq(indexB).addClass("turnPrevB");
            $pages.eq(index).addClass("turnPrev").show();
            setTimeout(function(){
                $pages.removeClass("turnPrev turnPrevB").eq(indexB).hide();
            },delay)

        };
        function turnNext(index,indexB){
            $pages.eq(indexB).addClass("turnNextB");
            $pages.eq(index).addClass("turnNext");
            setTimeout(function(){
                $pages.eq(index).show();
            },50)
            setTimeout(function(){
                $pages.removeClass("turnNext turnNextB").eq(indexB).hide();
            },delay)
        }

        //通用函数:
        function checkDelay (d){
            d = d || (delay+100);
            if ( new Date() - timeS >= d){
                return (timeS = new Date());
            }
            return false;
        }
    } )(jQuery)

})
