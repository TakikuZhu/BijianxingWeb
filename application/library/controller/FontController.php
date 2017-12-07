<?php

namespace app\library\controller;
use think\Db;
use think\Controller;
use think\Request;
use app\library\model\Font;
/**
 * auther : xuzhouyang
 */

class FontController extends Controller{
	
	public function Index(){
		return json(1);
	}
	
	/**
	 * font_name ： 字   如 font_name = 于
	 * master ：作者
	 * type : 书体
	 * rang : 字体
	 * grah : 字形
	 */
	public function GetFont(Request $request){
		
		$font_name = $request->param('font');
		$master = $request->param('master');
		$type = $request->param('type');
		$range = $request->param('range');
		$grap = $request->param('grap');
		$font = new Font;

		$str = "";
		$str .="[";
		
		foreach( preg_split('/(?<!^)(?!$)/u', $font_name ) as $c){
		//echo $c;
		$fontlist = $font::where('font_name',$c)
		->where('font_master',$master)
		->where('font_type',$type)
		->where('font_range',$range)
		->where('font_grap',$grap)
		->select();
		
		
		if(count($fontlist)){
			$str .= "{";
			$str .= "\"" . "word" ."\":[";
			foreach($fontlist as $fonts)
			{
				//$str .= "{\"oid\":\"" . $fonts->font_id . "\",";
				$str .= "{\"path\":\"" . $fonts->font_url . "\"},";
			}
		
			$str .= "]},";
		
		}else{
			$str .= "{},";
		}
			
		}
		
		$str .= "]";
		
		$str = str_replace("},]","}]",$str);
		//echo $str;
		return json($str);
	}

	
	/**
	 * font_name ： 字   如 font_name = 于
	 * master ：作者
	 * type : 书体
	 * rang : 字体
	 * grah : 字形
	 * url : 文件名
	 */
	public function AddFont(){
		$files = request()->file('image');
		$font_name = request()->param('_name');
		$font_type = request()->param('_fontStyle');
		$font_master = request()->param('_auther');
		$font_range = request()->param('_fontFam');
		$font_grap = request()->param('_figure');
		$save_date = date('Y/m/d');
		//return json($font_name);
		foreach($files as $file){
        	// 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public/static/libraryResources/img');
            if($info){
                // 成功上传后 获取上传信息
                $font_url = str_replace("\\","/",$info->getSaveName());
                $data = [ 
				'font_name' => $font_name, 
				'font_type'=>$font_type, 
				'font_master' => $font_master, 
    			'font_range'=>$font_range, 
    			'font_grap'=>$font_grap,
    			'font_url'=>$font_url,
    			'save_date'=>$save_date
    			];
    			$row = Db::table('tb_font')
    					->insert($data);
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            	}
        	}
        }
		return "<script>alert(\"上传成功\"); window.location.href='../../library/admin/index';</script>";
	}
	
	
	/**
	 * id :id 
	 * font ： 字   如 font_name = 于
	 * master ：作者
	 * type : 书体
	 * rang : 字体
	 * grah : 字形
	 * url : 文件名
	 */
	public function upFont(Request $request){
		
		$id = $request->param('id');
		$font_name = $request->param('font');
		$font_type = $request->param('type');
		$font_master = $request->param('master');
		$font_range = $request->param('range');
		$save_date = date('Y/m/d');
		$row = Db::table('tb_font')
			->where('font_id',$id)
    		->update([ 'font_name' => $font_name, 'font_type'=>$font_type, 'font_master' => $font_master, 
    		'font_range'=>$font_range,'save_date'=>$save_date]);
		return json($row);
	}
	
	
	/**
	 * font : 字名 
	 * 参数暂定
	 * 
	 */
	public function selectAll(Request $request){
		
		$font_name = $request->param('font');
		$fonts = new Font;
		$fontList = $fonts::where('font_name',$font_name)
					->select();			
		return json($fontList);
		
	}
	
	/**
	 * param  oid : 字体id
	 */
	public function DeleteFont(Request $request){
		$font_id = $request->param("oid");
		$row = Db::table('tb_font')
		->where('font_id',$font_id)
		->delete();
		
		return json($row);
	}
	
	/**
	 * 返回作者
	 */
	
	public function GetAuther(Request $request){
		$auther = Db::query('select distinct font_master from tb_font');
		
		return json($auther);
	}
	
	/**
	 * font_name ： 字   如 font_name = 于
	 * auther 1 2 3 : 作者  首选 次选  末选
	 * type : 书体
	 * rang : 字体
	 * grah : 字形
	 * url : 文件名
	 */
	public function GetFont2(Request $request){
		$font_name = $request->param('font');
		$auther1 = $request->param('auther1');
		$auther2 = $request->param('auther2');
		$auther3 = $request->param('auther3');
		$type = "毛笔";
		$range = $request->param('range');
		$grap = "全实";
		$font = new Font;

		$str = "";
		$str .="[";
		
		foreach( preg_split('/(?<!^)(?!$)/u', $font_name ) as $c){
		//echo $c;\/
			/**
			 * auther1 查询
			 */
			$fontlist1 = $font::where('font_name',$c)
			->where('font_master',$auther1)
			->where('font_type',$type)
			->where('font_range',$range)
			->where('font_grap',$grap)
			->select();
			/**
			 * auther2 查询
			 */
			$fontlist2 = $font::where('font_name',$c)
			->where('font_master',$auther2)
			->where('font_type',$type)
			->where('font_range',$range)
			->where('font_grap',$grap)
			->select();
			
			/**
			 * auther3 查询
			 */
			$fontlist3 = $font::where('font_name',$c)
			->where('font_master',$auther3)
			->where('font_type',$type)
			->where('font_range',$range)
			->where('font_grap',$grap)
			->select();
			
			if(count($fontlist1) || count($fontlist2) || count($fontlist3)){
				$str .= "{";
				$str .= "\"" . "word" ."\":[";
				if(count($fontlist1)){
					foreach($fontlist1 as $fonts)
					{
						if($fonts->font_url != null && $fonts->font_url != ""){
							$str .= "{\"path\":\"" . $fonts->font_url . "\"},";
						}
					}
				}
				if(count($fontlist2)){
					foreach($fontlist2 as $fonts)
					{
						if($fonts->font_url != null && $fonts->font_url != ""){
							$str .= "{\"path\":\"" . $fonts->font_url . "\"},";
						}
					}
				}
				if(count($fontlist3)){
					foreach($fontlist3 as $fonts)
					{
						if($fonts->font_url != null && $fonts->font_url != ""){
							$str .= "{\"path\":\"" . $fonts->font_url . "\"},";
						}
					}
				}
		
				$str .= "]},";
		
			}else{
				$str .= "{},";
			}	
		}
		$str .= "]";
		
		$str = str_replace("},]","}]",$str);
		//echo $str;
		return json($str);
	}
	
	
	/**
	 * 
	 */
	
	public function GetInforFont(Request $request){
		
		$font_name = $request->param('font');
		$master = $request->param('master');
		$range = $request->param('type');
		$type = "毛笔";
		$grap = "全实";
		$font = new Font;

		$str = "";
		$str .="[";
		
		foreach( preg_split('/(?<!^)(?!$)/u', $font_name ) as $c){
		//echo $c;
		$fontlist = $font::where('font_name',$c)
		->where('font_master',$master)
		->where('font_type',$type)
		->where('font_range',$range)
		->where('font_grap',$grap)
		->select();
		
		return json($fontlist);
		}
	}
}

?>