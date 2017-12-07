


(function($) {
	//全局变量
	var Draw = {
		setting: {},
		defaults: {},
		objects: {},
		models: {}
	}
	//设置简写
	/**
	 * DS中变量说明：
	 * size: 正文字体大小
	 * innerHei: 画布除边框外的可用高度
	 * innerWid：画布除边框外的可用宽度
	 * width: 画布宽带
	 * height：画布高度
	 * model: 当前选用模板，来自DM
	 * wMark: 落款宽度
	 * markSize: 落款中字体大小
	 * mar: 外边框宽度
	 * pad: 内边框宽度
	 * mes: 正文内容
	 * mark：落款内容
	 * cols: 列数
	 * rows：行数
	 * fgBg: 复古背景，布尔值
	 */
	var DS = Draw.settings;
	var DD = Draw.defaults;
	var DO = Draw.objects;
	var DM = Draw.models;
	//预设模板
	//匾额
	DM.be1 = {
		wScale: 136,
		hScale: 40,
		markScale: 16,
		fgBg: "匾额136X40-空白复古-2.jpg",
		bg: "匾额136X40-空白-2.jpg"
	}
	DM.be2 = {
		wScale: 136,
		hScale: 60,
		markScale: 16,
		fgBg: "匾额136X40-空白复古-2.jpg",
		bg: ""
	}
	//斗方
	DM.df1 = {
		wScale: 33,
		hScale: 33,
		markScale: 0,
		fgBg: "斗方66X66-空白复古-2.jpg",
		bg: ""
	}
	DM.df2 = {
		wScale: 66,
		hScale: 66,
		markScale: 11,
		fgBg: "斗方66X66-空白复古-2.jpg",
		bg: ""
	}
	//扇面
	DM.sm = {
		wScale: 54,
		hScale: 34,
		markScale: 11,
		fgBg: "扇面54X34-复古-2.jpg",
		bg: "扇面54X34-空白-2.jpg"
	}
	//手卷
	DM.sj = {
		wScale: 100,
		hScale: 30,
		markScale: 5,
		fgBg: "手卷100X30-空白复古-2.jpg",
		bg: "手卷100X30-空白-2.jpg"
	}
	//团扇
	DM.ts = {
		wScale: 33,
		hScale: 33,
		markScale: 0,
		fgBg: "团扇33X33-空白复古-2.jpg",
		bg: "团扇33X33-空白-2.jpg"
	}
	//条幅
	DM.tf = {
		wScale: 40,
		hScale: 136,
		markScale: 0,
		fgBg: "条幅40X136-空白复古-2.jpg",
		bg: "条幅40X136-空白-2.jpg"
	}
	//横幅
	DM.hf = {
		wScale: 100,
		hScale: 30,
		markScale: 5,
		fgBg: "横幅100X30-空白复古-2.jpg",
		bg: ""
	}
	//条屏
	DM.tp = {
		wScale: 156,
		hScale: 136,
		markScale: 0,
		fgBg: "条屏156X136空白复古-2.jpg",
		bg: "楹联90X136-空白-2.jpg"
	}
	//楹联
	DM.yl = {
		wScale: 90,
		hScale: 136,
		markScale: 0,
		fgBg: "楹联90X136-空白复古-2.jpg",
		bg: "楹联90X136-空白-2.jpg"
	}
	//中堂1
	DM.zt1 = {
		wScale: 46,
		hScale: 69,
		markScale: 9,
		fgBg: "中堂46X69-空白复古-2.jpg",
		bg: "中堂46X69-空白-2.jpg"
	}
	//中堂2
	DM.zt2 = {
		wScale: 68,
		hScale: 136,
		markScale: 13,
		fgBg: "中堂68X136-空白复古-2.jpg",
		bg: "中堂68X136-空白-2.jpg"
	}

	$.fn.extend({

		getOptions: function(str) {
			switch(str) {
				case 'tf':
					
					var options = {
						model: DM.tf,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
					break;
				case 'tp':
					var options = {
						model: DM.tp,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
					break;
				case 'zt1':
					var options = {
						model: DM.zt1,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
					break;
				case 'yl':
					var options = {
						model: DM.yl,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
					break;
				case 'df1':
					var options = {
						model: DM.df1,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
				break;
				case 'sj':
					var options = {
						model: DM.sj,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
				break;
				case 'hf':
					var options = {
						model: DM.hf,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
				break;
				case 'ts':
					var options = {
						model: DM.ts,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
				break;
				case 'sm':
					var options = {
						model: DM.sm,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
				break;
				case 'be1':
					var options = {
						model: DM.be1,
						mes: $("#_mes").val(),
						mark: $("#_sign").val(),
						fgBg: true,
						rootPath: '../../static/libraryResources/img/'
					};
				break;
				default:
					break;
			}
//			var options = {
//				model: DM.ts,
//				mes: "戊戌戊戌戊戌戊戌戊戊戊戌戊戌戊戌",
//				mark: "戊戌年九月",
//				fgBg: true,
//				rootPath: '../../static/libraryResources/img/'
//			};
			console.log(options);
			var mes = $("#_mes").val();
			var marks = $("#_sign").val();
			console.log('marks :' , marks);
			var auther1 =$("#_auther1").val();
			var auther2 = $("#_auther2").val();
			var auther3 =$("#_auther3").val();
			var type = $("#_fontFam").val();
			DO.mes = "";
			DS = $.extend(DS, options);
			$.ajax({
				type:"get",
				url:"../../library/font_controller/GetFont2?font=" + mes + "&auther1=" + auther1 + "&auther2=" + auther2 + "&auther3=" + auther3 + "&range=" + type,
				async:false,
				cache:false,
				success:function(reg){
					
					DO.mes = eval('(' + reg +')');
					
				},error:function(){
					
				}
			});
			
			$.ajax({
				type:"get",
				url:"../../library/font_controller/GetFont2?font=" + marks + "&auther1=" + auther1 + "&auther2=" + auther2 + "&auther3=" + auther3 + "&range=" + type,
				async:false,
				cache:false,
				success:function(reg){
					
					DO.mark = eval('(' + reg +')');
					
				},error:function(){
					
				}
			});
			//测试数据
//			DO.mes = [{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//			]
//			DO.mark = [{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//				{
//					path: "word/袁-实.png"
//				},
//			]
			return this;
		},
		//初始化画布
		initDraw: function() {
			initModels(this);
			return this;
		},
		//填充画布
		fillDraw: function() {
			switch(DS.model) {
				case DM.be1:
				case DM.be2:
					fillDrawARow();
					break;
				case DM.df1:
				case DM.df2:
					fillDrawDf();
						break;
				case DM.zt1:
				case DM.zt2:
					fillDrawZt();
					break;
				case DM.sj:
					fillDrawSj();
					break;
				case DM.tf:
					fillDrawTf();
					break;
				case DM.hf:
					fillDrawHf();
					break;
				case DM.sm:
					fillDrawSm();
					break;
				case DM.ts:
					fillDrawTs();
					break;
				case DM.yl:
					fillDrawYl();
					break;
				case DM.tp:
					fillDrawTp();
					break;
			}
		}
	})
	/**
	 * 初始化画布并标出基本背景
	 * @param {Object} dom 画布所在的HTML元素
	 */
	function initModels(dom) {
		//若画布不存在，创建画布
		if(document.getElementById('fontSelect') == null) {
			var mcv = document.createElement('canvas');
			mcv.id = "fontSelect";
			console.log(dom.width());
			DS.width = mcv.width = dom.width();
			DS.mar = Math.floor(DS.width / 10);
			DS.innerWid = DS.width - 2 * DS.mar;
			DS.innerHei = Math.floor(DS.innerWid * DS.model.hScale / DS.model.wScale);
			DS.height = mcv.height = DS.innerHei + 2 * DS.mar;
			DS.wMark = Math.floor(DS.innerWid * DS.model.markScale / DS.model.wScale);
			DS.lk = Math.floor(DS.innerWid * DS.model.markScale / DS.model.wScale);
			dom.append(mcv);
		}
		else{
			var mcv = document.getElementById('fontSelect');
			console.log(dom.width());
			DS.width = mcv.width = dom.width();
			DS.mar = Math.floor(DS.width / 10);
			DS.innerWid = DS.width - 2 * DS.mar;
			DS.innerHei = Math.floor(DS.innerWid * DS.model.hScale / DS.model.wScale);
			DS.height = mcv.height = DS.innerHei + 2 * DS.mar;
			DS.wMark = Math.floor(DS.innerWid * DS.model.markScale / DS.model.wScale);
			DS.lk = Math.floor(DS.innerWid * DS.model.markScale / DS.model.wScale);
			dom.append(mcv);
		}
		//为画布添加背景
		var ctx = document.getElementById('fontSelect').getContext('2d');
		ctx.fillStyle = "#fff";
		ctx.fillRect(0, 0, DS.width, DS.height);
		ctx.clearRect(DS.mar, DS.mar, DS.innerWid, DS.innerHei);
		if(DS.fgBg){
			var img = new Image();
			img.src = DS.rootPath + DS.model.fgBg;
			img.onload = function(){
				ctx.globalCompositeOperation = "destination-over";
				ctx.drawImage(img,DS.mar,DS.mar,DS.innerWid,DS.innerHei);
			}
		}else{
			ctx.fillStyle = "#fff";
			ctx.fillRect(DS.mar, DS.mar, DS.innerWid, DS.innerHei);
		}
	}
	/**
	 * 加载图片并在矩形区域显示，用于正文
	 * @param {Object} path 图片路径
	 * @param {Object} i    图片位置横坐标，自右向左
	 * @param {Object} j    图片位置纵坐标，自上向下
	 */
	function drawImg(path, i, j) {
		
		var img = new Image();
		img.src = '../../static/libraryResources/img/' + path;
		i++;
		var rMar = 0;
		//多行无内边距
		if(DS.model.markScale != 0)
			rMar = DS.wMark / 4;
		var ctx = document.getElementById('fontSelect').getContext('2d');
		ctx.globalCompositeOperation = "source-over";
		if(img.complete) {
			ctx.drawImage(img, DS.width - DS.mar - DS.size * i - rMar, DS.mar + DS.pad + DS.size * j, DS.size, DS.size);
		} else {
			img.onload = function() {
				ctx.drawImage(img, DS.width - DS.mar - DS.size * i - rMar, DS.mar + DS.pad + DS.size * j, DS.size, DS.size);
			}
		}
	}
	/**
	 * 加载图片并在矩形区域显示，用于团扇
	 * @param {Object} path 图片路径
	 * @param {Object} i    图片位置横坐标，自右向左
	 * @param {Object} j    图片位置纵坐标，自上向下
	 */
	function drawImg(path, i, j, mar) {
		
		var img = new Image();
		img.src = '../../static/libraryResources/img/' + path;
		i++;
		var rMar = 0;
		if(mar == undefined)
			mar = 0;
		//多行无内边距
		if(DS.model.markScale != 0)
			rMar = DS.wMark / 4;
		var ctx = document.getElementById('fontSelect').getContext('2d');
		ctx.globalCompositeOperation = "source-over";
		if(img.complete) {
			ctx.drawImage(img, DS.width - DS.mar - DS.size * i - rMar, DS.mar + DS.pad + DS.size * j, DS.size, DS.size);
		} else {
			img.onload = function() {
				ctx.drawImage(img, DS.width - DS.mar - DS.size * i - rMar - mar, DS.mar + DS.pad + DS.size * j + mar, DS.size, DS.size);
			}
		}
	}
	/**
	 * 加载图片并在矩形区域显示，用于楹联
	 * @param {Object} path 图片路径
	 * @param {Object} i    图片位置横坐标，自右向左
	 * @param {Object} j    图片位置纵坐标，自上向下
	 */
	function drawImgYl(path, i, j, mar) {
		
		var img = new Image();
		img.src = '../../static/libraryResources/img/' + path;
		i++;
		var rMar = 0;
		//多行无内边距
		if(DS.model.markScale != 0)
			rMar = DS.wMark / 4;
		var ctx = document.getElementById('fontSelect').getContext('2d');
		ctx.globalCompositeOperation = "source-over";
		if(img.complete) {
			ctx.drawImage(img, 3*DS.width/4 - i*DS.width/2 - DS.mar - DS.size * 2 - rMar, DS.mar + DS.pad + DS.size * j, DS.size, DS.size);
		} else {
			img.onload = function() {
				console.log(5*DS.width/7 - 3*(i - 1)*DS.width/5 - DS.mar - DS.size / 2 - rMar);
				ctx.drawImage(img, 2*DS.width/3 - (i - 1)*DS.width/3 - DS.mar - rMar, DS.mar + DS.pad + DS.size * j, DS.size, DS.size);
			}
		}
	}
	/**
	 * 加载图片并在矩形区域显示，用于条屏
	 * @param {Object} path 图片路径
	 * @param {Object} i    图片位置横坐标，自右向左
	 * @param {Object} j    图片位置纵坐标，自上向下
	 */
	function drawImgTp(path, i, j, mar) {
		
		var img = new Image();
		img.src = '../../static/libraryResources/img/' + path;
		i++;
		var rMar = 0;
		//多行无内边距
		if(DS.model.markScale != 0)
			rMar = DS.wMark / 4;
		var ctx = document.getElementById('fontSelect').getContext('2d');
		ctx.globalCompositeOperation = "source-over";
		if(img.complete) {
			ctx.drawImage(img, 3*DS.width/4 - i*DS.width/2 - DS.mar - DS.size * 2 - rMar, DS.mar + DS.pad + DS.size * j, DS.size, DS.size);
		} else {
			img.onload = function() {
				console.log(i);
//				console.log(12*DS.width/13 - (Math.floor(i/2)+i)*DS.width/13 - DS.mar - DS.size / 2 - rMar);
				ctx.strokeRect(DS.width - DS.mar - i*DS.size - (Math.ceil(i / 2) + 1)*DS.innerWid/23, DS.mar + DS.pad + DS.size * j, DS.size, DS.size);
//				ctx.drawImage(img, DS.width - (Math.floor(i/2)+i)*DS.width/13 - DS.mar - DS.size / 2 - rMar, DS.mar + DS.pad + DS.size * j, DS.size, DS.size);
			}
		}
	}
	
	/**
	 * 加载图片并在矩形区域显示，用于落款
	 * @param {Object} path 图片路径
	 * @param {Object} i    图片位置横坐标，自右向左
	 * @param {Object} j    图片位置纵坐标，自上向下
	 */
	function drawMark(path, i, j) {
		if(DS.wMark > 0) {
			var img = new Image();
			img.src ='../../static/libraryResources/img/' + path;
			DS.markSize = Math.floor(Math.min(DS.wMark, DS.innerHei / (DS.mark.length + 2),DS.size/2));
			var ctx = document.getElementById('fontSelect').getContext('2d');
			ctx.globalCompositeOperation = "source-over";
			if(img.complete) {
				ctx.drawImage(img, DS.mar + DS.wMark / 4, DS.mar + DS.markSize * j, DS.markSize, DS.markSize);
			} else {
				img.onload = function() {
					ctx.drawImage(img, DS.mar + DS.wMark / 4, DS.mar + DS.markSize * (j + 1), DS.markSize, DS.markSize);
				}
			}
		}
	}
	
	
	//填充条幅
	function fillDrawTf() {
		var w = DS.innerWid,
			l = DS.mes.length,
			h = DS.innerHei;
		
		DS.cols = 2;
		DS.rows = 1;
		while( DS.rows * DS.cols < l){
			DS.rows ++;
		}
		DS.size = Math.floor(DS.innerWid / 2);
		var canvas = document.querySelector('#fontSelect');
		var ctx = canvas.getContext('2d');
		ctx.clearRect(0,0,DS.width,DS.height);
		DS.height = canvas.height = DS.size * (DS.rows + 1);
		DS.innerHei = DS.height - DS.mar * 2;
		ctx.fillStyle = "#FFFFFF";
		ctx.fillRect(0,0,DS.width,DS.height);
		ctx.clearRect(DS.mar, DS.mar, DS.innerWid, DS.innerHei);
		if(DS.fgBg){
			var img = new Image();
			img.src = DS.rootPath + DS.model.fgBg;
			img.onload = function(){
				ctx.globalCompositeOperation = "destination-over";
				ctx.drawImage(img,DS.mar,DS.mar,DS.innerWid,DS.innerHei);
			}
		}else{
			ctx.fillStyle = "#fff";
			ctx.fillRect(DS.mar, DS.mar, DS.innerWid, DS.innerHei);
		}
		console.log(DS.size * (DS.rows + 1));
		DS.pad = Math.floor((DS.innerHei - (DS.rows * DS.size))/2);
		var i,j;
		for(var n = 0; n < l; n ++){
			i = Math.floor(n/DS.rows);
			j = n%DS.rows;
			console.log(DO.mes);
			drawImg(DO.mes[n].word[0].path,i,j);
		}
		console.log(DS.mark.length);
		for(var i = 0; i < DS.mark.length; i++) {
			
			var path = DO.mark[i].word[0].path;
			
			drawMark(path, 0, i);
		}
	}
	//填充横幅
	function fillDrawHf() {
		var w = DS.innerWid,
			l = DS.mes.length,
			h = DS.innerHei;
		
		DS.cols = 1;
		DS.rows = 1;
		while( DS.rows * DS.cols < l){
			DS.cols ++;
		}
		DS.size = Math.floor(DS.innerHei);
		var canvas = document.querySelector('#fontSelect');
		var ctx = canvas.getContext('2d');
		ctx.clearRect(0,0,DS.width,DS.height);
		$("#fontSelect").css("width",DS.width + "px");
		DS.width = canvas.width = DS.size * l + DS.mar*2;
		DS.innerWid = DS.size * l;
		ctx.fillStyle = "#FFF";
		ctx.fillRect(0,0,DS.width,DS.height);
		ctx.clearRect(DS.mar, DS.mar, DS.innerWid, DS.innerHei);
		if(DS.fgBg){
			var img = new Image();
			img.src = DS.rootPath + DS.model.fgBg;
			img.onload = function(){
				ctx.globalCompositeOperation = "destination-over";
				ctx.drawImage(img,DS.mar,DS.mar,DS.innerWid,DS.innerHei);
			}
		}else{
			ctx.fillStyle = "#fff";
			ctx.fillRect(DS.mar, DS.mar, DS.innerWid, DS.innerHei);
		}
		console.log(DS.size * (DS.rows + 1));
		DS.pad = Math.floor((DS.innerHei - (DS.rows * DS.size))/2);
		var i,j;
		for(var n = 0; n < l; n ++){
			i = Math.floor(n/DS.rows);
			j = n%DS.rows;
			drawImg(DO.mes[n].word[0].path,i,j);
		}
		for(var i = 0; i < DS.mark.length; i++) {
			var path = DO.mark[i].word[0].path;
			drawMark(path, 0, i);
		}
	}
	//填充手卷
	function fillDrawSj() {
		var w = DS.innerWid - DS.wMark,
			l = DS.mes.length,
			h = DS.innerHei;
		
		DS.rows = Math.floor(Math.sqrt(l/3));
		DS.cols = Math.floor(DS.rows/3);
		while( DS.rows * DS.cols < l){
			DS.cols ++;
		}
		
		DS.size = Math.floor(Math.min(DS.innerHei / DS.rows, w/DS.cols));
		DS.pad = Math.floor((DS.innerHei - (DS.rows * DS.size))/2);
		
		var i,j;
		for(var n = 0; n < l; n ++){
			i = Math.floor(n/DS.rows);
			j = n%DS.rows;
			drawImg(DO.mes[n].word[0].path,i,j);
		}
		for(var i = 0; i < DS.mark.length; i++) {
			var path = DO.mark[i].word[0].path;
			drawMark(path, 0, i);
		}
	}
	//填充正方形画布,斗方
	function fillDrawDf() {
		var w = DS.innerWid - DS.wMark,
			l = DS.mes.length,
			h = DS.innerHei;
		
		DS.rows = Math.floor(Math.sqrt((l*h)/w));
		DS.cols = Math.floor(Math.sqrt((l*w)/h));
		while( DS.rows * DS.cols < l){
			if(DS.rows > DS.cols)
				DS.cols ++;
			else
				DS.rows ++;
		}
		
		DS.size = Math.floor(Math.min(DS.innerHei / DS.rows, w/DS.cols));
		DS.pad = Math.floor((DS.innerHei - (DS.rows * DS.size))/2);
		
		var i,j;
		for(var n = 0; n < l; n ++){
			i = Math.floor(n/DS.rows);
			j = n%DS.rows;
			drawImg(DO.mes[n].word[0].path,i,j);
		}
		for(var i = 0; i < DS.mark.length; i++) {
			var path = DO.mark[i].word[0].path;
			drawMark(path, 0, i);
		}
	}
	//填充正方形画布,中堂
	function fillDrawZt() {
		var w = DS.innerWid - DS.wMark,
			l = DS.mes.length,
			h = DS.innerHei;
		
		DS.rows = Math.round(Math.sqrt((l*h)/w));
		DS.cols = Math.round(Math.sqrt((l*w)/h));
		while( DS.rows * DS.cols < l){
			if(DS.rows > DS.cols + 1)
				DS.cols ++;
			else
				DS.rows ++;
		}
		
		DS.size = Math.floor(Math.min(DS.innerHei / DS.rows, w/DS.cols));
		DS.pad = Math.floor((DS.innerHei - (DS.rows * DS.size))/2);
		
		var i,j;
		for(var n = 0; n < l; n ++){
			i = Math.floor(n/DS.rows);
			j = n%DS.rows;
			drawImg(DO.mes[n].word[0].path,i,j);
		}
		for(var i = 0; i < DS.mark.length; i++) {
			console.log(DO.mark[i].word[0].path);
			var path = DO.mark[i].word[0].path;
			drawMark(path, 0, i);
		}
	}
	//填充只有一行的画布,匾额
	function fillDrawARow() {
		var ctx = document.getElementById('fontSelect').getContext('2d');
		var count = DS.mes.length;
		DS.size = Math.floor(Math.min(DS.innerHei, DS.innerWid * (DS.model.wScale - DS.model.markScale) / DS.model.wScale / count));
		if(DS.size - DS.innerHei) {
			DS.pad = Math.floor((DS.innerHei - DS.size) / 2);
		}else{
			DS.pad = 0;
		}
		for(var i = 0; i < count; i++) {
			var path = DO.mes[i].word[0].path;
			drawImg(path, i, 0);
		}
		for(var i = 0; i < DS.mark.length; i++) {
			var path = DO.mark[i].word[0].path;
			drawMark(path, 0, i);
		}
	}
	//填充扇面
	function fillDrawSm(){
		
	}
	//填充团扇
	function fillDrawTs(){
		var w = Math.floor(DS.innerWid * Math.sqrt(2)/2);
		var h = w;
		var l = DS.mes.length;
		mar = (DS.innerWid - w) / 2;
		DS.rows = Math.floor(Math.sqrt((l*h)/w));
		DS.cols = Math.floor(Math.sqrt((l*w)/h));
		console.log("r = " + DS.rows);
		console.log("c = " + DS.cols);
		while( DS.rows * DS.cols < l){
			if(DS.rows > DS.cols)
				DS.cols ++;
			else
				DS.rows ++;
		}
		
		DS.size = Math.floor(Math.min(w / DS.rows, w/DS.cols));
		DS.pad = Math.floor((w - (DS.rows * DS.size))/2);
		
		var i,j;
		for(var n = 0; n < l; n ++){
			i = Math.floor(n/DS.rows);
			j = n%DS.rows;
			drawImg(DO.mes[n].word[0].path,i,j, mar);
		}
	}
	//填充楹联
	function fillDrawYl(){
		var w = DS.innerWid * 9 / 10;
		var mar = DS.innerWid / 20;
		var h = DS.innerHei - mar * 2;
		
		
		DS.cols = 2;
		DS.rows = Math.ceil(DS.mes.length / 2);
		DS.size = Math.min(w / 3 , h / Math.ceil(DS.mes.length / 2));
		DS.pad = (DS.innerHei - DS.size * DS.rows) / 2;
		var i,j;
		for(var n = 0; n < DS.mes.length; n ++){
			i = Math.floor(n/DS.rows);
			j = n%DS.rows;
			drawImgYl(DO.mes[n].word[0].path,i,j, 0);
		}
	}
	//填充条屏
	function fillDrawTp(){
		var w = DS.innerWid;
		var h = DS.innerHei;
		var l = DS.mes.length;
		
		
		DS.cols = 8;
		DS.rows = Math.ceil(DS.mes.length / 8);
		DS.size = Math.min(w / 13 , h / Math.ceil(DS.mes.length / 8));
		DS.pad = (DS.innerHei - DS.size * DS.rows) / 2;
		var i,j;
		for(var n = 0; n < DS.mes.length; n ++){
			i = Math.floor(n/DS.rows);
			j = n%DS.rows;
			drawImgTp(DO.mes[n].path,i,j, 0);
		}
	}
})(jQuery)

