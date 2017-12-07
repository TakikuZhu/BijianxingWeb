$(function(){
	getSession();
})


function getSession(){
	$.ajax({
		type:"get",
		url:"../../library/user_save/GetSession",
		async:true,
		cache:false,
		success:function(reg){
			//alert(reg);
			if(reg == 'False'){
				
			}else{
				getSave();
				$("._save").css("display","inline-block");
			}
		},error:function(){
			
		}
	});
}


/**
 * 获取当前用户的存档
 *
 */
function getSave(){
	var usr = "1";
	var state = "1";
	$.ajax({
		type:"get",
		url:"../../library/user_save/GetSave?state=" + state + "&uid=" + usr,
		async:true,
		cache:false,
		success:function(reg){
			//alert(reg);
			var str = "";
			var page = 0;
			var count = reg.length;
			page = Math.floor(count/5);
			var j = 0;
			for(var i = 0 ; i < page ; i++){
				str += "<ul data-id='"+ (i+1) +"'>";
				str += "<li class=\"title\">";
				str += "<label class=\"title\">序号</label>";
				str += "<label class=\"title\">字帖名称</label>";
				str += "<label class=\"title\">创建时间</label>";
				str += "<label class=\"title\" style='margin-left:30px'>操作</label>";
				str += "</li>";
				for(var j = 0 ; j < 5 ; j++){
					str += "<li class='_copybook'><label style='width:35px'>";
					str += j + 1;
					str += "</label>";
					str += "<label>";
					str += reg[j + i*5].save_name;
					str += "</label>";
					str += "<label>";
					var newDate = /\d{4}-\d{1,2}-\d{1,2}/g.exec(reg[j + i*5].save_date);
					str += newDate;
					str += "</label>";
					str += "<div class=\"_pre\" data-id='" + reg[j + i * 5].save_id + "'>";
					str += "</div><div class=\"_del\" data-id='" + reg[j + i*5].save_id + "'>";
					str += "</div><div class=\"_down\" data-id='" + reg[j + i*5].save_id + "'></div></li>";
				}
				str += "</ul>";
			}
			
			if(count % 5){
				str += "<ul data-id='"+ (page + 1) +"'>";
				str += "<li class=\"title\">";
				str += "<label class=\"title\">序号</label>";
				str += "<label class=\"title\">字帖名称</label>";
				str += "<label class=\"title\">创建时间</label>";
				str += "<label class=\"title\" style='margin-left:30px'>操作</label>";
				str += "</li>";
				for(var j = 0; j < count % 5; j++) {
					str += "<li class='_copybook'><label style='width:35px'>";
					str += j + 1;
					str += "</label>";
					str += "<label>";
					str += reg[j + page * 5].save_name;
					str += "</label>";
					str += "<label>";
					var newDate = /\d{4}-\d{1,2}-\d{1,2}/g.exec(reg[j + page * 5].save_date);
					str += newDate;
					str += "</label>";
					str += "<div class=\"_pre\" data-id='" + reg[j + page * 5].save_id + "'>";
					str += "</div><div class=\"_del\" data-id='" + reg[j + page * 5].save_id + "'>";
					str += "</div><div class=\"_down\" data-id='" + reg[j + i*5].save_id + "'></div></li>";
				}
				str += "</ul>";
			}
			if(count % 5){
				page = Math.floor(count/5) + 1;
			}else{
				page = Math.floor(count/5) ;
			}
			//alert(str);
			$("#usr_box1").append(str);
			$("#usr_box1 ul").css("display","none");
			$("#usr_box1 ul").eq(0).css("display","block");
			Page({
				num: page, //页码数
				startnum: 1, //指定页码 
				elem: $('#page2'), //指定的元素 
				callback: function(n) {
					//回调函数 
					console.log(n);
					$("#usr_box1 ul").css("display","none");
					$("#usr_box1 ul").eq(n-1).css("display","block");
				}
			});
		}
	});
}




/**
 * 绑定删除功能
 * 
 */
$(".usr_box").delegate("._del","click",function(){
	
	var oid = $(this).attr("data-id");
	console.log(oid);
	var dom = $(this).parent().parent();;
	$.ajax({
		type:"get",
		url:"../../library/user_save/DeleteSave?oid=" + oid,
		async:false,
		success:function(reg){
			alert("删除成功");
			//dom.remove();
			dom.children("._copybook").remove();
			$("#page2").children().remove();
			$("#usr_box1").children().remove();
			getSave();
		},error:{
			
		}
	});	
})



/**
 * 非存档的下载
 */
$(".show_box").delegate("._down2","click",function(){
	//$("#copyBooks").css("background","#FFFFFF");
	var dom = $("#copyBooks");
	 html2canvas(dom, {
        onrendered: function(canvas) {

			var contentWidth = canvas.width;
      		var contentHeight = canvas.height;
      		var pageHeight = contentWidth / 592.28 * 841.89;
      		var leftHeight = contentHeight;
      		var position = 0;
      		var imgWidth = 595.28;
      		var imgHeight = 592.28/contentWidth * contentHeight;
            //通过html2canvas将html渲染成canvas，然后获取图片数据
            var imgData = canvas.toDataURL('image/png',1.0);

            //初始化pdf，设置相应格式
            var doc = new jsPDF("p","pt","a4");

//          //这里设置的是a4纸张尺寸
//          doc.addImage(imgData, 'png', 0, 0,210,297);
            
            //addImage后两个参数控制添加图片的尺寸，此处将页面高度按照a4纸宽高比列进行压缩
            if (leftHeight < pageHeight) {
            	doc.addImage(imgData, 'png', 0, 0, imgWidth, imgHeight);
            }
            else {
            	while(leftHeight > 0) {
            		doc.addImage(imgData, 'png', 0, position, imgWidth, imgHeight)
            		leftHeight -= pageHeight;
            		position -= 841.89;
            		//避免添加空白页
            		if(leftHeight > 0) {
            			doc.addPage();
            		}
            	}
            }

            //输出保存命名为content的pdf
            doc.save('content.pdf');
        }
    });
})




/**
 * 保存按钮
 */
$(".show_box").delegate("._save","click",function(){
	//$("#copyBooks").css("background","#FFFFFF");
	var dom = $("#copyBooks");
	var i_name = $("#_name").val();
	 html2canvas(dom, {
        onrendered: function(canvas) {
            //通过html2canvas将html渲染成canvas，然后获取图片数据
            var imgData= canvas.toDataURL('image/png',1.0);
            $.ajax({
            	type: "post",
            	url: "../../library/user_save/AddSave",
            	data: {
            		name: i_name,
            		state: "1",
            		img: imgData
            	},
            	dataType: "json",
            	cache: false,
            	success: function(reg) {
            		alert("保存成功");
            		$("#page2").children().remove();
            		$("#usr_box1").children().remove();
            		getSave();
//          		console.log(reg);
            	},
            	error: function() {
            
            	}
            });
        }
        
   }); 
   getSave();
})



/**
 * 预览功能
 */
$("#usr_box1").delegate("._pre","click",function(){
	var oid = $(this).attr("data-id");
	$.ajax({
		type:"get",
		url:"../../library/user_save/GetSaveById?oid=" + oid,
		async:true,
		cache:false,
		success:function(reg){
//			alert(reg);
			var img = new Image();
			img.src = reg[0].save_url;
//			document.querySelector("._nameToready").value = $("#_name").val();
			$("#tb_show_img").children().remove();
			$("#tb_show_img").append(img);
			
			layer.open({
				type: 1,
				area: ['600px', '750px'],
				title: '书法字典',
				content: $("#tb_show"),
			});
		}
	});
})




/**
 * 存档的下载（先预览 后下载）
 */
$("#usr_box1").delegate("._down","click",function(){
	var oid = $(this).attr("data-id");
	$.ajax({
		type:"get",
		url:"../../library/user_save/GetSaveById?oid=" + oid,
		async:true,
		cache:false,
		success:function(reg){
//			alert(reg);
			var img = new Image();
			img.src = reg[0].save_url;
//			document.querySelector("._nameToready").value = $("#_name").val();
			$("#tb_show_img").children().remove();
			$("#tb_show_img").append(img);
			$("._down3").css("display","block");
			layer.open({
				type: 1,
				area: ['600px', '750px'],
				title: '书法字典',
				content: $("#tb_show"),
			});
		}
	});
})


/**
 * 保存到pdf
 */
$("#tb_show").delegate("._down3","click",function(){
	
	var imgData = Img.src;
	
	//初始化pdf，设置相应格式
	var doc = new jsPDF("p", "mm", "a4");
	
	//这里设置的是a4纸张尺寸
	doc.addImage(imgData, 'png', 0, 0, 210, 297);
	
	//输出保存命名为content的pdf
	doc.save('content.pdf');
})
