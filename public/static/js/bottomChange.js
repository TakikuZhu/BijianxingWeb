	document.getElementById("square").addEventListener('tap', function() {
		window.location.href = "../index/index";
	})
	document.getElementById("forum").addEventListener('tap', function() {
		var a = false;
				$.ajax({
					type: "get",
					url: "../../phone/user/checkLogin",
					cache: false,
					async: false,
					success: function(data) {
						if(data == 1) {
							a = true;
						} else if(data == 0) {
							a = false;
						}
					},
					error: function() {
						mui.toast('服务器出错了!!!')
					}
				});
				if(!a) {
					mui.confirm('是否前往登录？', '您还没登录', ['取消', '登录'], function(e) {
						if(e.index == 1) {
							window.location.href = "../../phone/user/loginPage"
						} else {
							window.location.href = "#"
						}
					}, 'div')
				} else {
					window.location.href = "../forum/forum";
				}
	})
	document.getElementById("plus").addEventListener('tap', function() {
		window.location.href = "../forum/edit";
	})
	document.getElementById("study").addEventListener('tap', function() {
		window.location.href = "../../phone/word/dictPage";
	})
	document.getElementById("my").addEventListener('tap', function() {
		var a = false;
				$.ajax({
					type: "get",
					url: "../../phone/user/checkLogin",
					cache: false,
					async: false,
					success: function(data) {
						if(data == 1) {
							a = true;
						} else if(data == 0) {
							a = false;
						}
					},
					error: function() {
						mui.toast('服务器出错了!!!')
					}
				});
				if(!a) {
					mui.confirm('是否前往登录？', '您还没登录', ['取消', '登录'], function(e) {
						if(e.index == 1) {
							window.location.href = "../../phone/user/loginPage"
						} else {
							window.location.href = "#"
						}
					}, 'div')
				} else {
					window.location.href="../my/my";
				}
		
	})