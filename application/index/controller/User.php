<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\index\model\User as UserModel;
class User extends Controller
{
	public function mai(){
		//session_start();
		//session_destroy();
		return $this->fetch('./index');
	}
	private function createName(){
		$now= date('Y-m-d H:i:s', time());
		//echo $now;
		$array0=explode(' ',$now,2);
		//echo $array0[0].'->'.$array0[1];
		$array1=explode('-',$array0[0],3);
		$array2=explode(':',$array0[1],3);
		$string=$array1[0].$array1[1].$array1[2].$array2[0].$array2[1].$array2[2];
		//dump($string);
		return $string;
	}
	public function registerPage(){
		return $this->fetch('register');
	}
	public function register(Request $request){
		$phone=$request->param("accountr");
		$nickname=$request->param("nickname");
		$motto=$request->param("motto");
		$pwd=$request->param("pwdr");
		$u=UserModel::get(['user_phone'=>$phone]);
		//判断手机是否已注册
		if($u){
			return json("2");
		}
		$n=UserModel::get(['user_name'=>$nickname]);
		//判断昵称是否已用
		if($n){
			return json("3");
		}
		$user=new UserModel();
		$user->user_name=$nickname;
		$user->user_phone=$phone;
		$user->motto=$motto;
		$user->user_pwd=$pwd;
		$user->save();
		return json("1");
	}
	public function index(){
		return $this->fetch('./index');
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
			return json("1");
		}
	}
	public function load(){
		return $this->fetch();
	}
	
	public function security(){
		$this->check();
		return $this->fetch();
	}
	
	public function mine(){
		$this->check();
		$id=Session::get('user_id');
		$user=UserModel::get($id);
		$this->assign('user',$user);
		return $this->fetch();
	}
	public function getInfo(){
		$id=Session::get('user_id');
		$user=UserModel::get($id);
		$re=array();
		$re['head_img']=$user->user_photo;
		$re['nickname']=$user->user_name;
		$re['motto']=$user->motto;
		$re['phone']=$user->user_phone;
		return json($re);
	}
	public function saveInfo(){
		$this->check();
		$re=array(
				'nickname'=>1,
				'headimg'=>1
			);
		$file=$_FILES['display'];
		$nickname=$_REQUEST['nickname'];
		$motto=$_REQUEST['motto'];
		$id=Session::get('user_id');
		$user=UserModel::get($id);
		if($user->motto!=$motto){
			$user->motto=$motto;
		}
		
		if($user->user_name!=$nickname){
			$u=UserModel::get(['user_name'=>$nickname]);
			if(!$u){
				$user->user_name=$nickname;
				Session::set('user_name',$nickname);
			}
			else{
				$re['nickname']=0;
			}
		}
		$user->save();
		$r=$this->uploadPic($file,$user);
		if($r!=-1&&$r!=2){
			$re['headimg']=$r;
		}
		return json($re);
	}
	public function ext(){
		Session::clear();
		$this->redirect('User/mai');
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
			$arr=explode('.',$string);
			//设置文件名
			//$name=$string;
			$name=$user->user_id.$this->createName().'.'.$arr[count($arr)-1];
			$file2=$path.'/'.iconv("UTF-8", "gb2312", $name);
			$a=-1;
			$p=explode('.',$user->user_photo);
			$result=false;
			try{
				$result=move_uploaded_file($file['tmp_name'],$file2);
			}catch(Exception $e){
				$result=false;
			}
			if($result){
				//判断当前头像是否为默认头像
				if($p[0]!='default_head'){
					$file3=$path.'/'.$user->user_photo;
					if(file_exists($file3)){
						//删除原头像
						try{
							unlink($file3);
						}catch(Exception $e){	
						}
					}
				}
				$user->user_photo=$name;
				$user->save();
				Session::set('user_photo',$name);
				return 2;
			}
			else{
				return 0;
			}
		}
		return -1;
	}

	public function changePwd(){
		$this->check();
		$pwd0=$_REQUEST['pwd0'];
		$pwd=$_REQUEST['pwd'];
		$pwd2=$_REQUEST['pwd2'];
		$user=UserModel::get(Session::get('user_id'));
		if($user->user_pwd!=$pwd0){
			return json('0');
		}
		else{
			$user->user_pwd=$pwd;
			$user->save();
			return json('1');
		}
	}
	private function check(){
		if( !Session::has('user_id') ) {
			$this->error('请先登录！', url('index/User/index'));
		}
	}
}
?>