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
					document.querySelector('.search_table').style.display = 'none';
					alert("二维码暂时无法生成");
				}
			}, error: function()
			{
				document.querySelector('.search_table').style.display = 'none';
				alert("该字不存在，请检查您的输入是否正确");
			}
		});
	}
	$(".search_btn").click(function() {
		var wordName = $('#wordName').val();
		var bookType = $("input[name='_fontStyle']:checked").val();
		var wordType = $("input[name='_fontFam']:checked").val();
		if ((bookType == null) || (bookType == "") || (bookType == "undefined")) {
			bookType = "1";
		}
		if ((wordType == null) || (wordType == "") || (wordType == "undefined")) {
			wordType = "1";
		}
		if ((wordName == null) || (wordName == "")) {
			document.querySelector('.search_table').style.display = 'none';
			alert("尚未选择生字，请重新选择");
		}
		else {
			$.ajax({
				type: "get",
				url: "../../library/Wordcontroller/getWordController?wordname=" + wordName + "&booktype=" + bookType + "&wordtype=" + wordType,
				async: true,
				cache: false,
				success: function(reg) {
					document.querySelector('.search_table').style.display = 'block';
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
							//创建img节点
							function createImg() {
								delnote();
								var imgNode = document.createElement('img');
								var div1 = document.getElementById('wordIntrPhoto');
								imgNode.setAttribute('src', wordArr[2][1]);
								div1.appendChild(imgNode);
							}
							function createNote(note) {
								//delnote();
								var ul = document.getElementById('wordNote');
								var li = document.createElement('li');
								li.innerHTML = note;
								ul.appendChild(li);
							}
							createImg();
							for(var j = 0; j < wordArr[3].length; j++){
								note = wordArr[3][j];
								createNote(note);
							}
							document.getElementById("wordScore").innerHTML = wordArr[4] + "  （满分100分）";
							document.getElementById("commentCount").innerHTML = wordArr[5].length;
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
					}else {
						document.querySelector('.search_table').style.display = 'none';
						alert("该字不存在，请检查您的输入是否正确");
					}
				}, error: function() {
					document.querySelector('.search_table').style.display = 'none';
					alert("该字不存在，请检查您的输入是否正确");
				}
			});
		}
	})
})