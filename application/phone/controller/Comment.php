<?php
//author: liuchenguang
//功能:评论管理
namespace app\phone\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\phone\model\Comment as DynamicComment;
use app\phone\model\Message;
use app\phone\model\Dynamics;
use app\phone\model\User as User;


class Comment extends Controller{
	
	//显示评论
	//param 表名
	//param 动态ID
	public function displaycomment(){
		//根据动态ID查找评论内容
		$list=DynamicComment::where('dynamic_id',$dynamic_id)->order("time")->paginate(5);
		$this->assign('list',$list);
		$this->assign('count',count($list));
		//返回评论页面
		return view('comment');
	}
	
	//添加评论
	//param 动态ID
	//param 评论人ID
	//param 内容
	//param 时间
	//return 
	//"0" 成功 添加通知私信。。。
	//"1" 错误
	public function addcomment(Request $request){
		//从session中读取数据
		$user_id = Session::get("user_id");
		//$user_name = Session::get("user_name");
		$dynamic_id = Session::get("dynamic_id");
		//$author = Session::get("author");
		
		//添加评论
		$dycomment = new DynamicComment;
		$dycomment->sender_id=$user_id;
		$dycomment->dynamic_id=$dynamic_id;
		$dycomment->content=$request->param("content");
		$dycomment->time=date("Y-m-d H:i:s");

		if($dycomment->save()){
		return json("0");
		}
	}
	
	//回复评论
	//param 动态ID
	//param 评论人ID
	//param 被回复评论人ID
	//param 内容
	//param 时间
	//return 
	//"0" 成功
	//"1" 错误
	public function replycomment(Request $request){
		//从session中读取数据
		$user_id = Session::get("user_id");
		$dynamic_id = Session::get("dynamic_id");
		$receiver_id = $request->param("receiver_id");
		$user = new User;
		$userName = $user->where('user_id', $receiver_id)
		->value('user_name');
		
		$content = "@".$userName.":".$request->param("content");
		
		//添加评论
		$dycomment = new DynamicComment;
		$dycomment->sender_id=$user_id;
		$dycomment->receiver_id=$receiver_id;
		$dycomment->dynamic_id=$dynamic_id;
		$dycomment->content=$content;
		$dycomment->time=date("Y-m-d H:i:s");
		if($dycomment->save()){
			return json("1");
		}
	}

	
}


?>