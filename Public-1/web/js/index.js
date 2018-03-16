
$(function () {

	/*公共部分js*/
	
	//点击进入页面指定位置
	var hash = location.hash;
	var index = $(hash).index();
	var pageid = $(".right-cont").data("pageid");
	var currentNav = $(".nav-box").eq(pageid).find("li");
	var length = $(".right-cont").children(hash).length;
	if (length > 0) {
		$(".left-menu li").eq(index).children("a").addClass("active").parent("li").siblings("li").children("a").removeClass("active");
		$(".sub-nav li").children("a").removeClass("active");
		currentNav.eq(index).children("a").addClass("active").end().siblings("li").children("a").removeClass("active");
		$(hash).addClass("cur").siblings(".cont-detail").removeClass("cur");
	}
	//导航栏移入出现下拉框
	$(".nav-title").mouseover(function () {
		$(this).addClass("cur").siblings(".sub-nav").show();
		$(this).parent().siblings(".nav-box").children(".sub-nav").hide().end().children(".nav-title").removeClass("cur");
	})
	$(".sub-nav").mouseover(function () {
		$(this).show().siblings(".nav-title").addClass("cur");
	})
	$(".sub-nav").mouseout(function () {
		$(this).hide().siblings(".nav-title").removeClass("cur");
	})
	//导航栏下拉框点击效果
	$(".sub-nav li").click(function () {
		var index = $(this).index();
		$(".sub-nav li").children("a").removeClass("active");
		$(this).children("a").addClass("active").end().siblings("li").children("a").removeClass("active");
		$(".left-menu li").eq(index).children("a").addClass("active").parent("li").siblings("li").children("a").removeClass("active");
		$(".right-cont .cont-detail").eq(index).addClass("cur").siblings(".cont-detail").removeClass("cur");
	})
	//除首页外的点击侧边栏效果
	$(".left-menu li a").click(function () {
		var index = $(this).parent("li").index();
		$(this).addClass("active").parent("li").siblings("li").children("a").removeClass("active");
		$(".right-cont .cont-detail").eq(index).addClass("cur").siblings(".cont-detail").removeClass("cur");
		$(".sub-nav li").children("a").removeClass("active");
		currentNav.eq(index).children("a").addClass("active").end().siblings("li").children("a").removeClass("active");
	})

		
	/*首页页面js*/

	//首页地点按钮点击效果
	$(".address-btn li").click(function () {
		$(this).addClass("cur").siblings("li").removeClass("cur");
	})
	//首页商品栏鼠标悬停效果
	$(".goods_cont li").mouseover(function () {
		$(this).children("div").fadeIn().end().siblings("li").children("div").fadeOut();
	})
	$(".goods_cont li div").mouseout(function () {
		$(this).stop().fadeOut();
	})
	

	
	/*展会页面js*/

	//平面图部分 点击切换效果
	$(".plan-num li").click(function () {
		var index = $(this).index();
		$(this).addClass("cur").siblings("li").removeClass("cur");
		$(".plan-box li").eq(index).addClass("cur").siblings("li").removeClass("cur");
	})


	/*商品页面js*/

	//商品浏览的
	$(".limit-num li").click(function () {
		var index = $(this).index();
		$(this).addClass("cur").siblings("li").removeClass("cur");
		// $(".plan-box li").eq(index).addClass("cur").siblings("li").removeClass("cur");
	})
	$(".browse-num li").click(function () {
		var index = $(this).index();
		$(this).addClass("cur").siblings("li").removeClass("cur");
		// $(".plan-box li").eq(index).addClass("cur").siblings("li").removeClass("cur");
	})
})