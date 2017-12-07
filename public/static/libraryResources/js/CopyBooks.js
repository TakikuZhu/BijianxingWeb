/**
 * 字帖生成相关函数以及必要的设置
 * 
 * 作者：刘东乐
 * 
 * 2017/10/3
 * 
 * 
 * 
 */

(function($) {
	//定义全局变量
	var Grid = {};
	//默认样式
	Grid.defaults = {
		rows: 1, //行数
		cols: 3, //列数
		pad: 15, //边框留白
		bg: 'bg/bg_3.gif', //背景图
		rootpath: 'img/', //图片根目录
		style: 0 //0为横板，1为竖版
	}
	Grid.setting = {};
	Grid.obj = {};
	//简写
	var GD = Grid.defaults;
	var GS = Grid.setting;
	var GO = Grid.obj;
	//初始化页面
	$.fn.extend({
		//初始化格子，生成canvas画布
		initGrid: function(options) {
			GS = $.extend(GD, options);
			if(document.getElementById('myCanvas') == null) {
				//计算canvas画布的大小
				var width = Math.floor(this.width());
				var size = Math.floor((width - GS.pad * 2) / GS.cols);
				var height = size * GS.rows + GS.pad * 2;
				//存入全局变量
				GS.width = width;
				GS.size = size;
				GS.height = height;
				var str = "<canvas id='myCanvas' width='";
				str += GS.width;
				str += "' height='";
				str += GS.height;
				str += "'></canvas>";
				var myCanvas = $(str);
				this.append(myCanvas);
				var ctx = document.getElementById('myCanvas').getContext('2d');
				ctx.strokeStyle = "#ff3d3d";
				ctx.lineWidth = 8;
				ctx.strokeRect(0, 0, GS.width, GS.height);
			}
			return this;
		},
		//为所有格子添加背景
		addBg: function(options) {
			GS = $.extend(GS, options);
			var ctx = document.getElementById('myCanvas').getContext('2d');
			var img = new Image();
			img.src = GS.rootpath + GS.bg;
			img.onload = function() {
				for(var i = 0; i < 　GS.cols; i++) {
					for(var j = 0; j < GS.rows; j++) {
						ctx.drawImage(img, GS.pad + GS.size * i, GS.pad + GS.size * j, GS.size, GS.size);
					}
				}
			}
			return this;
		},
		
		//填充所有格子
		fillAllGrid: function(options) {
			GS = $.extend(GS, options);
			for(var i = 0; i < GS.cells.length; i++) {
				var url = GS.rootpath + GS.cells[i].word[0].path;
				var url2 = GS.rootpath + GS.bg;
				clearGrid(i);
				loadImg(url2, i, GS.style);
				loadImg(url, i, GS.style);
			}
			return this;
		},
		//填充单个格子
		fillGrid: function(options, index) {

			return this;
		},
		/**
		 * 更新单个格子
		 * @param {int} index  需要修改的字的序号
		 * @param {int} count  当前使用的字的标识
		 */
		updateGrid: function(options, index, count) {
			GS = $.extend(GS, options);
			index--;
			count--;
			var ctx = document.getElementById('myCanvas').getContext('2d');
			count %= GS.cells[index].word.length;
			var url = GS.rootpath + GS.cells[index].word[count].path;
			var url2 = GS.rootpath + GS.bg;
			clearGrid(index);
			loadImg(url2, index, GS.style);
			loadImg(url, index, GS.style);
			
			return this;
		},
		//获取设置
		getOptions: function() {
			var options = {
				cells: [{
						"word": [{
								"path": "阿.bmp"
							},
							{
								"path": "阿.bmp"
							},
							{
								"path": "test.jpg"
							}
						]
					},
					{
						"word": [{
							"path": "阿.bmp"
						}]
					},
					{
						"word": [{
							"path": "test.jpg"
						}]
					}
				]
			}

			return options;
		}
	});
	/**
	 * 载入图片并将其添加到画布的对应位置
	 * @param {Object} url      图片url
	 * @param {Object} i		图片在画布中的位置
	 * @param {Object} style	画布排版方式
	 */
	function loadImg(url, i, style) {
		var j;
		var ctx = document.getElementById('myCanvas').getContext('2d');
		ctx.globalCompositeOperation = "destination-over";
		var img = new Image();
		img.src = url;
		if(!img.complete) {
			img.onload = function() {
				if(style == 0) {
					j = Math.floor(i / GS.cols);
					i = Math.floor(i % GS.cols);
					ctx.drawImage(img, GS.pad + GS.size * i, GS.pad + GS.size * j, GS.size, GS.size);
				} else {
					j = Math.floor(i / GS.rows);
					i = Math.floor(i % GS.rows);
					ctx.drawImage(img, GS.width - GS.pad - GS.size * (j + 1), GS.pad + GS.size * i, GS.size, GS.size);
				}

			}
		} else {
			if(style == 0) {
				j = Math.floor(i / GS.cols);
				i = Math.floor(i % GS.cols);
				ctx.drawImage(img, GS.pad + GS.size * i, GS.pad + GS.size * j, GS.size, GS.size);
			} else {
				j = Math.floor(i / GS.rows);
				i = Math.floor(i % GS.rows);
				ctx.drawImage(img, GS.width - GS.pad - GS.size * (j + 1), GS.pad + GS.size * i, GS.size, GS.size);
			}
		}
	}
	/**
	 * 清理画布中指定的位置
	 * @param {Object} i 需要清理的位置
	 */
	function clearGrid(i) {
		var j;
		var ctx = document.getElementById('myCanvas').getContext('2d');
		if(GS.style == 0) {
			j = Math.floor(i / GS.cols);
			i = Math.floor(i % GS.cols);
			ctx.fillStyle = "#fff";
			ctx.fillRect(GS.pad + GS.size * i, GS.pad + GS.size * j, GS.size, GS.size);
			ctx.clearRect(GS.pad + GS.size * i, GS.pad + GS.size * j, GS.size, GS.size);
		} else {
			j = Math.floor(i / GS.rows);
			i = Math.floor(i % GS.rows);
			ctx.fillStyle = "#fff";
			ctx.fillRect(GS.width - GS.pad - GS.size * (j + 1), GS.pad + GS.size * i, GS.size, GS.size);
		}
	}
})(jQuery);