
$(function () {
	function getRadioValue(radioName) {
		var chkRadio = document.getElementsByName(radioName);
		for (var i = 0; i < chkRadio.length; i++) {
			if (chkRadio[i].checked)
				return chkRadio[i].value;
		}
	}
	$("#dcomments_reset").on("click", function () {
		$("#dcid").val("");
	})

	$("#ucomments_reset").on("click", function () {
		$("#ucid").val("");
	})
	$("#Coselect_all").on("click", function () { 
		$("[name='coselect']").attr("checked",'true');//全选 
	}) 
	$("#Codelete_all").on("click", function () { 
		var input = $("#commentsTable").find("input");
		var j = [];
		var k = 0;
		var r = confirm("确定要删除这些评论吗？")
		if (r == true) {
			for (var i = 0; i < input.length; i++) {
				var row = {};
				if (input.eq(i).is(':checked')) {
					row.coid = input.eq(i).val();
            	//alert(input.eq(i).val());
            	j.push(row);
            	k++;
            }
        }
        if(k==0){
        	alert("未选中项目");
        	return false;
        }
        $.ajax({
        	type: "post",
        	url: "deleteSelectComments/",
        	data: { da: j},
            // headers: {
            //     Accept: "application/json",
            //     "Content-Type": "application/json"
            // },
            success: function (reg) {
            	for (var i = 0; i < input.length; i++) {
            		if (input.eq(i).is(':checked')) {
            			input.eq(i).parent().parent().remove();
            		}
            	}


            },
            error: function () {
            	alert("服务器发生错误，删除失败！");
            }
        })
    }
}) 
	$("#dcomments_search").on("click", function () {
		if($("#dcid").val().trim()!=""){
			var words = $("#dcid").val();
			var chk2 = getRadioValue("dcommentsace");
			$.ajax({
				type: "get",
				url: 'getCommentsByWords/'+chk2,
				async: true,
				cache: false,
				data:{da:words},
				success: function (reg) {
					if (reg) {
						$("#commentsTable").text("");
						$('#coPage').show();
						$('#coPage').pagination({
							totalData:reg.length,
							showData:5,
							coping:true,
							callback:function(api){
								$("#commentsTable").text("");
								var str = "";
								for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

									str += "<tr class=''><td class='col-lg-1'>";
									str += "<input type='checkbox' name='coselect' value="+reg[i].comment_id+">";
									str += "</td><td class='col-lg-1'>";
									str += reg[i].sender_name;
									str += "</td><td class='col-lg-1'>";
									str += reg[i].receiver_name;
									str += "</td><td class='col-lg-4'>";
									str += reg[i].ccontent;
									str += "</td><td class='col-lg-2'><a href=index/dynamics/index?dynamic_id="+reg[i].cdynamic+" target=_blank>";
									str += reg[i].theme;
									str += "</a></td><td class='col-lg-2'>";
									str += reg[i].ctime;
									str += "</td><td class='col-lg-1'>";
									str += "<a class='co_delete'>删除</a>"
									str += "</td></tr>";

								}
								$("#commentsTable").append(str);


							}
						},function(api){
							$("#commentsTable").text("");
							var str = "";
							for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='coselect' value="+reg[i].comment_id+">";
						str += "</td><td class='col-lg-1'>";
						str += reg[i].sender_name;
						str += "</td><td class='col-lg-1'>";
						str += reg[i].receiver_name;
						str += "</td><td class='col-lg-4'>";
						str += reg[i].ccontent;
						str += "</td><td class='col-lg-2'><a href=index/dynamics/index?dynamic_id="+reg[i].cdynamic+" target=_blank>";
						str += reg[i].theme;
						str += "</a></td><td class='col-lg-2'>";
						str += reg[i].ctime;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='co_delete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#commentsTable").append(str);
				});
						
					}
					else{
						alert("没有该关键词的评论");
					}
				}
			})
		}else{
			alert("未填写关键词");
		}
	}

	);
	$("#dcomments2_search").on("click", function () {
		if($("#dcid").val().trim()!=""){
			var words = $("#dcid").val();
			var chk2 = getRadioValue("dcommentsace");
			chk2 = chk2+2;
			$.ajax({
				type: "get",
				url: 'getCommentsByWords/'+chk2,
				async: true,
				cache: false,
				data:{da:words},
				success: function (reg) {
					if (reg) {
						$("#commentsTable").text("");
						$('#coPage').show();
						$('#coPage').pagination({
							totalData:reg.length,
							showData:5,
							coping:true,
							callback:function(api){
								$("#commentsTable").text("");
								var str = "";
								for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

									str += "<tr class=''><td class='col-lg-1'>";
									str += "<input type='checkbox' name='coselect' value="+reg[i].comment_id+">";
									str += "</td><td class='col-lg-1'>";
									str += reg[i].sender_name;
									str += "</td><td class='col-lg-1'>";
									if(reg[i].receiver_name){
										str += reg[i].receiver_name;
									}else{
										str += "  ";
									}
									str += "</td><td class='col-lg-4'>";
									str += reg[i].ccontent;
									str += "</td><td class='col-lg-2'><a href=index/dynamics/index?dynamic_id="+reg[i].cdynamic+" target=_blank>";
									str += reg[i].theme;
									str += "</a></td><td class='col-lg-2'>";
									str += reg[i].ctime;
									str += "</td><td class='col-lg-1'>";
									str += "<a class='co_delete'>删除</a>"
									str += "</td></tr>";

								}
								$("#commentsTable").append(str);


							}
						},function(api){
							$("#commentsTable").text("");
							var str = "";
							for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='coselect' value="+reg[i].comment_id+">";
						str += "</td><td class='col-lg-1'>";
						str += reg[i].sender_name;
						str += "</td><td class='col-lg-1'>";
						if(reg[i].receiver_name){
										str += reg[i].receiver_name;
									}else{
										str += "  ";
									}
						str += "</td><td class='col-lg-4'>";
						str += reg[i].ccontent;
						str += "</td><td class='col-lg-2'><a href=index/dynamics/index?dynamic_id="+reg[i].cdynamic+" target=_blank>";
						str += reg[i].theme;
						str += "</a></td><td class='col-lg-2'>";
						str += reg[i].ctime;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='co_delete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#commentsTable").append(str);
				});
						
					}
					else{
						alert("没有该关键词的评论");
					}
				}
			})
		}else{
			alert("未填写关键词");
		}
	}

	);

	$("#ucomments_search").on("click", function () {
		if($("#ucid").val().trim()!=""){
			var name = $("#ucid").val();
			var chk2 = getRadioValue("ucommentsace");
			$.ajax({
				type: "get",
				url: 'getCommentsByName/'+chk2,
				async: true,
				cache: false,
				data:{da:name},
				success: function (reg) {
					if (reg) {
						$("#commentsTable").text("");
						$('#coPage').show();
						$('#coPage').pagination({
							totalData:reg.length,
							showData:5,
							coping:true,
							callback:function(api){
								$("#commentsTable").text("");
								var str = "";
								for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

									str += "<tr class=''><td class='col-lg-1'>";
									str += "<input type='checkbox' name='coselect' value="+reg[i].comment_id+">";
									str += "</td><td class='col-lg-1'>";
									str += reg[i].sender_name;
									str += "</td><td class='col-lg-1'>";
									str += reg[i].receiver_name;
									str += "</td><td class='col-lg-4'>";
									str += reg[i].ccontent;
									str += "</td><td class='col-lg-2'><a href=index/dynamics/index?dynamic_id="+reg[i].cdynamic+" target=_blank>";
									str += reg[i].theme;
									str += "</a></td><td class='col-lg-2'>";
									str += reg[i].ctime;
									str += "</td><td class='col-lg-1'>";
									str += "<a class='co_delete'>删除</a>"
									str += "</td></tr>";

								}
								$("#commentsTable").append(str);


							}
						},function(api){
							$("#commentsTable").text("");
							var str = "";
							for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='coselect' value="+reg[i].comment_id+">";
						str += "</td><td class='col-lg-1'>";
						str += reg[i].sender_name;
						str += "</td><td class='col-lg-1'>";
						str += reg[i].receiver_name;
						str += "</td><td class='col-lg-4'>";
						str += reg[i].ccontent;
						str += "</td><td class='col-lg-2'><a href=index/dynamics/index?dynamic_id="+reg[i].cdynamic+" target=_blank>";
						str += reg[i].theme;
						str += "</a></td><td class='col-lg-2'>";
						str += reg[i].ctime;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='co_delete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#commentsTable").append(str);
				});

					}
					else{
						alert("该用户没有评论");
					}
				}
			})
		}else{
			alert("未填写用户名");
		}
	});
	$("#ucomments2_search").on("click", function () {
		if($("#ucid").val().trim()!=""){
			var name = $("#ucid").val();
			var chk2 = 2;
			$.ajax({
				type: "get",
				url: 'getCommentsByName/'+chk2,
				async: true,
				cache: false,
				data:{da:name},
				success: function (reg) {
					if (reg) {
						$("#commentsTable").text("");
						$('#coPage').show();
						$('#coPage').pagination({
							totalData:reg.length,
							showData:5,
							coping:true,
							callback:function(api){
								$("#commentsTable").text("");
								var str = "";
								for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

									str += "<tr class=''><td class='col-lg-1'>";
									str += "<input type='checkbox' name='coselect' value="+reg[i].comment_id+">";
									str += "</td><td class='col-lg-1'>";
									str += reg[i].sender_name;
									str += "</td><td class='col-lg-1'>";
									if(reg[i].receiver_name){
										str += reg[i].receiver_name;
									}else{
										str += "  ";
									}
									str += "</td><td class='col-lg-4'>";
									str += reg[i].ccontent;
									str += "</td><td class='col-lg-2'><a href=index/dynamics/index?dynamic_id="+reg[i].cdynamic+" target=_blank>";
									str += reg[i].theme;
									str += "</a></td><td class='col-lg-2'>";
									str += reg[i].ctime;
									str += "</td><td class='col-lg-1'>";
									str += "<a class='co_delete'>删除</a>"
									str += "</td></tr>";

								}
								$("#commentsTable").append(str);


							}
						},function(api){
							$("#commentsTable").text("");
							var str = "";
							for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='coselect' value="+reg[i].comment_id+">";
						str += "</td><td class='col-lg-1'>";
						str += reg[i].sender_name;
						str += "</td><td class='col-lg-1'>";
						if(reg[i].receiver_name){
							str += reg[i].receiver_name;
						}else{
							str += "  ";
						}
						str += "</td><td class='col-lg-4'>";
						str += reg[i].ccontent;
						str += "</td><td class='col-lg-2'><a href=index/dynamics/index?dynamic_id="+reg[i].cdynamic+" target=_blank>";
						str += reg[i].theme;
						str += "</a></td><td class='col-lg-2'>";
						str += reg[i].ctime;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='co_delete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#commentsTable").append(str);
				});

					}
					else{
						alert("该用户没有评论");
					}
				}
			})
		}else{
			alert("未填写用户名");
		}
	});



})
