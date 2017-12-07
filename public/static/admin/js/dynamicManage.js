
$(function () {
	function getRadioValue(radioName) {
		var chkRadio = document.getElementsByName(radioName);
		for (var i = 0; i < chkRadio.length; i++) {
			if (chkRadio[i].checked)
				return chkRadio[i].value;
		}
	}
	$("#didreset").on("click", function () {
		$("#dynamicid").val("");
	})

	$("#dnameset").on("click", function () {
		$("#dynamicname").val("");
	})
	$("#select_all").on("click", function () { 
		$("[name='dyselect']").attr("checked",'true');//全选 
	}) 
	$("#delete_all").on("click", function () { 
		var input = $("#dynamicTable").find("input");
		var j = [];
		var k = 0;
		var r = confirm("确定要删除这些动态吗？")
		if (r == true) {
			for (var i = 0; i < input.length; i++) {
				var row = {};
				if (input.eq(i).is(':checked')) {
					row.dyid = input.eq(i).val();
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
        	url: "deleteSelectDynamic/",
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
	$("#didsearch").on("click", function () {
		if($("#dynamicid").val().trim()!=""){
			var words = $("#dynamicid").val();
			var chk2 = getRadioValue("dynamicidace");
			$.ajax({
				type: "get",
				url: 'getDynamicByWords/'+chk2,
				async: true,
				cache: false,
				data:{da:words},
				success: function (reg) {
					if (reg) {
						$("#dynamicTable").text("");
						$('#dyPage').show();
						$('#dyPage').pagination({
							totalData:reg.length,
							showData:5,
							coping:true,
							callback:function(api){
								$("#dynamicTable").text("");
								var str = "";
								for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {
						//reg = eval('(' + reg + ')');
						// $("#dynamicTable").text("");
						// var str = "";
						// for (var i = 0; i < reg.length; i++) {
							str += "<tr class=''><td class='col-lg-1'>";
							str += "<input type='checkbox' name='dyselect' value="+reg[i].dynamic_id+">";
							str += "</td><td class='col-lg-2'>";
							str += reg[i].user_name;
							str += "</td><td class='col-lg-6'><a class='linktody'>";
							str += reg[i].theme;
							str += "</a></td><td class='col-lg-2'>";
							str += reg[i].time;
							str += "</td><td class='col-lg-1'>";
							str += "<a class='dydelete'>删除</a>"
							str += "</td></tr>";
							//alert();
							
						}
						$("#dynamicTable").append(str);


					}
				},function(api){
					$("#dynamicTable").text("");
					var str = "";
					for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='dyselect' value="+reg[i].dynamic_id+">";
						str += "</td><td class='col-lg-2'>";
						str += reg[i].user_name;
						str += "</td><td class='col-lg-6'><a class='linktody'>";
						str += reg[i].theme;
						str += "</a></td><td class='col-lg-2'>";
						str += reg[i].time;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='dydelete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#dynamicTable").append(str);
				});

					}
					else{
						alert("没有动态拥有此关键字");
					}
				}
			})
			

		}

		else{
			alert("未填写关键词");
		}
	})
	$("#dnamesearch").on("click", function () {
		if($("#dynamicname").val().trim()!=""){
			var chk2 = getRadioValue("dynamicnameace");
			var name = $("#dynamicname").val();
			$.ajax({
				type: "get",
				url: 'getDynamicByName/'+chk2,
				async: true,
				cache: false,
				data:{da:name},
				success: function (reg) {
					if (reg) {
						$("#dynamicTable").text("");
						$('#dyPage').show();
						$('#dyPage').pagination({
							totalData:reg.length,
							showData:5,
							coping:true,
							callback:function(api){
								$("#dynamicTable").text("");
								var str = "";
								for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

									str += "<tr class=''><td class='col-lg-1'>";
									str += "<input type='checkbox' name='dyselect' value="+reg[i].dynamic_id+">";
									str += "</td><td class='col-lg-2'>";
									str += reg[i].user_name;
									str += "</td><td class='col-lg-6'><a class='linktody'>";
									str += reg[i].theme;
									str += "</a></td><td class='col-lg-2'>";
									str += reg[i].time;
									str += "</td><td class='col-lg-1'>";
									str += "<a class='dydelete'>删除</a>"
									str += "</td></tr>";

								}
								$("#dynamicTable").append(str);


							}
						},function(api){
							$("#dynamicTable").text("");
							var str = "";
							for (var i = 0; i <5&&i < reg.length; i++) {
						//$(".myTr").remove();
						str += "<tr class=''><td class='col-lg-1'>";
						str += "<input type='checkbox' name='dyselect' value="+reg[i].dynamic_id+">";
						str += "</td><td class='col-lg-2'>";
						str += reg[i].user_name;
						str += "</td><td class='col-lg-6'><a class='linktody'>";
						str += reg[i].theme;
						str += "</a></td><td class='col-lg-2'>";
						str += reg[i].time;
						str += "</td><td class='col-lg-1'>";
						str += "<a class='dydelete'>删除</a>"
						str += "</td></tr>";
						
					}
					$("#dynamicTable").append(str);
				});

					}
					else{
						alert("该用户没有动态");
					}
				}
			})
			

		}

		else{
			alert("未填写用户名");
		}
	})


})