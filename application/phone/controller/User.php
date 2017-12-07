<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\phone\model\User as UserModel;


class User extends Controller
{
	
    public function loginPage()
    {
		return $this->fetch('./login');
    }
    
    public function getRegister(){
    	return $this->fetch('./register');
    }
    
    public function getRegister2(){
    	return $this->fetch('./register2');
    }
    public function editPwd(){
    	return $this->fetch('./user/editPwd');
    }
    
    public function register(Request $request){
    	$phone=$request->param('phone');
		$pwd=$request->param('pwd');
		//判断手机是否已注册
		$u=UserModel::get(['user_phone'=>$phone]);
		if($u){
			return json("2");
		}
		//未注册时插入数据库
		$user=new UserModel();
		$user->user_phone=$phone;
		$user->user_pwd=$pwd;
//		$user->motto="2";
		if($user->save()){
			Session::set('user_phone',$phone);
			return json("1");
		}
		else{
			return json("0");
		}
		
	}
    
    public function register2(Request $request){
    	$file=$_FILES['file'];
		$nickname=$_REQUEST['nickname'];
		$motto=$_REQUEST['motto'];
		$u=UserModel::get(['user_name'=>$nickname]);
		if($u){
			return json("2");
		}
		if(Session::get("user_phone")){
			$phone = Session::get("user_phone");
			$user=UserModel::get(['user_phone'=>$phone]);
			$r=$this->uploadPic($file,$user);
			if($r == 0){
				return json("4");
			}
			$user->user_name=$nickname;
			$user->motto=$motto;
			$user->save();
			return json("1");
		}else{
			return json("3");
		}
    }
    
    public function login(Request $request){
		$phone=$request->param('account');
		$pwd=$request->param('pwd');
		$user=UserModel::get(['user_phone'=>$phone]);
		if(!$user){
			return json("2");
		}
		else if($user->user_pwd!=$pwd){
			return json("3");
		}
		else if($user->user_status!='正常')
		{
			return json("4");
		}
		else{
			Session::set('user_name',$user->user_name);
			Session::set('user_photo',$user->user_photo);
			Session::set('user_id',$user->user_id);
			Session::set('user_phone', $user->user_phone);
			return json("1");
		}
	}
	
	//修改头像
	public function editHead(Request $request){
		$photo=$_FILES['file'];
		if(Session::get("user_phone")){
			$phone = Session::get("user_phone");
			$user=UserModel::get(['user_phone'=>$phone]);
			
			$r=$this->uploadPic($photo,$user);
			if($r == 0){
				return json("2");
			}
			return json("1");
		}else{
			return json("2");
		}
	}
	
	//上传头像 返回值-1:没有上传图片；0:上传失败；2:上传成功
	private function uploadPic($file,$user){
		//判断是否上传了图片
		if($file['name']!=''){
			$path=$_SERVER['DOCUMENT_ROOT'].'/static/user/headimg';

			//若文件夹不存在创建文件夹
			if(!file_exists($path)){
				mkdir($path);
			}
			$string=$file['name'];
			//$array=explode('.',$string);
			//$type=$array[count($array)-1];
			//传入图片的新名字
			//$name=$user->user_id.'.'.$type;
			$name=$string;
			$file2=$path.'/'.$name;
			$a=-1;
			$p=explode('.',$user->user_photo);
//			return $file2;
			//判断当前头像是否为默认头像
			if($p[0]!='default_head'){
				$file3=$path.'/'.$user->user_photo;
				if(file_exists($file3)){
					//删除原头像
					$r=unlink($file3);
					if($r)
						$a=0;//删除成功
					else
						$a=1;//删除失败
				}
			}
			if($a==-1||$a==0){
				$result=move_uploaded_file($file['tmp_name'],$file2);
				if($result){
					$user->user_photo=$name;
					$user->save();
					Session::set('user_photo',$name);
					return 2;
				}
				else
					return 0;
			}
			else{
				return 0;
			}
		}
		return -1;
	}
	
	//修改密码  返回值1：修改成功；2修改失败
	public function changePwd(Request $request){
		$pwd=$request->param('pwd');
		if(Session::get("user_phone")){
			$phone = Session::get("user_phone");
			$user=UserModel::get(['user_phone'=>$phone]);
			
			$user->user_pwd=$pwd;
			$user->save();
			return json("1");
		}else{
			return json("2");
		}
	}
	
	//检查登录
	public function checkLogin(){
		if( !Session::has('user_id') ) {
			return json("0");
		}else{
			return json("1");
		}
	}
	
	public function getInfo(){
		if(!Session::has('user_id') ){
			return json("0");
		}else{
			return json("0");
		}
	}
}

