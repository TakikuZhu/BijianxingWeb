<?php
//author:wangyinghao
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\index\model\Index as UserModel;
use app\index\model\Focus as UserModel2;

//关注

class Detail2 extends Controller
{
	
	
	public function Detail2()
	{
		$per_id=Session::get('user_id');
		$countfocus = Db::name('focus')
         ->where('focus_id', $per_id)
         ->count();
         $this->assign('atten',$countfocus); 
         //获取关注数量
         $countfans = Db::name('focus')
         ->where('foucsed_id', $per_id)
         ->count();
         $this->assign('fans',$countfans); 
         //获取粉丝数量
         $countcollect = Db::name('collect')
	         ->where('user_id', $per_id)
	         ->count();
	         $this->assign('clcount',$countcollect);
         $countdynamic = Db::name('dynamic')
         ->where('user_id', $per_id)
         ->count();
         $this->assign('dycount',$countdynamic);
         $seatright = Db::name('user')
         ->where('user_id', $per_id)
         ->value('motto');
         $this->assign('perId',$per_id);
//获取座右铭
         $username = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_name');
         $this->assign('name',$username);
         $this->assign('seatrt',$seatright);
		$per_id=Session::get('user_id');
		   $photo = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_photo');
        $this->assign('photo',$photo);
		$focus_id = Db::name('focus')
         ->where('focus_id',$per_id)
         ->column('foucsed_id');
         $condition['user_id']=['in',$focus_id];
		$list = UserModel::where($condition)->order('user_id','desc')->paginate(5);
		$this->assign('list',$list);
		$this->assign('count',count($list));
		//返回评论页面
		return view('detail2');
		return $this->fetch();

	}
	
	
 public function Delete($us_id)
 {
 	
 	
 	$per_id=Session::get('user_id');
  	
  	try{
  		$focus = Db::name('focus')
         ->where('focus_id', $per_id)->where('foucsed_id',$us_id)
         ->delete();
         $per           = UserModel::get($per_id);
        $per->focus_num -=1;
        $per->save();
        $other           = UserModel::get($us_id);
        $other->fans_num -=1;
        $other->save();
        
  		echo "<script type='text/javascript'>alert('取消成功！');parent.location.href='../../index/detail2/detail2';</script>";
  		
  	}
  	catch(Exception $e)
		{
			echo  "<script type='text/javascript'>alert('操作失败！');parent.location.href='../../index/detail2/detail2;</script>";
		}
 }
	
	
		
}
	
?>