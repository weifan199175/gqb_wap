$(function() {
    
    // $("nav li").on("touchstart", function() {
    //     var txt = $(".numSelect span").text();
    //     if (txt != "选择人数") {
    //         $(this).addClass('this');
    //         $(this).siblings('li').removeClass('this');
    //         var idx = $(this).index();
    //         $(".main>div").eq(idx).show();
    //         $(".main>div").eq(idx).siblings('div').hide();
    //     }else{
    //      alert("请选择人数");
    //     }
    // });
    // 股东数量
    // $(".numSelect select").change(function() {
    //     $(".sharesList li").remove();
    //     $(".moneyList li").remove();
    //     $(".ceoList li").remove();
    //     $(".familyList li").remove();
    //     $(".fullList li").remove();
    //     $(".memberList li").remove();
    //     var num = $(".numSelect select option:selected").attr("value");
    //     var txt = $(".numSelect select option:selected").text();
    //     $(this).prev("span").text(txt);
    //     var liNum;
    //     var li;
    //     for (var i = 1; i <= num; i++) {
    //         // var li = $("<li><li/>");
    //         // var span = $("<span>新玩家<span/>");
    //         // var input = $("<input/>");
    //         // $(li).append(span, input, "%");
    //         liNum = $("<li><span>股东" + i + "</span><input/>%</li>");
    //         li = $("<li sts='0'>股东" + i + "</li>");
    //         $(".sharesList,.moneyList").append(liNum);
    //         $(".ceoList,.familyList,.fullList,.memberList").append(li);
    //     }
    // });

    //li选择人数更改
    $(".numList li").on("click", function() {
        $(".peopleNumDiv").attr("sts", 'on');
        $(this).addClass('thisli');
        $(this).siblings('li').removeClass('thisli');
        var num = $(this).attr("value");
        $(".sharesList li").remove();
        $(".moneyList li").remove();
        $(".ceoList li").remove();
        $(".familyList li").remove();
        $(".fullList li").remove();
        $(".memberList li").remove();
        var liNum;
        var li;
        for (var i = 1; i <= num; i++) {
            liNum = $("<li><span>股东" + i + "</span><input type='tel' name='股东"+i+"'/>%</li>");
            li = $("<li sts='0'>股东" + i + "</li>");
            $(".sharesList,.moneyList").append(liNum);
            $(".ceoList,.familyList,.fullList,.memberList").append(li);
        }
    });
    $(".numList li:eq(1)").click();

    // 是否CEO
    $(".ceoList").on("touchstart touchmove touchend", "li", function(event) {
        switch (event.type) {
            case 'touchstart':
                falg = false;
                break;
            case 'touchmove':
                falg = true;
                break;
            case 'touchend':
                if (!falg) {
                    $(this).addClass('thisli');
                    $(this).siblings('li').removeClass('thisli');
                } else {
                    console.log('滑动');
                }
                break;
        }

    });
    // 是否血缘夫妻
    $(".familyList").on("click", "li", function() {
        var sts = $(this).attr("sts");
        if (sts == 0) {
            $(this).addClass('thisli');
            $(this).attr('sts', 1);
        } else {
            $(this).removeClass('thisli');
            $(this).attr('sts', 0);
        }
    });
    // 全职股东
    $(".fullList").on("click", "li", function() {
        var sts = $(this).attr("sts");
        if (sts == 0) {
            $(this).addClass('thisli');
            $(this).attr('sts', 1);
        } else {
            $(this).removeClass('thisli');
            $(this).attr('sts', 0);
        }
    });

    // 是否有董事会
    $(".directorateDiv").on("click", function() {
        var sts = $(this).attr("sts");
        if (sts == 0) {
            $(this).find('i').css('color', '#04be02');
            $(this).attr("sts", 1);
        } else {
            $(this).find('i').css('color', '#eee');
            $(this).attr("sts", 0);
        }
    });

    // 是否是董事会成员
    $(".memberList").on("click", "li", function() {
        var sts = $(this).attr("sts");
        if (sts == 0) {
            $(this).addClass('thisli');
            $(this).attr('sts', 1);
        } else {
            $(this).removeClass('thisli');
            $(this).attr('sts', 0);
        }
    });

    //规章制度
    $(".rules").on("click", "li", function() {
        var sts = $(this).attr("sts");
        if (sts == 0) {
            $(this).find('i').css('color', '#04be02');
            $(this).attr('sts', 1);
        } else {
            $(this).find('i').css('color', '#eee');
            $(this).attr('sts', 0);
        }

    });
    // 清空百分比
    $(".resetBtn").on("click", function() {
        $(this).parent(".inputTitle").next("ul").find('input').val("");
    });
});
