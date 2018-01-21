$(document).ready(function(){
	$("#l_logined").on("click",function(){
		if($("#l_login_list").attr('data-type') == 0){
			$("#l_login_list").css("display","block");
			$("#l_login_list").attr('data-type',"1");
		} else {
			$("#l_login_list").css("display","none");
			$("#l_login_list").attr('data-type',"0");
		}
	})

	var count = 0;
	setInterval(function(){
		count ++;
		if(count > $("#scroll_ad ul li").length){
			count = 0;
		}
		$("#scroll_ad ul").animate({
			marginTop : - count * 20 + 'px'
		}, 1000)
		console.log(count);
	},5000)

	var count2 = 0;
	$("#img_list li").eq(count2).css('opacity', '1');
	$("#ctl_list li").eq(count2).css('opacity', '1');
	setInterval(function(){
		
		$("#img_list").children().eq(count2).animate({
			opacity: '0'
		}, 1000)
		count2 ++;
		if(count2 > 5){
			count2 = 0;
		}
		$("#img_list").children().eq(count2).animate({
			opacity: '1'
		}, 1000)
		$("#scroll_img").attr('data-cl', count2);
		console.log(count2);
		$("#ctl_list li").css('opacity', '.6');
		$("#ctl_list li").eq(count2).css('opacity', '1');
	},10000)
	$("#ctl_list li").on('click',function(){
		var mark = $(this).attr('data-cl');
		if(mark == count2){

		} else {
			$("#img_list").children().eq(count2).animate({
				opacity: '0'
			}, 1000)
			count2 = mark;
			$("#img_list").children().eq(count2).animate({
				opacity: '1'
			}, 1000)
			$("#scroll_img").attr('data-cl', count2);
			console.log(count2);
			$("#ctl_list li").css('opacity', '.6');
			$("#ctl_list li").eq(count2).css('opacity', '1');
		}
	})
	/*测试
	for(var i = 0; i < $("#img_list li").length; i ++){
		// $("#img_list").children().eq(i).css("background", '#6cf');
		$("#img_list").children().eq(i).css('background',getColor());
	}
	function getRandom(){
		var res = Math.random()*255;
		res = Math.floor(res);
		return res;
	}
	function getColor(){
		var color = 'rgb(';
		color += getRandom();
		color += ',';
		color += getRandom();
		color += ',';
		color += getRandom();
		color += ')';
		return color;
	}
	//*/
})