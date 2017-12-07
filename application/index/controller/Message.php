<?php
//author:liuchenguang
//功能：私信管理
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\Db;
use app\index\model\Message as Msg;

class Message extends Controller
{
	//渲染页面
   	public function displayside(Request $request)
    {
    	//判断用户是否登录
		if( !Session::has('user_id') ) {
			$this->error('请先登录！', url('index/User/index'));
		}
		
      	$user_id= Session::get("user_id");
    	$sql = "select distinct tb_user.user_name,tb_user.user_id from tb_user,tb_msg where tb_msg.receiver_id =".$user_id." and tb_msg.topic =3  and tb_msg.sender_id = tb_user.user_id";
		$list = Db::query($sql);
    	$this->assign('side_list',$list);
    	return  $this->fetch('message');
	}
	
	//得到未读消息数目
	public function checkMsg(Request $request){
		$user_id = Session::get("user_id");
//		$num = Db::query("select count(*) from tb_msg where receiver_id=".$user_id." and is_read=0");
		$num = Db::table('tb_msg')
			 ->where('receiver_id',$user_id)
	   		 ->where('is_read',0)
			 ->count();
		return $num;
	}
	
	//得到topic为1和2的私信未读数目
	public function checkMsgByTopicAndId(Request $request){
		$user_id = Session::get("user_id");
		$num_1 = Db::table('tb_msg')
			 ->where('receiver_id',$user_id)
	   		 ->where('is_read',0)
	   		 ->where('topic',1)
			 ->count();
		$num_2 = Db::table('tb_msg')
			 ->where('receiver_id',$user_id)
	   		 ->where('is_read',0)
	   		 ->where('topic',2)
			 ->count();
		$data=array();
		$data[0]=$num_1;
		$data[1]=$num_2;
		return json($data);
		
//		$num =Db::table('tb_msg')
//			 ->where('is_read',0)
//			 ->where('receiver_id',$user_id)
//			 ->where('topic','in',["1","2"])
//			 ->field("count(*) as count,topic")
//			 ->group('topic')
//			 ->find();
//		return $num;

	}
	
	//得到和某个人聊天的未读消息列表
	public function checkMsgByUserId(){
		$user_id= Session::get("user_id");
    	$sql = "select distinct tb_user.user_id from tb_user,tb_msg where tb_msg.receiver_id =".$user_id." and tb_msg.topic =3  and tb_msg.sender_id = tb_user.user_id";
		$list = Db::query($sql);
//		return $list;
//		$list=Db::table("tb_msg")
//				->join('tb_user w','tb_msg.receiver_id = w.user_id')
//				->where('tb_msg.receiver_id',$user_id)
//				->where('tb_msg.topic',3)
//				->select();
		$data="[";
		foreach($list as $user){
			$num = Db::table('tb_msg')
			 ->where('receiver_id',$user_id)
			 ->where('sender_id',$user["user_id"])
	   		 ->where('is_read',0)
	   		 ->where('topic',3)
			 ->count();
			$data.="{\"user_id\":\"".$user["user_id"]."\",\"num\":\"".$num."\"},";
		}
		$data.="]";
		return $data;
	}
	
	//创建新的聊天
	public function createNewTalk($user_id){
		//判断用户是否登录
		if( !Session::has('user_id') ) {
			$this->error('请先登录！', url('index/User/index'));
		}
		
		$sql = "select user_name,user_id,user_photo from tb_user where user_id =".$user_id;
		$list = Db::query($sql);
		$this->assign('side_list',$list);
    	return  $this->fetch('message');
	}
	
	//得到topic为0的系统通知
	public function getMsgByTopic(Request $request){
      	$user_id = Session::get("user_id");
      	$del_list=Db::table('tb_msg_del')->where("user_id",$user_id)->column('msg_id');
      	$list=Db::table('tb_msg')->where("tb_msg.topic",$request->param("topic"))
      	->where("tb_msg.msg_id",'not in',$del_list)
      	->select();
		return $list;
	}
	
	//得到topic为1和2的私信
	public function getMsgByTopicAndId(Request $request){
      	$user_id = Session::get("user_id");
      	$del_list=Db::table('tb_msg_del')->where("user_id",$user_id)->column('msg_id');
      	$list=Db::table('tb_msg')->where("tb_msg.topic",$request->param("topic"))
      	->where("receiver_id",$user_id)
      	->where("tb_msg.msg_id",'not in',$del_list)
      	->select();
		foreach($list as $msg){
			if($msg["is_read"]==0){
				Db::table("tb_msg")->where("msg_id",$msg["msg_id"])->update(['is_read'=>1]);
			}
		}
		return $list;
	}
	
	//显示所有没有被屏蔽的私信
	public function getmesgbyuserid(Request $request){
		$sender_id = $request->param("sender_id");
		$receiver_id = Session::get("user_id");
      	$user_id = Session::get("user_id");
		
      	$del_list=Db::table('tb_msg_del')->where("user_id",$user_id)->column('msg_id');
		$list=Db::table('tb_msg')->where("tb_msg.sender_id",'in',[$sender_id,$receiver_id])
		->join('tb_user w','tb_msg.sender_id = w.user_id')
		->where("tb_msg.receiver_id",'in',[$sender_id,$receiver_id])
		->order('tb_msg.time','desc')
		->where("topic",'3')
		->where("tb_msg.msg_id",'not in',$del_list)
		->select();
   		foreach($list as $msg){
			if($msg["is_read"]==0){
				Db::table("tb_msg")->where("msg_id",$msg["msg_id"])->where("receiver_id",$user_id)->update(['is_read'=>1]);
			}
		}
		return $list;
	}
	
	//对该用户屏蔽该私信
	public function deleteMsg(Request $request){
		$msg_id = $request->param("msg_id");
		$user_id = Session::get("user_id");
		$sql = "insert into tb_msg_del values(\"".$msg_id."\",\"".$user_id."\");";
		$result =Db::execute($sql);
		if($result){
			return json("0");
		}
		else{
			return json("1");
		}
	}
	
	//添加新的对话私信
	public function addtalkmsg(Request $request){
		$sender_id = Session::get("user_id");
		
		$Msg = new Msg;
		$Msg->topic=3;
		$Msg->sender_id=$sender_id;
		$Msg->receiver_id=$request->param("receiver_id");
		$Msg->time=date("Y-m-d H:i:s");
		$Msg->content=$request->param("content");
		$Msg->is_read=0;
		if($Msg->save()){
			return json("0");
		}
		else{
			return json("1");
		}
	}
}
?>