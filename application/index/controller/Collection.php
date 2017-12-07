<?php
//author: liuchenguang
//功能:收藏管理

namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\index\model\Collection as DynamicCollection;
use app\index\model\Message;

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
	
	//用户收藏动态
	//param 用户ID
	//param 动态ID
	//return 
	//"0" 成功 添加通知私信。。。
	//"1" 错误
	public function collect(Request $request){
		//判断用户是否登录
		if( !Session::has('user_id') ) {
			$this->error('请先登录！', url('index/User/index'));
		}
		//添加收藏记录
		$dycollection = new DynamicCollection;
		$dycollection->user_id= Session::get("user_id");
		$dynamic_id=Session::get("dynamic_id");
		$dycollection->dynamic_id=$dynamic_id;
		if($dycollection->save()){
		//私信通知用户
		$Msg = new Message;
		$Msg->topic = 2;
		$Msg->receiver_id=Session::get("author");
		$Msg->time=date("Y-m-d H:i:s");
		$Msg->content=Session::get('user_name').'收藏了你的动态！';
		$Msg->is_read=0;
		$Msg->flag_id=$dynamic_id;
		$Msg->save();
		//更新动态收藏数
			return json("0");
		}
		else{
			return json("1");
		}
	}
	
	//用户取消收藏动态
	//param 用户ID
	//param 动态ID
	//return 
	//"0" 成功
	//"1" 错误
	public function cancelcollect(Request $request){
		$dynamic_id=Session::get("dynamic_id");		
		$dycollection = new DynamicCollection;
		$dycollection =$dycollection->where('dynamic_id',$dynamic_id)
		->where('user_id',Session::get("user_id"))
		->find();
		if($dycollection->delete()){
			return json("0");
		}
		else{
			return json("1");
		}
	}
}


?>