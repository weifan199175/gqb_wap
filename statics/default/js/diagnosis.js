function loading() {
    var txt = $(".loadingMsg").text();
    var len = $(".loadingMsg").attr("len");
    len = parseInt(len);
    if (len == 3) {
        len = 0;
        $(".loadingMsg").text("大数据正在计算中,请您耐心等待");
        $(".loadingMsg").attr("len", len);
    } else {
        txt += ".";
        len += 1;
        $(".loadingMsg").attr("len", len);
        $(".loadingMsg").text(txt);
    }
}

function hideLoading() {
    $(".loading").hide();
    $(".resultPage").show();
}
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
    // 开始按钮
    $(".start").on("click", function() {
        $(".welcome").velocity({ left: "-100%" }, 400, function() {
            $(".welcome").remove();
        });
    });
    //滑动解锁开始
    // $(".welcome").on("touchstart", function(e) {
    //     e.preventDefault();
    //     startX = e.originalEvent.changedTouches[0].pageX,
    //         startY = e.originalEvent.changedTouches[0].pageY;
    // });
    // $(".welcome").on("touchmove", function(e) {
    //     e.preventDefault();
    //     moveEndX = e.originalEvent.changedTouches[0].pageX,
    //         moveEndY = e.originalEvent.changedTouches[0].pageY,
    //         X = moveEndX - startX,
    //         Y = moveEndY - startY;

    //     if (X < 0) {
    //         $(".welcome").velocity({ left: "-100%" }, 400, function() {
    //             $(".welcome").remove();
    //         });
    //     }
    // });
    //滑动解锁结束
    //li选择人数更改
    $(".numList li").on("click", function() {
        $(".peopleNumDiv").attr("sts", 'on');
        $(this).addClass('thisli');
        $(this).siblings('li').removeClass('thisli');
        var num = $(this).attr("value");
        $(".sharesList li").remove();
        // $(".moneyList li").remove();
        $(".ceoList li").remove();
        $(".bossList li").remove();
        // $(".familyList li").remove();
        $(".fullList li").remove();
        // $(".memberList li").remove();
        var liNum;
        var li;
        var manager = $("<li sts='0'>职业经理人</li>");
        for (var i = 1; i <= num; i++) {
        	if(num=='1')
        	{
        		liNum = $("<li><span>第" + i + "股东</span><input value='100' type='number' name='股东"+i+"'/>%</li>");
                li = $("<li sts='0'>第" + i + "股东</li>");
                $(".sharesList").append(liNum);
                $(".ceoList,.fullList,.bossList").append(li);
        	}else{
        		liNum = $("<li><span>第" + i + "股东</span><input type='number' name='股东"+i+"'/>%</li>");
                li = $("<li sts='0'>第" + i + "股东</li>");
                $(".sharesList").append(liNum);
                $(".ceoList,.fullList,.bossList").append(li);      		
        	}
            
        }
        $(".ceoChoose").append(manager);
    });
    $(".numList li:eq(1)").click();
    // 身份信息
    $(".identityDiv li").click(function(){
        $(this).attr("sts",1);
        $(this).addClass('thisli');
        $(this).siblings('li').removeClass('thisli');
        $(this).siblings('li').attr("sts",0);
    });
    // 是否CEO
    $(".ceoChoose").on("touchstart touchmove touchend", "li", function(event) {
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
    
    // 是否是董事长
    $(".bossList").on("touchstart touchmove touchend", "li", function() {
        switch (event.type) {
            case 'touchstart':
                falg = false;
                break;
            case 'touchmove':
                falg = true;
                break;
            case 'touchend':
                if (!falg) {

                    if ($(this).attr('sts') == 0) {
                        $(this).attr('sts', '1');
                        $(this).addClass('thisli');
                        $(this).siblings('li').removeClass('thisli');
                        $(this).siblings('li').attr('sts', '0');
                    } else if ($(this).attr('sts') == 1) {
                        $(this).attr('sts', '0');
                        $(this).removeClass('thisli');
                    }
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

    // 是否有高管期权池
    $(".switchDivList li").on("click", function() {
        var sts = $(this).attr("sts");
            $(this).addClass('thisli');
            $(this).attr("sts", 1);
            $(this).siblings('li').removeClass('thisli');
            $(this).siblings('li').attr("sts", 0);
       
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


    // 清空百分比
    $(".resetBtn").on("click", function() {
        $(this).parent(".inputTitle").next("ul").find('input').val("");
    });

    // loading信息
    var loadingAn = setInterval("loading()", 1000);
 // 显示提示信息
    $(".peopleNum img,.switchDivTitle img").click(function() {
        $(".cover,.tip").show();
    });
    $(".tipTitle .close").click(function(){
        $(".cover,.tip").hide();
    });
    $(".importantTitle .close").click(function(){
        $(".cover,.important").hide();
    });
});
