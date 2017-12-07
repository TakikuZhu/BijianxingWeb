$(document).ready(function() {
	$('#deleteWord').click(function() {
		var wordName = $("#wordName").val();
		function judge(val){
			reg = /^[\u4E00-\u9FA5]{1,1}$/;
			if(!reg.test(val)) {
				alert("每次仅能删除一个字")
				document.getElementById('wordName').value = '';
			}
		}
		var bookType = $('#bookType option:selected').val();
		var wordType = $('#wordType option:selected').val();
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
				url: "../../manageWord/Wordcontroller/deleteWordController?wordname=" + wordName + "&booktype=" + 
					bookType + "&wordtype=" + wordType,
				async: true,
				cache: false,
				success: function(reg) {
					if(reg.toString() == "Word doesn't exist, unable to delete") {
						alert("该字不存在，无法删除");
					}
					else if(reg.toString() == "Photo doesn't exist") {
						alert("字图不存在");
					}
					else if(reg.toString() == "Video doesn't exist") {
						alert("视频不存在");
					}
					else if(reg.toString() == "Note doesn't exist") {
						alert("书写要点不存在");
					}
					else if(reg.toString() == "Intr doesn't exist") {
						alert("说文解字内容不存在");
					}
					else if(reg.toString() == "Word delete successfully") {
						alert("删除成功");
					}
				}, error: function() {
					alert("删除失败");
				}
			})
		}
	})
})