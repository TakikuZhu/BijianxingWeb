<?php
//author:wangyinghao
//刘晨光 12.2:17.05 添加关注后添加私信功能
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\index\model\Index as UserModel;
use app\index\model\Focus as UserModel2;
use app\index\model\Collection as UserModel3;
use app\index\model\Message;
//粉丝
class Detail1 extends Controller
{
	public function Exist($us_id)
	{
		$per_id=Session::get('user_id');
		$user = Db::name('focus')
        ->where('focus_id', $per_id)->where('foucsed_id', $us_id)
        ->select();
        if($user==null)
        {
        	
        	return true;
        }
        else
        {
        	
        	
        	return false;
        }

	}
	public function Detail1()
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
	         
	         $countdynamic = Db::name('dynamic')
	         ->where('user_id', $per_id)
	         ->count();
	         $this->assign('dycount',$countdynamic);
	         $countcollect = Db::name('collect')
	         ->where('user_id', $per_id)
	         ->count();
	         $this->assign('clcount',$countcollect);
	         $seatright = Db::name('user')
         ->where('user_id', $per_id)
         ->value('motto');
//获取座右铭
         $username = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_name');
         $this->assign('name',$username);
         $this->assign('seatrt',$seatright);
				$this->assign('perId',$per_id);
				$focus_id = Db::name('focus')
				
	         ->where('foucsed_id',$per_id)
	         ->column('focus_id');
	            $photo = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_photo');
        $this->assign('photo',$photo);
	         $condition['user_id']=['in',$focus_id];
			$list = UserModel::where($condition)->order('user_id','desc')->paginate(5);
			$this->assign('list',$list);
			$this->assign('count',count($list));
		//返回评论页面
		return view('detail1');

	}
			public function Attention($us_id)
  {
  	 $per_id=Session::get('user_id');
	//判断用户是否登录
		if( !Session::has('user_id') ) {
			$this->error('请先登录！', url('index/User/index'));
		}
  	
  	if($this->Exist($us_id)==true&&$us_id!=$per_id)
  	{
  		$user           = new UserModel2;
        $user->focus_id = $per_id;
        $user->foucsed_id    = $us_id;
        $user->save();
        $per           = UserModel::get($per_id);
        $per->focus_num +=1;
        $per->save();
        $other           = UserModel::get($us_id);
        $other->fans_num +=1;
        $other->save();
  		echo "<script type='text/javascript'>alert('关注成功！');parent.location.href='../../index/index/index';</script>";
//		//cgl add start 添加私信通知
//		$Msg = new Message;
//		$Msg->topic = 2;		
//		$Msg->receiver_id=$us_id
//		$Msg->time=date("Y-m-d H:i:s");
//		$Msg->content=Session::get('user_name').'关注了你！';
//		$Msg->is_read=0;
//		$Msg->save();
//		//cgl add end
  	}
  	else{
  	
			echo  "<script type='text/javascript'>alert('您已经关注该作者，请勿重复关注！');</script>";
			
			}
		
  }
	
	
	
	
}
	
?>