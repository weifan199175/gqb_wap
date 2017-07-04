// 优能复合材料JS
$(".applicatList li").eq(0).addClass("p_list1");
$(".applicatList li").eq(1).addClass("p_list2");
$(".applicatList li").eq(2).addClass("p_list3");
$(".applicatList li").eq(3).addClass("p_list4");
$(".applicatList li").eq(4).addClass("p_list5");

$(".goodsList li:last-child").addClass("last");
$(".facList li:last-child").addClass("last");
$("..coldHot ul li:nth-child(2n)").addClass("fst");

// 下拉菜单
$(function(){
	$(".subNavBox").hide();
    $(".navBox li").hover(function(){
     $(this).children(".subNavBox").animate({
      height:'toggle'
    });
      $(this).addClass("current");
    },function(){
       $(this).children(".subNavBox").hide().animate(10000);
        $(this).removeClass("current");
    });
});

/*=============指向图片放大===============*/
$(function(){
    $(".list_Img").hover(function(){
        $(this).stop(false,true).animate({width:"110%",height:"110%",top:"-5%",left:"-5%"},300);
    },function(){
        $(this).stop(false,true).animate({top:"0%",left:"0%",width:"100%",height:"100%"},300);
    });
});
/*=============/指向图片放大===============*/

//文本框默认提示文字
function textFocus(el) {
    if (el.defaultValue == el.value) { el.value = ''; el.style.color = '#2c3e50'; }
}
function textBlur(el) {
    if (el.value == '') { el.value = el.defaultValue; el.style.color = '#c3c3c3'; }
}

// 下拉美化
$(function(){
	$(".select").each(function(){
		var s=$(this);
		var z=parseInt(s.css("z-index"));
		var dt=$(this).children("dt");
		var dd=$(this).children("dd");
		var _show=function(){dd.slideDown(200);dt.addClass("cur");s.css("z-index",z+1);};   //展开效果
		var _hide=function(){dd.slideUp(200);dt.removeClass("cur");s.css("z-index",z);};    //关闭效果
		dt.click(function(){dd.is(":hidden")?_show():_hide();});
		dd.find("a").click(function(){dt.html($(this).html());_hide();});     //选择效果（如需要传值，可自定义参数，在此处返回对应的“value”值 ）
		$("body").click(function(i){ !$(i.target).parents(".select").first().is(s) ? _hide():"";});
	})
})


$(".applicatList li").hover(function(){
		$(this).find(".bg").stop().animate({height:"271px"},200);
		$(this).find(".bg em").stop().animate({bottom:"100px"},200);
	},function(){
		$(this).find(".bg").stop().animate({height:"0px"},200);
		$(this).find(".bg em").stop().animate({bottom:"-70px"},200);
	})




$(".whyList li").hover(function(){
		$(this).find(".pic01").stop(true,true).fadeTo(400,0);
		$(this).find(".tt").css('color',"#f39800");
	},function(){
		$(this).find(".pic01").stop(true,true).fadeTo(400,1);
		$(this).find(".tt").css('color',"#fff");
	})





