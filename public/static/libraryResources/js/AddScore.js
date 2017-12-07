$(document).ready(function() {
	$("#addScore").click(function() {
		var userId = "9";
		var score = $("#myScore").val();
		function judge(val) {
			reg = /^(\\d|[1-9]\\d|100)$/;
			if(!reg.test(val)) {
				document.getElementById('myScore').value = '';
				return 0;
			}else {
				return 1;
			}
		}
		var result = judge(score);
		var wordName = $("#wordName").val();
		var bookType = $("input[name='_fontStyle']:checked").val();
		var wordType = $("input[name='_fontFam']:checked").val();
		if ((bookType == null) || (bookType == "") || (bookType == "undefined")) {
			bookType = "1";
		}
		if ((wordType == null) || (wordType == "") || (wordType == "undefined")) {
			wordType = "1";
		}
		if ((wordName == null) || (wordName == "")) {
			alert("请重新输入所查询的字");
		}
		if((score == null) || (score == "") || (result != 1)) {
			alert("分数输入不正确，请重新输入");
		}else {
			$.ajax({
				type: "post",
				url: "../../library/Wordcontroller/addScoreController?wordname="
					+ wordName + "&booktype=" + bookType + "&wordtype=" + wordType + "&score=" + score + "&userid=" + userId,
				async: true,
				cache: false,
				success: function(reg) {
					if(reg.toString() == "Word doesn't exist") {
						alert("该字不存在，请检查您的输入是否正确1");
					}else if(reg.toString() == "User has added score to this video") {
						alert("用户已给该字打分");
					}else if(reg.toString() == "User add score successfully") {
						alert("用户成功给该字打分");
					}
				}, error: function() {
					alert("该字不存在，请检查您的输入是否正确2");
				}
			});
		}
	})
})