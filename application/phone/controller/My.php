<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\phone\model\User as UserModel;

class My extends Controller
{
	public function my()
    {
    	$user_id = Session::get('user_id');
    	$this->assign('user_id' ,$user_id);
    	
    	//获取文章量
    	$countdynamic = Db::name('dynamic')
        ->where('user_id', $user_id)
        ->count();
        $this->assign('dynamic_count',$countdynamic);
    	
    	//获取关注量
    	$countfocus = Db::name('focus')
        ->where('focus_id', $user_id)
        ->count();
        $this->assign('focus_count',$countfocus); 

		//获取粉丝量
        $countfans = Db::name('focus')
        ->where('foucsed_id', $user_id)
        ->count();
        $this->assign('fans_count',$countfans); 
         
    	//获取收藏量
    	$countcollect = Db::name('collect')
        ->where('user_id', $user_id)
        ->count();
        $this->assign('collect_count',$countcollect);
        
        //获取座右铭
        $motto = Db::name('user')
        ->where('user_id', $user_id)
        ->value('motto');
        $this->assign('motto', $motto);
        
        //获取用户头像
        $photo = Db::name('user')
        ->where('user_id', $user_id)
        ->value('user_photo');
        $this->assign('photo',$photo);
        
        //获取用户名
        $username = Db::name('user')
        ->where('user_id', $user_id)
        ->value('user_name');
        $this->assign('user_name',$username);
        
    	return $this->fetch('user/my');
    }
    
    
    public function listPage($type, $user_id)
    {
    	$model = new UserModel();
    	if ($type == 'focus') {
    		$sql = "select user_name, motto, user_photo from tb_user where user_id in (select foucsed_id from tb_focus where focus_id =".$user_id.")"; 
    	} else {
    		$sql = "select user_name, motto, user_photo from tb_user where user_id in (select focus_id from tb_focus where foucsed_id =".$user_id.")";
    	}
    	$list = $model->query($sql);
    	$this->assign('list', $list);
    	
    	$this->assign('user_id', Session::get('user_id'));
    	
    	return $this->fetch('user/list');
    }
}
?>