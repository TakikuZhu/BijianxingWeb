
//查询字信息并返回前台
$(document).ready(function() {
	$("#findWord").click(function() {
		var wordName = $("#wordName").val();
		function judge(val){
			reg = /^[\u4E00-\u9FA5]{1,1}$/;
			if(!reg.test(val)) {
				alert("每次仅查询一个汉字")
				document.getElementById('wordName').value = '';
			}
		}
		if ((wordName == null) || (wordName == "")) {
			alert("未输入字，请重新输入");
		}
		else {
			judge(wordName);
			$.ajax({
				type: "get",
				url: "../../manageWord/Wordcontroller/searchNewWordController?wordname=" + wordName,
				async: true,
				cache: false,
				success: function(reg) {
					console.log(reg);
					var wordArr = [];
					if(reg.toString() != "Such word doesn't exist in table new word") {
						for(key in reg) {
							wordArr.push(reg[key]);
						}
						if(wordArr.length != null) {
							var version = null;
							var grade = null;
							var course = null;
							//
							function createA(version, grade, course, i) {
								var note1 = document.createElement('label');
								var note2 = document.createElement('label');
								var note3 = document.createElement('label');
								var div1 = document.getElementById('Version');
								var div2 = document.getElementById('Grade');
								var div3 = document.getElementById('Course');
								note1.setAttribute('id', "a" + i);
								note1.setAttribute('value', version);
								note1.innerHTML = version;
								note2.setAttribute('id', "b" + i);
								note2.setAttribute('value', grade);
								note2.innerHTML = grade;
								note3.setAttribute('id', "c" + i);
								note3.setAttribute('value', course);
								note3.innerHTML = course;
								div1.appendChild(note1);
								div2.appendChild(note2);
								div3.appendChild(note3);
							}
							//
							for(var i = 0; i < reg.length; i++) {
								version = reg[i][0];
								grade = reg[i][1];
								course = reg[i][2];
								createA(version, grade, course, i);
							}
						}else {
							alert("该字不存在");
						}
					}else if(reg.toString() != "All new word retrieve fail") {
						alert("生字表记录获取失败");
					}else {
						alert("该字不存在于生字表");
					}
				}, error: function() {
					alert("该字不存在，请检查您的输入是否正确");
				}
			});
		}
	})
})