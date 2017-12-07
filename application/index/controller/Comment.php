<?php
//author: liuchenguang
//功能:评论管理
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\index\model\Comment as DynamicComment;
use app\index\model\Message;
use app\index\model\Dynamics;


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
		//判断用户是否登录
		if( !Session::has('user_id') ) {
			$this->error('请先登录！', url('index/User/index'));
		}
		
		//从session中读取数据
		$user_id = Session::get("user_id");
		$user_name =Session::get("user_name");
		$dynamic_id = Session::get("dynamic_id");
		$author = Session::get("author");
		
		//添加评论
		$dynamic_id=$dynamic_id;
		$dycomment = new DynamicComment;
		$dycomment->sender_id=$user_id;
		$dycomment->dynamic_id=$dynamic_id;
		$dycomment->content=$request->param("content");
		$dycomment->time=date("Y-m-d H:i:s");
		if($dycomment->save()){
		//添加私信 告诉动态作者有新回复
		if($author!=$user_id){
			$Msg = new Message;
			$Msg->topic = 2;
			$Msg->time=date("Y-m-d H:i:s");
			$Msg->receiver_id=$author;
			$Msg->content=$user_name.'评论了你的动态！';
			$Msg->is_read=0;
			$Msg->flag_id = $dynamic_id;
			if($Msg->save()){
				return json("0");
			}
			else{
				return json("1");
			}
		}
		//作者评论自身动态，无需消息提示
		else{
			return json("0");
		}
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
		//判断用户是否登录
		if( !Session::has('user_id') ) {
			$this->error('请先登录！', url('index/User/index'));
		}
		
		//从session中读取数据
		$user_id = Session::get("user_id");
		$user_name =Session::get("user_name");
		$dynamic_id = Session::get("dynamic_id");
		
		//添加评论
		$dycomment = new DynamicComment;
		$dycomment->sender_id=$user_id;
		$dycomment->receiver_id=$request->param("receiver_id");
		$dycomment->dynamic_id=$dynamic_id;
		$dycomment->content=$request->param("content");
		$dycomment->time=date("Y-m-d H:i:s");
		if($dycomment->save()){
		//添加私信 告诉评论作者有回复
		$Msg = new Message;
		$Msg->topic = 2;
		$Msg->time=date("Y-m-d H:i:s");
		$Msg->sender_id=$user_id;
		$Msg->receiver_id=$request->param("receiver_id");
		$Msg->content=$user_name.'回复了你的评论！';
		$Msg->is_read=false;
		$Msg->flag_id = $dynamic_id;
		$Msg->save();
			return json("0");
		}
		else{
			return json("1");
		}
	}

	//查找评论
	//param 动态ID
	//"0" 成功
	//"1" 错误
	public function searchcommnet(){
		
	}
	
}


?>