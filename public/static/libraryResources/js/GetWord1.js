/**
 * 看图识字前后台交互函数 2017.11.06 唐锦城
 */

//查询字信息并返回前台
$(document).ready(function() {
	$(".search_btn").click(function() {
		window.location.href = "flashcard_single.html";
		var wordName = $("#_font").val();
		var bookType = $("input[name='penType']:checked").val();
		var wordType = $("input[name='bookType']:checked").val();
		
		if ((wordName == null) || (wordName == "")) {
			alert("请重新输入所查询的字");
		}else {
			$.ajax({
				type: "get",
				url: "/bijianxing/public/index/wordController/getWordController?wordname=" + wordName + "&booktype=" + bookType + "&wordtype=" + wordType,
				async: true,
				cache: false,
				success: function(reg) {
					var wordArr = [];
					for(key in reg) {
						wordArr.push(reg[key]);
					}
					console.log(wordArr);
					if(wordArr.length != null) {
						document.getElementById("wordPhoto").src = wordArr[0];
						document.getElementById("wordVideo").src = wordArr[1];
						document.getElementById("item3mobile").innerHTML = wordArr[2];
						//$(".font_search).innerHTML = wordArr[2];
						document.getElementById("wn1").innerHTML = "1. " + wordArr[3][0];
						document.getElementById("wn2").innerHTML = "2. " + wordArr[3][1];
						document.getElementById("wn3").innerHTML = "3. " + wordArr[3][2];
						document.getElementById("wn4").innerHTML = "4. " + wordArr[3][3];
						//document.getElementById("wordScore").innerHTML = wordArr[4];
					}
				}, error: function() {
					alert("该字不存在，请检查您的输入是否正确");
				}
			});
		}
	})
})

/*$(document).ready(function() {
	
})*/