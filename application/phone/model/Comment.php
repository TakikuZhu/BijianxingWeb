<?php
//author: liu chenguang
//评论表实体层
namespace app\phone\model;
use think\Model;

class Comment extends Model{
	protected $table = 'tb_dynamic_comment';
	
	protected function sender(){
		return $this->hasOne('user','user_id','sender_id');
	}
	
	protected function receiver(){
		return $this->hasOne('user','user_id','receiver_id');
	}
}
?>