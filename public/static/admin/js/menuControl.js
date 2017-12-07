$(document).ready(function(){
	$(".menu_con").on("click",function(){
		var num = $(this).attr("data-id");
		$(".menu_list .menu_list_div").css("display","none");
		$(".menu_list .menu_list_div").eq(num).css("display","block");
	})
	$(window).scroll(function(){
		var top = $(window).scrollTop();
		if(top >= 230){
			$(".left_menu").css("position","fixed");
			$(".left_menu").css("top","70px");
		}
		else{
			$(".left_menu").css("position","inherit");
			$(".left_menu").css("top","0px");
			$(".rig").addClass("col-lg-offset-4");
		}
	})
})
