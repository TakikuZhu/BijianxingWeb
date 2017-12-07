function page_clip(){
	$.ajax({
		type:"get",
		url:"",
		async:true,
		success: function(reg){
			var jsonObj = eval('(' + reg + ')');
			if(jsonObj.count > 10){
				
			}
		}
	});
}
