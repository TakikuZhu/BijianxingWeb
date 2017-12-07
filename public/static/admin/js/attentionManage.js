
$(function () {
	function getRadioValue(radioName) {
		var chkRadio = document.getElementsByName(radioName);
		for (var i = 0; i < chkRadio.length; i++) {
			if (chkRadio[i].checked)
				return chkRadio[i].value;
		}
	}
	$("#op_reset").on("click", function () {
		$("#attentionOp").val("");
	})

	$("#message_submit").on("click", function () {
		if($("#msgcontent").val().trim()!=""){
			var content = $("#msgcontent").val();
			$.ajax({
				type: "get",
				url: "addGroupMessage/",
				eache: false,
				data:{da:content},
				success: function(reg) {
					if(reg){
						$("#msgcontent").val("");
						alert("消息发送成功");
					}else{
						alert("消息发送失败");
					}
				},
				error: function() {
					alert("服务器发生错误");  
				}
			});
		}else{
			alert("未填写消息内容");
		}
	})

	$("#time_reset").on("click", function () {
		$("#attentionDate").val("");
	})
	$(".userMan").delegate(".atdelete", "click", function () {
		var input = $(this).parent().parent().find("input");
		var tr = $(this).parent().parent();
		var atId = input.val();
		var r = confirm("确定要删除该通知吗？")
		if (r == true) {
			$.ajax({
				type: 'post',
				url: 'messageDelete/'+atId,
				success: function (reg) {
					tr.remove();
					alert(reg);
				},
				error: function () {
					alert("服务器发生错误，动态通知失败！")
				}
			});
		}
	})
	$("#op_search").on("click", function () {
		if($("#attentionOp").val().trim()!=""){
			var op = $("#attentionOp").val();
			$.ajax({
				type: "get",
				url: 'getAttentionByName/',
				async: true,
				cache: false,
				data: {da:op},
				success: function (reg) {
					if (reg) {
						$("#attentionTable").text("");
						$('#atPage').show();
						$('#atPage').pagination({
							totalData:reg.length,
							coping:true,							
							homePage:'首页',
    						endPage:'末页',
							showData:5,

							callback:function(api){
								$("#attentionTable").text("");
								var str = "";
								for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

									str += "<tr class=''><td class='col-lg-1'>";
									str += "<input type='checkbox' name='atselect' value="+reg[i].msg_id+">";
									str += "</td><td class='col-lg-6'>";
									str += reg[i].content;
									str += "</td><td class='col-lg-2'>";
									str += reg[i].user_name;
									str += "</td><td class='col-lg-2'>";
									str += reg[i].time;
									str += "</td><td class='col-lg-1'>";
									str += "<a class='atdelete'>删除</a>"
									str += "</td></tr>";

								}
								$("#attentionTable").append(str);


							}
						},function(api){
							$("#attentionTable").text("");
							var str = "";
							for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='atselect' value="+reg[i].msg_id+">";
						str += "</td><td class='col-lg-6'>";
						str += reg[i].content;
						str += "</td><td class='col-lg-2'>";
						str += reg[i].user_name;
						str += "</td><td class='col-lg-2'>";
						str += reg[i].time;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='atdelete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#attentionTable").append(str);
				});
						
					}
					else{
						alert("没有相关通知");
					}
				}
			})
		}else{
			alert("未填写对象名");
		}
	});
	$("#op_search_all").on("click", function () {
		$.ajax({
			type: "get",
			url: 'getGroupAttention/',
			async: true,
			cache: false,
			success: function (reg) {
				if (reg) {
					$("#attentionTable").text("");
					$('#atPage').show();
					$('#atPage').pagination({
						coping:true,
						homePage:'首页',
    					endPage:'末页',
						totalData:reg.length,
						showData:5,
						coping:true,
						callback:function(api){
							$("#attentionTable").text("");
							var str = "";
							for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

								str += "<tr class=''><td class='col-lg-1'>";
								str += "<input type='checkbox' name='atselect' value="+reg[i].msg_id+">";
								str += "</td><td class='col-lg-6'>";
								str += reg[i].content;
								str += "</td><td class='col-lg-2'>";
								str += reg[i].topic;
								str += "</td><td class='col-lg-2'>";
								str += reg[i].time;
								str += "</td><td class='col-lg-1'>";
								str += "<a class='atdelete'>删除</a>"
								str += "</td></tr>";

							}
							$("#attentionTable").append(str);


						}
					},function(api){
						$("#attentionTable").text("");
						var str = "";
						for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='atselect' value="+reg[i].msg_id+">";
						str += "</td><td class='col-lg-6'>";
						str += reg[i].content;
						str += "</td><td class='col-lg-2'>";
						str += reg[i].topic;
						str += "</td><td class='col-lg-2'>";
						str += reg[i].time;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='atdelete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#attentionTable").append(str);
				});

				}
				else{
					alert("没有相关通知");
				}
			}
		})

	});
	$("#time_search").on("click", function () {
		if($("#attentionDate").val().trim()!=""){
			var date = $("#attentionDate").val();
			$.ajax({
				type: "get",
				url: 'getAttentionByDate/'+date,
				async: true,
				cache: false,
				success: function (reg) {
					if (reg) {
						$("#attentionTable").text("");
						$('#atPage').show();
						$('#atPage').pagination({
							totalData:reg.length,
							homePage:'首页',
    						endPage:'末页',
							showData:5,
							coping:true,
							callback:function(api){
								$("#attentionTable").text("");
								var str = "";
								for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

									str += "<tr class=''><td class='col-lg-1'>";
									str += "<input type='checkbox' name='atselect' value="+reg[i].msg_id+">";
									str += "</td><td class='col-lg-6'>";
									str += reg[i].content;
									str += "</td><td class='col-lg-2'>";
									str += reg[i].user_name;
									str += "</td><td class='col-lg-2'>";
									str += reg[i].time;
									str += "</td><td class='col-lg-1'>";
									str += "<a class='atdelete'>删除</a>"
									str += "</td></tr>";

								}
								$("#attentionTable").append(str);


							}
						},function(api){
							$("#attentionTable").text("");
							var str = "";
							for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='atselect' value="+reg[i].msg_id+">";
						str += "</td><td class='col-lg-6'>";
						str += reg[i].content;
						str += "</td><td class='col-lg-2'>";
						str += reg[i].user_name;
						str += "</td><td class='col-lg-2'>";
						str += reg[i].time;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='atdelete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#attentionTable").append(str);
				});
					}
					else{
						alert("没有相关通知");
					}
				}
			})
		}else{
			alert("未填写时间");
		}
	});
	$("#time_search_all").on("click", function () {
		if($("#attentionDate").val().trim()!=""){
			var date = $("#attentionDate").val();
			$.ajax({
				type: "get",
				url: 'getGroupAttentionByDate/'+date,
				async: true,
				cache: false,
				success: function (reg) {
					if (reg) {
						$("#attentionTable").text("");
						$('#atPage').show();
						$('#atPage').pagination({
							totalData:reg.length,
							homePage:'首页',
    						endPage:'末页',
							showData:5,
							coping:true,
							callback:function(api){
								$("#attentionTable").text("");
								var str = "";
								for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

									str += "<tr class=''><td class='col-lg-1'>";
									str += "<input type='checkbox' name='atselect' value="+reg[i].msg_id+">";
									str += "</td><td class='col-lg-6'>";
									str += reg[i].content;
									str += "</td><td class='col-lg-2'>";
									str += reg[i].topic;
									str += "</td><td class='col-lg-2'>";
									str += reg[i].time;
									str += "</td><td class='col-lg-1'>";
									str += "<a class='atdelete'>删除</a>"
									str += "</td></tr>";

								}
								$("#attentionTable").append(str);


							}
						},function(api){
							$("#attentionTable").text("");
							var str = "";
							for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='atselect' value="+reg[i].msg_id+">";
						str += "</td><td class='col-lg-6'>";
						str += reg[i].content;
						str += "</td><td class='col-lg-2'>";
						str += reg[i].topic;
						str += "</td><td class='col-lg-2'>";
						str += reg[i].time;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='atdelete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#attentionTable").append(str);
				});
					}
					else{
						alert("没有相关通知");
					}
				}
			})
		}else{
			alert("未填写时间");
		}
	});
	$("#Atselect_all").on("click", function () { 
		$("[name='atselect']").attr("checked",'true');//全选 
	}) 
	$("#Atdelete_all").on("click", function () { 
		var input = $("#attentionTable").find("input");
		var j = [];
		var k = 0;
		var r = confirm("确定要删除这些通知吗？")
		if (r == true) {
			for (var i = 0; i < input.length; i++) {
				var row = {};
				if (input.eq(i).is(':checked')) {
					row.atid = input.eq(i).val();
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
				url: "deleteSelectAttention",
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
	$("#send_btn").on("click", function () { 
		if($("#personcontent").val().trim()!=""){
			var content = $("#personcontent").val();
			var input = $("#userTable").find("input");
			var j = [];
			var k = 0;
			var r = confirm("确定给他们发送通知吗？")
			if (r == true) {
				for (var i = 0; i < input.length; i++) {
					var row = {};
					if (input.eq(i).is(':checked')) {
						row.userid = input.eq(i).val();
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
					url: "addPersonalMessage",
					data: { da: j, con : content},
            // headers: {
            //     Accept: "application/json",
            //     "Content-Type": "application/json"
            // },
            success: function (reg) {
            	if(reg){
            		alert("发送成功")
            	}else{
            		alert("发送失败")
            	}

            },
            error: function () {
            	alert("服务器发生错误，发送失败！");
            }
        })
			}
		}else{
			alert("消息未填写");
		}
	})


})
