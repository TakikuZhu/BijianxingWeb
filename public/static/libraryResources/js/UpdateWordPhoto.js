$(document).ready(function() {
	$('#submitPhoto').click(function() {
		var wordName = $("#wordName").val();
		function judge(val) {
			reg = /^[\u4E00-\u9FA5]{1,1}$/;
			if (!reg.test(val)) {
				alert("每次仅能修改一个生字")
				document.getElementById('wordName').value = '';
			}
		}
		var bookType = $('#bookType option:selected').val();
		var wordType = $('#wordType option:selected').val();
		var photo = document.getElementById('photo');
		var wordNote = $('#wordNote').val();
		var wordPhotoUrl = "../../static/libraryResources/img/" + photo.files[0].name;
		if(photo.files[0] != undefined) {
			document.getElementById('photoName').value = photo.files[0].name;
			//alert(document.getElementById('photoName').value);
		}
		var formData = new FormData();
		formData.append("wordphoto", photo.files[0]);
		formData.append("wordname", wordName);
		formData.append("booktype", bookType);
		formData.append("wordtype", wordType);
		formData.append("wordnote", wordNote);
		formData.append("wordphotourl", wordPhotoUrl);
		//alert(wordPhotoUrl);
		var bTFlag = 0;
		var wTFlag = 0;
		var wFlag = 0;
		if ((bookType == null) || (bookType == "") || (bookType == "undefined") || (bookType == 0)) {
			bTFlag = 1;
			alert('书体未选择');
		}
		if ((wordType == null) || (wordType == "") || (wordType == "undefined") || (wordType == 0)) {
			wTFlag = 1;
			alert('笔体未选择');
		}
		if ((wordName == null) || (wordName == "")) {
			wFlag = 1;
			alert('未输入字，请重新输入');
		}
		if ((bTFlag == 0) && (wTFlag == 0) && (wFlag == 0)) {
			judge(wordName);
			$.ajax({
				type: "post",
				url: "../../manageWord/Wordcontroller/uploadPhoto",
				data: formData,
				processData: false,
				contentType: false,
				dataType: "json",
				success : function(reg) {
					alert(reg);
					if (reg.toString() == "Image upload fail1") {
						alert("图像文件上传失败1");
					} else if(reg.toString() == "Image upload fail2") {
						alert("图像文件上传失败2");
					} else if (reg.toString() == "Image upload succeed") {
					    alert("图像文件上传成功");
					}
				}
			})
		} else {
			alert("笔体、书体不完整，请确认笔体、书体均有选择");
		}
	})
})