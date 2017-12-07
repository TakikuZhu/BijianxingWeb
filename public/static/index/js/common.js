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
})