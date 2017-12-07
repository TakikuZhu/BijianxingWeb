<?php
//author: liuchenguang
//功能:打分管理

namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\index\model\Score as DynamicScore;
use app\index\model\Message;
use app\index\model\Dynamics;


class Score extends Controller{
	
	//检查用户是否打分
	//param 用户ID
	//param 动态ID
	//return
	//"0" no
	//"1" yes
	public function checkscore(Request $request){
		$dyscore =new DynamicScore;
		$dynamic_id=Session::get("dynamic_id");		
		$dyscore =$dyscore->where('dynamic_id',$dynamic_id)
		->where('user_id',Session::get("user_id"))
		->find();
		if(!$dyscore){
			return json("0");
		}
		else{
			//$data="{\"statue\":\"1\",\"score\":\"".$dyscore.score."\"}";
			$data = array();
			$data['statue']=1;
			$data['score']=$dyscore['score'];
			return json($data);
		}
	}	
	
	//用户打分动态
	//param 用户ID
	//param 动态ID
	//param 用户评分 0-100
	//return
	//"0" 成功 更改动态状态 发送消息
	//"1" 错误
	public function score(Request $request){
		//判断用户是否登录
		if( !Session::has('user_id') ) {
			$this->error('请先登录！', url('index/User/index'));
		}
		$dynamic_id=Session::get("dynamic_id");
		//新增打分记录
		$dyscore = new DynamicScore;
		$dyscore->user_id = Session::get("user_id");
		$dyscore->dynamic_id=$dynamic_id;
		$dyscore->score=$request->param("score");
		if($dyscore->save()){
		
		//私信通知用户 
		$Msg = new Message;
		$Msg->topic = 2;
		$Msg->receiver_id=Session::get("author");
		$Msg->time=date("Y-m-d H:i:s");
		$Msg->content=Session::get('user_name').'打分了你的动态！';
		$Msg->is_read=0;
		$Msg->flag_id=$dynamic_id;
		$Msg->save();
		
		//更新动态均分
		$dy=Dynamics::get($dynamic_id);
		$dy->score = ($dy["score"]*$dy["score_num"]+$request->param("score"))/($dy["score_num"]+1);
		$dy->score_num=$dy["score_num"]+1;
		$dy->save();
			return json("0");
		}
		else{
			return json("1");
		}
	}
}

?>