    $(".dot").each(function(){
        $(this).dotdotdot({
            ellipsis: '... '
        });
    });
    $(window).resize(function(){
        $(".dot").each(function(){
            $(this).dotdotdot({
                ellipsis: '... '
            });
        });
    });
