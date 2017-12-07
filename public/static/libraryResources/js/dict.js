$(document).ready(function(){
	var str = "";
	$.ajax({
		type:"get",
		url:"../../library/font_controller/GetAuther",
		async:true,
		cache:false,
		success:function(reg){
			for(var i = 0; i < reg.length ;i++){
				str += "<option value='"+ reg[i].font_master +"'>";
				str += reg[i].font_master;
				str += "</option>";
			}
			$("#authers").append(str);
		},error:function(){
			
		}
	});
})

$(".search_btn").click(function(){
	var font = $("#_font").val();
	var _style = $("input[name='fontType']:checked").val();
	//alert(_style);
	var auther = $("#authers").val();
	if(_style == null || _style == "" || _style == "undefined"){
		_style = "楷书";
	}
	
	if(font == null || font == ""){
		alert("请输入所查询的字");
	}else{
		$.ajax({
			type: "get",
			url: "../../library/font_controller/GetInforFont?font=" + font + "&type=" + _style + "&master=" + auther,
			async: true,
			cache: false,
			success: function(reg) {
				$("#search_box").html("");
				var str = "";
				var page = 0;
				var count = reg.length;
				page = Math.floor(count/20);
				for(var j = 0; j < page ; j++){
					str += "<div id=\"part\" data-id = \"1\">";
					for(var i = 0; i < 20; i++) {
						str += "<div class=\"fontBlock\">";
						str += "<img src=\"../../static/libraryResources/img/" + reg[j*20 + i].font_url + "\" />";
						str += "<ul>";
						str += "<li>" + reg[j*20 + i].font_name + "</li>";
						str += "<li>" + reg[j*20 + i].font_range + "</li>";
						str += "<li>" + reg[j*20 + i].font_type + "</li>";
						str += "<li>" + reg[j*20 + i].font_master + "</li></ul></div>";
					}
					str += "</div>";
				}
				if(count % 20){
					str += "<div id=\"part\" data-id = \"1\">";
					for(var i = 0 ; i < count %20 ; i++){
						str += "<div class=\"fontBlock\">";
						str += "<img src=\"../../static/libraryResources/img/" + reg[page*20 +i].font_url + "\" />";
						str += "<ul>";
						str += "<li>" + reg[page*20 +i].font_name + "</li>";
						str += "<li>" + reg[page*20 +i].font_range + "</li>";
						str += "<li>" + reg[page*20 +i].font_type + "</li>";
						str += "<li>" + reg[page*20 +i].font_master + "</li></ul></div>";
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

$(document).delegate(".fontBlock","click",function(){
	$("#tb_box").children().remove();
	var dom = $(this);
	$("#tb_box").append(dom.clone());
	dom = $("#tb_box").children(0);
	dom.attr("class","dict_fontBlock");
	layer.open({
		 type:1,
		area: ['700px', '600px'],
		title: '书法字典',
		content: $("#tb_box"),
	});
})
