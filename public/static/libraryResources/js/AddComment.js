$(document).ready(function() {
	$("#_push").click(function() {
		var userId = "3";
		var thumbup = "0";
		var comment = $("#myComment").val();
		console.log(comment);
		var wordName = $("#wordName").val();
		if (userId == null) {
			alert("请先登录然后再发表评论");
		}
		if ((wordName == null) || (wordName == "")) {
			alert("请重新输入所查询的字");
		}
		if((comment == null) || (comment == "")) {
			alert("评论内容为空，请重新输入");
		}else {
			$.ajax({
				type: "post",
				url: "../../library/Wordcontroller/addCommentController?wordname="
					+ wordName + "&comment=" + comment + "&thumbup=" + thumbup + "&userid=" + userId,
				async: true,
				cache: false,
				success: function(reg) {
					if(reg.toString() == "Add comment successfully") {
						alert("评论添加成功");
					}
				}, error: function() {
					alert("该字不存在，请检查您的输入是否正确3");
				}
			});
		}
	})
})