
//查询字信息并返回前台
$(document).ready(function() {
	function delnote() {
		$('#wordIntrPhoto').children().remove();
	}
	$("#findWord").click(function() {
		var wordName = $("#wordName").val();
		function judge(val){
			reg = /^[\u4E00-\u9FA5]{1,1}$/;
			if(!reg.test(val)) {
				document.querySelector('.search_table').style.display = 'none';
				alert("每次仅查询一个汉字")
				document.getElementById('wordName').value = '';
			}
		}
		var bookType = $('#bookType option:selected').val();
		var wordType = $('#wordType option:selected').val();
		if ((wordName == null) || (wordName == "")) {
			alert("未输入字，请重新输入");
		}else {
			judge(wordName);
			if ((bookType == null) || (bookType == "") || (bookType == "undefined")) {
				alert("未选择书体");
			}
			if ((wordType == null) || (wordType == "") || (wordType == "undefined")) {
				alert("未选择笔体");
			}
			$.ajax({
				type: "get",
				url: "../../manageWord/Wordcontroller/searchWordController?wordname=" + wordName + "&booktype=" + bookType + "&wordtype=" + wordType,
				async: true,
				cache: false,
				success: function(reg) {
					//console.log(reg);
					var wordArr = [];
					if(reg.toString() != "Word doesn't exist") {
						for(key in reg) {
							wordArr.push(reg[key]);
						}
						if(wordArr.length != null) {
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
							document.getElementById("wordVersion").innerHTML = wordArr[5];
							document.getElementById("wordGrade").innerHTML = wordArr[6];
							document.getElementById("wordCourse").innerHTML = wordArr[7];
						}else {
							alert("该字不存在");
						}
					}else {
						alert("该字不存在1");
					}
				}, error: function() {
					alert("该字不存在，请检查您的输入是否正确21");
				}
			});
		}
	})
})