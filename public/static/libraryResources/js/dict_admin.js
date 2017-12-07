$(".search_btn2").click(function(){
	var font = $("#admin_font").val();
	if(font == null || font == ""){
		alert("请输入所查询的字");
	}else{
		$.ajax({
			type: "get",
			url: "../../library/admin/GetInforFont?font=" + font ,
			async: true,
			cache: false,
			success: function(reg) {
				$("#search_box").html("");
				var str = "";
				var page = 0;
				var count = reg.length;
				page = Math.floor(count/12);
				for(var j = 0; j < page ; j++){
					str += "<div id=\"part\" data-id = \"1\">";
					for(var i = 0; i < 12; i++) {
						str += "<div class=\"fontBlock\" style=\"cursor: auto;position: relative;\" data-id=\""+ reg[j*12 + i].font_id +"\" >";
						str += "<img src=\"../../static/libraryResources/img/" + reg[j*12 + i].font_url + "\" />";
						str += "<ul style='display:none'>";
						str += "<li>" + reg[j*12 + i].font_name + "</li>";
						str += "<li>" + reg[j*12 + i].font_range + "</li>";
						str += "<li>" + reg[j*12 + i].font_type + "</li>";
						var newDate = /\d{4}-\d{1,2}-\d{1,2}/g.exec(reg[j*12 + i].save_date);
						str += "<li>" + reg[j*12 + i].font_master + "</li>";
						str += "<li>" + newDate + "</li>";
						str += "</ul><ul><li>详情</li></ul><div class=\"admin_del\"></div></div>";
					}
					str += "</div>";
				}
				if(count % 12){
					str += "<div id=\"part\" data-id = \"1\">";
					for(var i = 0 ; i < count %12 ; i++){
						str += "<div class=\"fontBlock\" style=\"cursor: auto;position: relative;\" data-id=\""+ reg[page*12 +i].font_id +"\" >";
						str += "<img src=\"../../static/libraryResources/img/" + reg[page*12 +i].font_url + "\" />";
						str += "<ul style='display:none'>";
						str += "<li>" + reg[j*12 + i].font_name + "</li>";
						str += "<li>" + reg[page*20 +i].font_range + "</li>";
						str += "<li>" + reg[page*20 +i].font_type + "</li>";
						str += "<li>" + reg[page*20 +i].font_master + "</li>";
						var newDate = /\d{4}-\d{1,2}-\d{1,2}/g.exec(reg[j*12 + i].save_date);
						str += "<li>" + newDate + "</li>";
						str += "</ul><div class='admin_infor'>详情</div><div class=\"admin_del\"></div></div>";
					}
					str += "</div>";
					page += 1;
				}
				//alert(str);
				$("#search_box").append(str);
				$("#search_box #part").css("display","none");
				$("#search_box #part").eq(0).css("display","block");
				if(page > 1){
					$(".pageJump").css("display","inline-block");
				}
				Page({
				num: page, //页码数
				startnum: 1, //指定页码 
				elem: $('#page2'), //指定的元素 
				callback: function(n) {
					//回调函数 
					console.log(n);
					$("#search_box #part").css("display","none");
					$("#search_box #part").eq(n-1).css("display","block");
				}
			});
			}
		});
	}

})

$(document).delegate(".admin_infor","click",function(){
	$("#tb_box").children().remove();
	var dom = $(this).parent();
	$("#tb_box").append(dom.clone());
	dom = $("#tb_box").children(0);
	dom.attr("class","dict_fontBlock");
	dom.children().eq(1).css("display","block");
	dom.children().eq(2).css("display","none");
	dom.children().eq(3).css("display","none");
	var str = "<input type='button' id='up' class=\"_upbtn _upbtn2\" value='编辑' />";
	dom.append(str);
	layer.open({
		 type:1,
		area: ['700px', '600px'],
		title: '字体详情',
		content: $("#tb_box"),
	});
})

$(document).delegate(".admin_del","click",function(){
	var id = $(this).parent().attr("data-id");
	var dom = $(this);
	$.ajax({
		type:"get",
		url:"../../library/font_controller/DeleteFont?oid=" + id,
		async:true,
		cache:false,
		success:function(reg){
			alert("删除成功");
			dom.parent().remove();
		},
		error:function(reg){
			
		}
	});
})

$(document).delegate('._upbtn2','click',function(){
	var dom = $(this).parent();
	var str = $("#up").val() == "编辑" ? "确定" : "编辑";
	//alert("1");
	$("#up").val(str); // 按钮被点击后，在“编辑”和“确定”之间切换
	$("#up").attr("onclick", "update()");
	if($("#up").val() == "确定"){
		for(var i = 0; i < 4; i++) {
			str = dom.children().eq(1).children().eq(i).html();
			dom.children().eq(1).children().eq(i).html("<input type='text' class='_updates' value='" + str + "'>");
		}
	}
})


function update(){
	var dom = $("#tb_box").children().eq(0);
	var id = dom.attr('data-id');
	var _name = dom.children().eq(1).children().eq(0).children().eq(0).val();
	var _type = dom.children().eq(1).children().eq(1).children().eq(0).val();
	var _range = dom.children().eq(1).children().eq(2).children().eq(0).val();
	var _master = dom.children().eq(1).children().eq(3).children().eq(0).val();
	$.ajax({
		type:"get",
		url:"../../library/font_controller/upFont?id=" + id + "&font=" + _name + "&type=" + _type + "&master=" + _master + "&range=" + _range,
		async:true,
		cache:false,
		success:function(reg){
			alert("修改成功");
			window.location.href='../../library/admin';
		},
		error:function(){
			
		}
	});
}

$(document).delegate(".fontBlock","mouseover",function(){
	$(this).children().eq(3).css("display","block");
})

$(document).delegate(".fontBlock","mouseleave",function(){
	$(this).children().eq(3).css("display","none");
})




//function demo() {
//	$.ajax({
//		type:"get",
//		url:"",  //访问的方法的url
//		async:true, //同步true异步false 
//		cache:false,//缓存false关 true 开
//		success:function(reg){
//			/**
//			 * reg 是访问成功后的返回值
//			 * 在此处对返回值进行操作
//			 */
//			
//		},error:function(){
//			/**
//			 * 这里是访问失败时的操作
//			 */
//		}
//	});
//}