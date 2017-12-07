<?php
//author: liuchenguang
//私信表实体层

namespace app\index\model;
use think\Model;

class Message extends Model
{
	protected $table="tb_msg";
	
	protected function sender(){
		return $this->hasOne('user','user_id','sender_id');
	}
	
	protected function receiver(){
		return $this->hasOne('user','user_id','receiver_id');
	}
	
//	protected function getTopicAttr($value)
//	{
//		$topic=[
//				 0=>'系统通知',
//				 1=>'系统提示',
//				 2=>'系统消息',
//				 3=>'站友私信'
//				];
//		return $topic[$value];
//	}
}
?>