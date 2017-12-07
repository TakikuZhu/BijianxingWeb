<?php
namespace app\index\model;
use think\Model;

class User extends Model{
	protected $table = 'tb_user';
	//protected $table=" ";
	public function getUserStatusAttr($value)
    {
        $user_status = [0=>'标志',1=>'正常',2=>'冻结',3=>'禁用',];
        return $user_status[$value];
    }
}
?>