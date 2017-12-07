/**
 * 字帖生成相关函数以及必要的设置
 * 
 * 作者：刘东乐
 * 
 * 2017/10/3
 * 
 * version: 2.0
 * 
 */

(function($) {
	//定义Grids类
	var Grids = function() {}

	var demo = '<div class="grid">';
	demo += '<img class="bg" />';
	demo += '<div class="cnt">';
	demo += '<div class="word" ></div>';
	demo += '<div class="control">';
	demo += '<span class="change_btn">换<label class="count_num">';
	demo += '</label>:<label class="num"></label></span>';
	demo += '<input class="rollLine" type="range" min="0" max="100" value="50"/>';
	demo += '</div>';
	demo += '</div>';
	demo += '</div>';
	var Option = function() {
		this.rows = $("#_row").val();
		this.cols = $("#_col").val();
		this.bg = 'bg/bg_' + $("#_cell").val() + '.gif';
		this.type = $("input[name='typesetting']:checked").val();
		this.mes = $("#_mes").val();
		this.fontStyle = $("#_fontStyle").val();
		this.fontFarm = $("#_fontFam").val();
		this.figure = $("#_figure").val();
		this.model = $("#_model").val();
	}
	//默认样式
	Grids.defaults = {
		rows: 6, //行
		cols: 4, //列
		rootPath: "../../static/libraryResources/img/",
		bg: 'bg/bg_1.gif', //背景图片
		pad: 15, //边距
		type: "0", //版式，0为横板，1为竖版
		color: '#ff3d3d', //边框颜色
		demol: demo,
		master: "默认"
	}

	//用户设置
	Grids.setting = {};
	//获取的字体对象
	Grids.obj = {};

	//定义简写
	var GS = Grids.setting;
	var GO = Grids.obj;
	var GD = Grids.defaults;

	//扩展插件
	$.fn.extend({
		/**
		 * 初始化表格
		 */
		initGrids: function() {
			GS = $.extend(GD, GS);
			GS.width = this.width() - GS.pad * 2;
			GS.size = Math.floor(GS.width / GS.cols);
			GS.height = GS.size * GS.rows;
			if(document.getElementById("copyBook") == null) {
				var str = $('<div id="copyBook"></div>');
				str.css({
					"width": GS.width + "px",
					"height": GS.height + "px",
					"padding": GS.pad + "px",
					"border": "2px solid " + GS.color
				})
				this.append(str);
			}

			for(var i = 0; i < GS.rows * GS.cols; i++) {
				var grid = $(GS.demol);
				grid.css({
					"width": GS.size,
					"height": GS.size
				})
				grid.children('.bg').attr('src', GS.rootPath + GS.bg);
				$("#copyBook").append(grid);
			}
			var bg = $("<div></div>");
			bg.css({
				"background":"#fff",
				"position":"absolute",
				"top":"30px",
				"width":this.parent().width() - 3,
				"height":this.parent().height() - 3,
				"z-index":"-2",
				"border":"1px solid #ccc"
			})
			this.parent().append(bg);
			return this;
		},
		fillAllGrids: function() {
			
			GS = $.extend(GS, GO);
//			console.log(GO.length);
			for(var i = 0; i < GO.length; i++) {
				if(GO[i].word != undefined){
					var url = GS.rootPath + GO[i].word[0].path;
					var num = GO[i].word.length;
					fillGrid(i, url, num);
				}
				
			}
			return this;
		},
		getOption: function() {
			var op = new Option();
			$.extend(GS,op);
			if(GS.mes.length > 0){
				$.ajax({
					type:"get",
					url:"../../library/font_controller/GetFont?font="+GS.mes+"&master="+GS.master+"&type="+GS.fontStyle+"&range="+GS.fontFarm+"&grap="+GS.figure,
					async:false,
					success:function(reg){
						
						GO=eval('(' + reg +')');
					}
				});
			}
			
//			GO = [{
//					"word": [{
//							"path": "阿.bmp"
//						},
//						{
//							"path": "阿.bmp"
//						},
//						{
//							"path": "test.jpg"
//						}
//					]
//				},
//				{
//					"word": [{
//							"path": "阿.bmp"
//						},
//						{
//							"path": "test.jpg"
//						}
//					]
//				},
//				{
//					"word": [{
//						"path": "test.jpg"
//					}]
//				}
//			]
			return this;
		}
	})
	/**
	 * 填充格子
	 * @param {Object} index	//字符顺序编号
	 * @param {Object} url		//图片url
	 * @param {Object} num		//图片总数
	 */
	function fillGrid(index, url, num) {
		var i;
		switch(GS.type) {
			case "0":
				i = index;
				$("#copyBook .grid").eq(i)
					.children(".cnt")
					.children(".word")
					.css({
						"background": "url(" + url + ")",
						"background-size": "100%",
						"background-position": "center",
						"background-repeat": "no-repeat"
					});
				var dom = $("#copyBook .grid").eq(i)
					.children(".cnt")
					.children(".control")
					.children(".change_btn");
				dom.children(".count_num").html(1);
				dom.children(".num").html(num);
				dom.attr('data-index',index);
				break;
			case "1":
				i = (index % GS.rows + 1) * GS.cols - Math.floor(index / GS.rows) - 1;
				$("#copyBook .grid").eq(i)
					.children(".cnt")
					.children(".word")
					.css({
						"background": "url(" + url + ")",
						"background-size": "100%",
						"background-position": "center",
						"background-repeat": "no-repeat"
					});
				var dom = $("#copyBook .grid").eq(i)
					.children(".cnt")
					.children(".control")
					.children(".change_btn");
				dom.children(".count_num").html(1);
				dom.children(".num").html(num);
				dom.attr('data-index',index);
				break;
		}
	}
	/**
	 * 更新格子
	 * @param {Object} index	//格子序号
	 * @param {Object} url		//图片url
	 * @param {Object} count	//图片序号
	 */
	function updateGrid(index, url, count) {
		var i;
		switch(GS.type) {
			case "0":
				i = index;
				$("#copyBook .grid").eq(i)
					.children(".cnt")
					.children(".word")
					.css({
						"background": "url(" + url + ")",
						"background-size": "100%",
						"background-position": "center",
						"background-repeat": "no-repeat"
					});
				var dom = $("#copyBook .grid").eq(i)
					.children(".cnt")
					.children(".control")
					.children(".change_btn");
				dom.children(".count_num").html(count + 1);
				break;
			case "1":
				i = (index % GS.rows + 1) * GS.cols - Math.floor(index / GS.rows) - 1;
				$("#copyBook .grid").eq(i)
					.children(".cnt")
					.children(".word")
					.css({
						"background": "url(" + url + ")",
						"background-size": "100%",
						"background-position": "center",
						"background-repeat": "no-repeat"
					});
				var dom = $("#copyBook .grid").eq(i)
					.children(".cnt")
					.children(".control")
					.children(".change_btn");
				dom.children(".count_num").html(count + 1);
				break;
		}
	}
	$(document).ready(function() {
//		$("body").delegate(".rollLine", 'change', function() {
//			var val = $(this).val();
//			val = (parseInt(val) + 50).toString() + "%";
//			$(this).parent().prev().css("background-size", val);
//		})
		$("body").delegate(".rollLine", 'mouseenter', function() {
			var dom = $(this);
			var id = setInterval(function(){
				var val = dom.val();
				val = (parseInt(val) + 50).toString() + "%";
				dom.parent().prev().css("background-size", val);
			},0.01)
			dom.attr('data-id', id);
		})
		$("body").delegate(".rollLine", 'mouseleave', function() {
			var dom = $(this);
			var id = dom.attr('data-id');
			var res = window.clearInterval(id);
		})
		$("body").delegate(".change_btn", 'click', function() {
			var num = $(this).children(".num").html();
			var count = $(this).children(".count_num").html();
			var index = $(this).attr("data-index");
			count = parseInt(count) % num;
			var url = GS.rootPath + GO[index].word[count].path;
			updateGrid(index, url, count);
		})
	})
})(jQuery)