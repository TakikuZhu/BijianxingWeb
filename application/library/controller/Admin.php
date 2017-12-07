<?php
namespace app\library\controller;
use think\Controller;
use think\Request;
use app\library\model\Font;

class Admin extends Controller
{
    public function index()
    {
//      return $this->fetch();
		return view('admin');
    }
    public function GetFont(Request $request){
		
		$font_name = $request->param('font');
		$font = new Font;

		$str = "";
		$str .="[";
		
		foreach( preg_split('/(?<!^)(?!$)/u', $font_name ) as $c){
		//echo $c;
		$fontlist = $font::where('font_name',$c)
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
	
	public function GetInforFont(Request $request){
			
			$font_name = $request->param('font');
			$font = new Font;
	
			$str = "";
			$str .="[";
			
			foreach( preg_split('/(?<!^)(?!$)/u', $font_name ) as $c){
			//echo $c;
			$fontlist = $font::where('font_name',$c)
			->order('save_date','desc')
			->select();
			
			return json($fontlist);
			}
		}

}
?>