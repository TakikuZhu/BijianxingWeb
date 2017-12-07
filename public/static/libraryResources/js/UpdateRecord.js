$(document).ready(function() {
	$('#updateWord').click(function() {
		var wordName = $("#wordName").val();
		function judge(val){
			reg = /^[\u4E00-\u9FA5]{1,1}$/;
			if(!reg.test(val)) {
				alert("每次仅能修改一个生字")
				document.getElementById('wordName').value = '';
			}
		}
		var version = $('#version option:selected').val();
		var grade = $('#grade option:selected').val();
		var course = $('#course option:selected').val();
		var bookType = $('#bookType option:selected').val();
		var wordType = $('#wordType option:selected').val();
		var wordPhoto = $('#wordPhoto').src;
		var wordNote = $('#wordNote').val();
		var wordVideo = $('#wordVideo').src;
		var wordIntrDcp = $('#wordIntrDcp').val();
		console.log(wordName);
		console.log(bookType);
		console.log(wordType);
		//var wordIntrPhoto = $('#wordIntrPhoto').src;
		if ((bookType == null) || (bookType == "") || (bookType == "undefined")) {
			alert('书体未选择');
		}
		if ((wordType == null) || (wordType == "") || (wordType == "undefined")) {
			alert('笔体未选择');
		}
		if ((wordName == null) || (wordName == "")) {
			alert('未输入字，请重新输入');
		}else {
			judge(wordName);
			$.ajax({
				type: "post",
				url: "../../manageWord/Wordcontroller/updateWordController?wordname=" + wordName + "&booktype=" + 
					bookType + "&wordtype=" + wordType + "&wordphoto=" + wordPhoto + "&wordnote=" + wordNote + "&wordvideo=" 
					+ wordVideo + "&wordintrdcp=" + wordIntrDcp + "&wordintrphoto=" + wordIntrPhoto + "&version=" + version 
					+ "&grade=" + grade + "&course=" + course,
				async: true,
				cache: false,
				success: function(reg) {
					if(reg.toString() == "Word doesn't exist, unable to update") {
						alert("该字不存在，无法更新");
					}else if(reg.toString() == "New word doesn't exist, unable to update") {
						alert("该生字不存在，无法更新");
					}else if(reg.toString() == "Word update successfully") {
						alert("添加成功");
					}
				}, error: function() {
					alert("更新失败");
				}
			})
		}
	})
})