$(document).ready(function() {
	$("#fontV").change(function() {
		var word = null;
		var version = $("input[name='_fontVersion']:checked").val();
		var grade = $('#grade option:selected').val();
		var course = $('#course option:selected').val();
		if((version == null) || (version == "") || (version == "undefined")) {
			version = "人教版";
		}
		if((grade == null) || (grade == "") || (grade == "undefined")) {
			grade = "一年级";
		}
		if((course == null) || (course == "") || (course == "undefined")) {
			course = "第一课";
		}
		$.ajax({
			type: "get",
			url: "../../library/Wordcontroller/getNewWordController?version=" + version + "&grade=" + grade + "&course=" + course,
			async: true,
			cache: false,
			success: function(reg) {
				var wordArr = [];
				if(reg.toString() != "Word doesn't exist") {
					for(key in reg) {
						wordArr.push(reg[key]);
					}
					if(wordArr.length != null) {
						//创建a标签
						function createA(word, i) {
							var note = document.createElement('a');
							var a = document.getElementById('newWord');
							note.setAttribute('id', "a" + i);
							note.setAttribute('value', word);
							note.setAttribute('onclick', "saveValue(this);");
							note.innerHTML = word;
							a.appendChild(note);
						}
						//根据查询的生字个数创建a标签
						for(var i = 0; i < reg.length; i++) {
							word = reg[i];
							createA(word, i);
						}
					}
				}else {
					alert("该版本无生字，请选择其他版本");
				}
			}, error: function() {
				alert("该字不存在，请检查您的输入是否正确");
			}
		});
	})
})