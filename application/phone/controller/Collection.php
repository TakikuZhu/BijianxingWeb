<?php
//author: liuchenguang
//功能:收藏管理

namespace app\phone\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\Db;
use app\phone\model\Collection as DynamicCollection;
use app\phone\model\Focus as Foc;

class Collection extends Controller{	
	
	//检查用户是否收藏该动态
	//param 用户ID
	//param 动态ID
	//return 
	//"0" no
	//"1" yes
	public function checkcollect(Request $request){
		$dynamic_id = Session::get("dynamic_id");
		$dycollection = new DynamicCollection;
		$dycollection =$dycollection->where('dynamic_id',$dynamic_id)
		->where('user_id',Session::get("user_id"))
		->find();
		if(!$dycollection){
			return json("0");
		}
		else{
			return json("1");
		}
	}
	
	public function checkfocus(Request $request){
		$dynamic_id = Session::get("dynamic_id");
		$user_id = Session::get("user_id");		
		
		$model = new DynamicCollection();
		$sql = "select * from tb_focus where focus_id = ".$user_id
		." and foucsed_id in ( select user_id from tb_dynamic where dynamic_id = ".$dynamic_id.")";
		$focus = $model->query($sql);
		if(!$focus){
			return json("0");
		}
		else{
			return json("1");
		}
	}
	
	//用户收藏动态
	//param 用户ID
	//param 动态ID
	//return 
	//"0" 成功 添加通知私信。。。
	//"1" 错误
	public function collect(Request $request){
		//添加收藏记录
		$dycollection = new DynamicCollection;
		$dycollection->user_id= Session::get("user_id");
		$dynamic_id=Session::get("dynamic_id");
		$dycollection->dynamic_id=$dynamic_id;
		if($dycollection->save()){
			return json("0");
		}
		else{
			return json("1");
		}
	}
	
	public function focus_user(Request $request){
		$dynamic_id = Session::get("dynamic_id");
		$user_id = Session::get("user_id");	
		
		$foucsed_id = Db::name('dynamic')
    	->where('dynamic_id', $dynamic_id)
    	->value('user_id');
		
		if ($user_id != $foucsed_id) {
			$focus = new Foc;
			$focus->focus_id = $user_id;
			$focus->foucsed_id = $foucsed_id;
			if($focus->save()){
				return json("0");
			}
			else{
				return json("1");
			}
		} else {
			return json("2");
		}
		
	}
	
	//用户取消收藏动态
	//param 用户ID
	//param 动态ID
	//return 
	//"0" 成功
	//"1" 错误
	public function cancelcollect(Request $request){
		$dynamic_id = Session::get("dynamic_id");	
		$dycollection = new DynamicCollection;
		$dycollection =$dycollection
		->where('dynamic_id',$dynamic_id)
		->where('user_id',Session::get("user_id"))
		->find();
		if($dycollection->delete()){
			return json("0");
		}
		else{
			return json("1");
		}
	}
	
	public function cancelfocus(Request $request){
		$dynamic_id = Session::get("dynamic_id");
		$user_id = Session::get("user_id");	
		
		$foucsed_id = Db::name('dynamic')
    	->where('dynamic_id', $dynamic_id)
    	->value('user_id');
		
		$focus = new Foc;
		$focus = $focus 
		->where('focus_id', $user_id)
		->where('foucsed_id', $foucsed_id)
		->find();

		if($focus->delete()){
			return json("0");
		}
		else{
			return json("1");
		}
	}
}


?>