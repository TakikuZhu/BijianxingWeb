//单选框数据绑定
function myRadio(name,dom){
	var path = "";//申请的url
	$.ajax({
		type:"post",
		url:path,
		async:true,
		success:function(reg){
			var jsonStr = reg.replace(/},]/g,"}]");
			var jsonObj = eval('(' + jsonStr + ')');
			var str = "";
			for(var i = 0; i < jsonObj.length; i ++){
				str += "<label class='radio-inline'><input type='radio' name='";
				str += name;
		        str += "' value='";
		        str += jsonObj.value;
		        str += "'/>";
		        str += jsonObj.name;
		    	str += "</label>";
			}
	    	dom.append(str);
		}
	});
}
