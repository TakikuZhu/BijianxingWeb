/**
 * 看图识字前后台交互函数 2017.11.06 唐锦城
 */

//查询字信息并返回前台
$(document).ready(function() {
	function delnote() {
		$('#wordIntrPhoto').children().remove();
	}
	function getQRcode() {
		//var pageUrl = window.location.href;
		var pageUrl = "https://www.bing.com";
		$.ajax({
			type: "get",
			url: "../../library/Wordcontroller/getQRCodeController?pageurl=" + pageUrl,
			async: true,
			cache: false,
			success: function(reg)
			{
				if(reg != null) {
					document.getElementById("qrCode").src = reg;
				}
				if(reg == null){
					alert("二维码暂时无法生成");
				}
			}, error: function()
			{
				//console.log(reg);
				alert("该字不存在，请检查您的输入是否正确23");
			}
		});
	}
	$(".search_btn").click(function() {
		var wordName = $("#wordName").val();
		function judge(val){
			reg = /^[\u4E00-\u9FA5]{1,1}$/;
			if(!reg.test(val)) {
				alert("每次仅查询一个汉字")
				document.getElementById('wordName').value = '';
			}
		}
		var bookType = $("input[name='_fontStyle']:checked").val();
		var wordType = $("input[name='_fontFam']:checked").val();
		if ((wordName == null) || (wordName == "")) {
			alert("未输入字，请重新输入");
		}else {
			judge(wordName);
			if ((bookType == null) || (bookType == "") || (bookType == "undefined")) {
				bookType = "1";
			}
			if ((wordType == null) || (wordType == "") || (wordType == "undefined")) {
				wordType = "1";
			}
			$.ajax({
				type: "get",
				url: "../../library/Wordcontroller/getWordController?wordname=" + wordName + "&booktype=" + bookType + "&wordtype=" + wordType,
				async: true,
				cache: false,
				success: function(reg) {
					console.log(reg);
					var wordArr = [];
					if(reg.toString() != "Word doesn't exist") {
						for(key in reg) {
							wordArr.push(reg[key]);
						}
						if(wordArr.length != null) {
							//当前评论和回复人数
							var userNum = 0;
							document.getElementById("wordPhoto").src = wordArr[0];
							document.getElementById("wordVideo").src = wordArr[1];
							document.getElementById("wordIntrText").innerHTML = wordArr[2][0];
							//创建img节点存放说文解字的图片
							function createImg() {
								delnote();
								var imgNode = document.createElement('img');
								var div1 = document.getElementById('wordIntrPhoto');
								imgNode.setAttribute('src', wordArr[2][1]);
								div1.appendChild(imgNode);
							}
							createImg();
							document.getElementById("wn1").innerHTML = "1. " + wordArr[3][0];
							document.getElementById("wn2").innerHTML = "2. " + wordArr[3][1];
							document.getElementById("wn3").innerHTML = "3. " + wordArr[3][2];
							document.getElementById("wn4").innerHTML = "4. " + wordArr[3][3];
							document.getElementById("wordScore").innerHTML = wordArr[4] + "  （满分100分）";
							document.getElementById("commentCount").innerHTML = wordArr[5].length;
							//统计当前字评论和回复的总人数
							for(var i = 0; i < wordArr[5].length; i++) {
								if(wordArr[5][i][1] != "No reply on this comment") {
									userNum += wordArr[5][i][1].length;
								}else {
									continue;
								}
							}
							document.getElementById("userCount").innerHTML = userNum + wordArr[5].length;								
							getQRcode();
						}
						else {
							alert("该字不存在");
						}
					}
					else {
						alert("该字不存在，请检查您的输入是否正确11");
					}
				}, error: function() {
					alert("该字不存在，请检查您的输入是否正确21");
				}
			});
		}
	})
})