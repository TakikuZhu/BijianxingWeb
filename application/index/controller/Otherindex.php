<?php
//author:wangyinghao
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\index\model\Index as UserModel;
use app\index\model\Dynamic as UserModel2;

class Otherindex extends Controller
{
	
	
	
	public function find_Attennum($per_id)
    {
    	
    	$count = Db::name('focus')
         ->where('focus', $per_id)
         ->count();
         $this->assign('atten',$count); 
    	
    }
    
    public function detail2()
	{
		return $this->fetch();
	}
	public function detail1()
	{
		$list = UserModel::all();
        return view('read',['list'=>$list]);
	}
    
    public function Otherindex($per_id)
    {
    	
//  $arr = Array('one', 'two', 'three');
//   echo json_encode($arr);
    	
//  	$data = Db::name('user')->find();
        $countcollect = Db::name('collect')
	         ->where('user_id', $per_id)
	         ->count();
	         $this->assign('clcount',$countcollect);
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
         //获取动态数量
         $seatright = Db::name('user')
         ->where('user_id', $per_id)
         ->value('motto');
         $photo = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_photo');
        $this->assign('photo',$photo);
//获取座右铭
         $username = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_name');
         $this->assign('name',$username);
         $this->assign('seatrt',$seatright);
         //取得关注数列表
         $focusId = Db::name('focus')
         ->where('focus_id', $per_id)
         ->column('foucsed_id');
         $dynamicId = Db::name('dynamic')
         ->where('user_id',$per_id)
         ->column('dynamic_id');
//->find();
         
		         $this->assign('fouId',$focusId);
		
			$condition['dynamic_id']=['in',$dynamicId];
			$list = UserModel2::where($condition)->order('dynamic_id','desc')->paginate(8);
			//      $list=UserModel2::get(['dynamic_id'=>'10023']);
					$this->assign('list',$list);
				
				$this->assign('perId',$per_id);
		return view('otherindex');
       //获取座右铭
        return $this->fetch();
      
       

  }
  public function indexAll()
    {
    	
    	$per_id=Session::get('user_id');
    	
    	
    	
//  $arr = Array('one', 'two', 'three');
//   echo json_encode($arr);
    	
//  	$data = Db::name('user')->find();
        $countcollect = Db::name('collect')
	         ->where('user_id', $per_id)
	         ->count();
	         $this->assign('clcount',$countcollect);
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
         //获取动态数量
         $seatright = Db::name('user')
         ->where('user_id', $per_id)
         ->value('motto');
         $photo = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_photo');
        $this->assign('photo',$photo);
//获取座右铭
         $username = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_name');
         $this->assign('name',$username);
         $this->assign('seatrt',$seatright);
         //取得关注数列表
         $focusId = Db::name('focus')
         ->where('focus_id', $per_id)
         ->column('foucsed_id');
         $dynamicId = Db::name('dynamic')
         ->where('user_id',$per_id)
         ->column('dynamic_id');
//->find();
         
		         $this->assign('fouId',$focusId);
		
			$condition['dynamic_id']=['in',$dynamicId];
			$list = UserModel2::paginate(8);
			//      $list=UserModel2::get(['dynamic_id'=>'10023']);
			$this->assign('list',$list);
				
				$this->assign('perId',$per_id);
		return view('index');
       //获取座右铭
        return $this->fetch();

  }
  
    public function indexCollect()
    {
    	
    	$per_id=Session::get('user_id');
    	
    	
    	
//  $arr = Array('one', 'two', 'three');
//   echo json_encode($arr);
    	
//  	$data = Db::name('user')->find();
        $countcollect = Db::name('collect')
	         ->where('user_id', $per_id)
	         ->count();
	         $this->assign('clcount',$countcollect);
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
         //获取动态数量
         $seatright = Db::name('user')
         ->where('user_id', $per_id)
         ->value('motto');
         $photo = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_photo');
        $this->assign('photo',$photo);
//获取座右铭
         $username = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_name');
         $this->assign('name',$username);
         $this->assign('seatrt',$seatright);
         //取得关注数列表
         $focusId = Db::name('focus')
         ->where('focus_id', $per_id)
         ->column('foucsed_id');
         $dynamicId = Db::name('collect')
         ->where('user_id',$per_id)
         ->column('dynamic_id');
//->find();
         
		         $this->assign('fouId',$focusId);
		
			$condition['dynamic_id']=['in',$dynamicId];
			$list = UserModel2::where($condition)->order('dynamic_id','desc')->paginate(8);
			//      $list=UserModel2::get(['dynamic_id'=>'10023']);
			$this->assign('list',$list);
				
				$this->assign('perId',$per_id);
		return view('otherindex');
       //获取座右铭
        return $this->fetch();

  }
  
  public  function find_User($per_id)
  {
  	$result = Db::name('user')
    ->where('user_id', $per_id)
    ->find();
    dump($result);
  }
  public function Attention(Request $request)
  {
  	$price =$request->param("price");
  	
  	try{
  		echo "<script type='text/javascript'>alert('关注成功！');parent.location.href='../../index/index/index';</script>";
  		
  	}
  	catch(Exception $e)
		{
			echo  "<script type='text/javascript'>alert('您不能关注自己，并请勿重复关注！');</script>";
		}
  }
    
    public function find_Fansnum($per_id)
    {
    	$count = Db::name('focus')
    ->where('focused_id', $per_id)
    ->count();
     dump($count);   
    }
    
    
    public function find_Fans($per_id)
    {
    	$result = Db::name('focus')
       ->where('focused_id', $per_id)
       ->find();
       dump($result);
    }
   
    
	public function homepage()
	{
		return view('/index');
	}
   

    

}
?>

<?php

?>