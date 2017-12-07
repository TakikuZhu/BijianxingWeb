<?php
//author:linsongping
namespace app\index\controller;
use think\Controller;
use app\index\model\Admin as AdminModel;
use app\index\model\User as UserModel;
use app\index\model\Dynamics as DynamicModel;
use app\index\model\Comment as CommentsModel;
use app\index\model\Message as MsgModel;
use think\Db;
use think\Session;
class Admin extends Controller
{
	public function admin(){
		//dump(config('database'));
		//$res = Db::query("select * from tb_admin");
		//dump($res);
		// $ad = model("Admin");

		// $res = $ad::get(8080);
		//$res = AdminModel::get(8080);
		//$res = $res->toArray();
		// $res = AdminModel::where("admin_id",8080)
		// 	->field("admin_pwd")
		// 	->find();->select();
		// $res = AdminModel::all(function($query){
		// 	$query->where("admin_pwd","=","admin");
		// });
		$res = AdminModel::where("admin_pwd","admin")
		->field("admin_pwd")
		->paginate(2);
			//dump($res);
		$this->assign('res',$res);
		return $this->fetch('admin');

		// foreach ($res as $val) {
		// 	$val = $val->toArray();
		// 	dump($val);
		// }
		
	}
	public function checkAdmin(){
		
		$adminid = $_GET['id'];
		$pwd = $_GET['pwd'];
		$res = AdminModel::where("admin_id",$adminid)
		->find();
		if($res){
			if($res->admin_pwd == $pwd){
				Session::set('admin',$adminid);
			}else{
				return 101;
			}
		}else{
			return 100;
		}
		

	}
	public function logout(){

		Session::pull('admin');
		return $this->fetch('adminLogin');
	}
	public function getUser(){

		$res = UserModel::where('user_status','>=','0')
		->field("user_id,user_name,user_status")
		->order('user_status', 'asc')
		->select();

		$this->assign('res',$res);
		return $this->fetch('admin');


	}
	public function getPage(){
		$res = Session::get('admin');
		if($res){
			$this->assign('res',$res);
			return $this->fetch('admin');
		}else{
			return $this->fetch('adminLogin');
		}

	}
	public function getLoginPage(){

		return $this->fetch('adminLogin');


	}
	public function addAdmin(){
		$adminid = $_GET['id'];
		$pwd = $_GET['pwd'];
		$res = AdminModel::where("admin_id",$adminid)
		->find();
		if($res){
			return false;
		}else{
			$admin = new AdminModel;
			$admin->admin_id = $adminid;
			$admin->admin_pwd = $pwd;
			if($admin->save()>0){
				return true;
			}else{
				return false;
			}
		}

	}
	public function editAdmin(){
		$adminid = $_GET['id'];
		$oldpwd = $_GET['oldpwd'];
		$newpwd = $_GET['newpwd'];
		$res = AdminModel::where("admin_id",$adminid)
		->find();
		if($res){
			if($res->admin_pwd == $oldpwd){
				$res->admin_id = $adminid;
				$res->admin_pwd = $newpwd;
				if($res->save()>0){
					return "修改成功";
				}else{
					return "没有进行修改";
				}
			}else{
				return "当前密码错误";
			}
		}else{
			return "当前账户不存在";
		}
		
	}
	public function getAllAdmin(){
		$res = AdminModel::where('admin_id','>','0')
		->field("admin_id")
		->select();

		if($res){
			return $res;
		}else{
			return false;
		}


	}
	public function getAdmin($admin){
		$res = AdminModel::where('admin_id','like','%'.$admin.'%')
		->field("admin_id")
		->select();

		if($res){
			return $res;
		}else{
			return false;
		}


	}
	public function getAllUser($method){
		if($method==1){
			$res = UserModel::where('user_status','>','0')
			->field("user_id,user_name,user_status,fans_num")
			->order('user_status', 'asc')
			->select();
		}
		else{
			$res = UserModel::where('user_status','>','0')
			->field("user_id,user_name,user_status,fans_num")
			->order('fans_num', 'desc')
			->select();
		}

		if($res){
			return $res;
		}else{
			return false;
		}


	}

	public function getUserByName($method=1){
		$name = $_GET['da'];
		if($method==1){
			$res = UserModel::where('user_name','like','%'.$name.'%')
			->field("user_id,user_name,user_status,fans_num")
			->order('user_status', 'asc')
			->select();
		}
		else if($method==2){
			$res = UserModel::where('user_name','like','%'.$name.'%')
			->field("user_id,user_name,user_status,fans_num")
			->order('fans_num', 'desc')
			->select();
		}
		else{
			$res = UserModel::where('user_name',$name)
			->field("user_id,user_name,user_status,fans_num")
			->select();
		}
		if($res){
			return $res;
		}else{
			return false;
		}


	}
	public function getUserById($id){

		$res = UserModel::where('user_id',$id)
		->field("user_id,user_name,user_status")
		->select();
		if($res){
			return $res;
		}else{
			return false;
		}


	}
	public function getDynamicById($id){


		$res = Db::view('tb_User','user_id,user_name')
		->view('tb_Dynamic','dynamic_id','tb_Dynamic.user_id=tb_User.user_id')
		->where("dynamic_id",$id)
		->select();

		if($res){
			return $res;
		}else{
			return false;
		}


	}
	public function getDynamicByUserId($id){


		$res = Db::view('tb_User','user_id,user_name')
		->view('tb_Dynamic','dynamic_id','tb_Dynamic.user_id=tb_User.user_id')
		->where("user_id",$id)
		->select();

		if($res){
			return $res;
		}else{
			return false;
		}
	}
	public function getDynamicByName($method=1){
		$name = $_GET['da'];

		if($method==1){
			$res = Db::view('tb_User','user_id,user_name')
			->view('tb_Dynamic','dynamic_id,theme,time','tb_Dynamic.user_id=tb_User.user_id')
			->where("user_name",$name)
			->order('time', 'desc')
			->select();
		}
		else{
			$res = Db::view('tb_User','user_id,user_name')
			->view('tb_Dynamic','dynamic_id,theme,time','tb_Dynamic.user_id=tb_User.user_id')
			->where("user_name",$name)
			->order('time', 'desc')
			->select();
		}

		if($res){
			return $res;
		}else{
			return false;
		}
	}
	public function getDynamicByWords($method=1){
		$words = $_GET['da'];

		if($method==1){
			$res = Db::view('tb_User','user_id,user_name')
			->view('tb_Dynamic','dynamic_id,theme,time','tb_Dynamic.user_id=tb_User.user_id')
			->where('content','like','%'.$words.'%')
			->order('time', 'desc')
			->select();
		}
		else{
			$res = Db::view('tb_User','user_id,user_name')
			->view('tb_Dynamic','dynamic_id,theme,time','tb_Dynamic.user_id=tb_User.user_id')
			->where('content','like','%'.$words.'%')
			->order('user_name', 'desc')
			->select();
		}

		if($res){
			return $res;
		}else{
			return false;
		}
		// dump($res);
	}

	public function getCommentsByWords($method=1){

		$words = $_GET['da'];
		if($method==1){
			$res = Db::table('tb_dynamic_comment')
			->alias('a')
			->join('tb_user w','a.sender_id = w.user_id')
			->join('tb_user c','a.receiver_id = c.user_id')
			->join('tb_dynamic d','a.dynamic_id = d.dynamic_id')
			->where('a.content','like','%'.$words.'%')
			->field("comment_id,a.dynamic_id as cdynamic,a.content as ccontent,theme,a.time as ctime,w.user_name as sender_name,c.user_name as receiver_name")
			->order('a.time', 'desc')
			->select();
		}
		else if($method==2){
			$res = Db::table('tb_dynamic_comment')
			->alias('a')
			->join('tb_user w','a.sender_id = w.user_id')
			->join('tb_user c','a.receiver_id = c.user_id')
			->join('tb_dynamic d','a.dynamic_id = d.dynamic_id')
			->where('a.content','like','%'.$words.'%')
			->field("comment_id,a.dynamic_id as cdynamic,a.content as ccontent,theme,a.time as ctime,w.user_name as sender_name,c.user_name as receiver_name")
			->order('sender_name', 'desc')
			->select();
		}else if($method==12){
			$res = Db::table('tb_dynamic_comment')
			->alias('a')
			->join('tb_user w','a.sender_id = w.user_id')
			->join('tb_dynamic d','a.dynamic_id = d.dynamic_id')
			->where("a.receiver_id",'NULL')
			->where('a.content','like','%'.$words.'%')
			->field("comment_id,a.dynamic_id as cdynamic,a.content as ccontent,theme,a.time as ctime,w.user_name as sender_name")
			->order('a.time', 'desc')
			->select();
		}else{
			$res = Db::table('tb_dynamic_comment')
			->alias('a')
			->join('tb_user w','a.sender_id = w.user_id')
			->join('tb_dynamic d','a.dynamic_id = d.dynamic_id')
			->where("a.receiver_id",'NULL')
			->where('a.content','like','%'.$words.'%')
			->field("comment_id,a.dynamic_id as cdynamic,a.content as ccontent,theme,a.time as ctime,w.user_name as sender_name")
			->order('sender_name', 'desc')
			->select();
		}

		if($res){
			return $res;
		}else{
			return false;
		}
		// dump($res);
	}

	public function deleteSelectDynamic(){
		$data = $_POST['da'];
		foreach ($data as $value) {
			$dynamic = DynamicModel::get($value["dyid"]);
			$dynamic->delete();
			
		}

	}
	public function getCommentsByName($method=1){

		$name = $_GET['da'];
		if($method==1){
			$res = Db::table('tb_dynamic_comment')
			->alias('a')
			->join('tb_user w','a.sender_id = w.user_id')
			->join('tb_user c','a.receiver_id = c.user_id')
			->join('tb_dynamic d','a.dynamic_id = d.dynamic_id')
			->where("w.user_name",$name)
			->field("comment_id,a.dynamic_id as cdynamic,a.content as ccontent,theme,a.time as ctime,w.user_name as sender_name,c.user_name as receiver_name")
			->order('a.time', 'desc')
			->select();
		}
		else{
			$res = Db::table('tb_dynamic_comment')
			->alias('a')
			->join('tb_user w','a.sender_id = w.user_id')
			->join('tb_dynamic d','a.dynamic_id = d.dynamic_id')
			->where("w.user_name",$name)
			->where("a.receiver_id",'NULL')
			->field("comment_id,a.dynamic_id as cdynamic,a.content as ccontent,theme,a.time as ctime,w.user_name as sender_name")
			->order('a.time', 'desc')
			->select();
		}
		if($res){
			return $res;
		}else{
			return false;
		}
	}


	public function getCommentsByUserId($id){


		$res = CommentsModel::where("sender_id",$id)
		->field("dynamic,sender_id,receiver_id,comments_id")
		->select();

		if($res){
			return $res;
		}else{
			return false;
		}


	}
	public function getCommentsByDynamicId($id){

		$res = CommentsModel::where("dynamic",$id)
		->field("dynamic,sender_id,receiver_id,comments_id")
		->select();

		if($res){
			return $res;
		}else{
			return false;
		}


	}

	// public function userBan($id){
	// 	$user = UserModel::get($id);
	// 	if($user->user_status =="正常" ){
	// 		$user->user_status     = 3;
	// 		$user->save();
	// 		return "禁用成功";
	// 	}else{
	// 		return "该用户状态为非正常";
	// 	}
	// }
	// public function userUnban($id){
	// 	$user = UserModel::get($id);
	// 	$user->user_status     = 1;
	// 	$user->save();
	// 	return "解禁成功";
	// }

	public function userBan(){
		$name = $_POST['da'];
		$user = UserModel::where('user_name',$name)
		->find();
		if($user->user_status =="正常" ){
			$user->user_status     = 3;
			$user->save();
			return "禁用成功";
		}else{
			return "该用户状态为非正常";
		}
	}
	public function userUnban(){
		$name = $_POST['da'];
		$user = UserModel::where('user_name',$name)
		->find();
		$user->user_status     = 1;
		$user->save();
		return "解禁成功";
	}
	// public function userIce($id){
	// 	$user = UserModel::get($id);
	// 	if($user->user_status =="正常" ){
	// 		$user->user_status  = 2;
	// 		$user->save();
	// 		return "冻结成功";
	// 	}else{
	// 		return "该用户状态为非正常";
	// 	}
	// }
	// public function userUnice($id){
	// 	$user = UserModel::get($id);

	// 	$user->user_status     = 1;
	// 	$user->save();
	// 	return "解冻成功";
	// }
	public function userIce(){
		$name = $_POST['da'];
		$user = UserModel::where('user_name',$name)
		->find();
		if($user->user_status =="正常" ){
			$user->user_status  = 2;
			$user->save();
			return "冻结成功";
		}else{
			return "该用户状态为非正常";
		}
	}
	public function userUnice(){
		$name = $_POST['da'];
		$user = UserModel::where('user_name',$name)
		->find();

		$user->user_status     = 1;
		$user->save();
		return "解冻成功";
	}
	// public function userDelete($id){

	// 	$user = UserModel::get($id);
	// 	$user->delete();
	// 	return "删除成功";
	// }
	public function userDelete(){
		$name = $_POST['da'];
		$user = UserModel::where('user_name',$name)
		->find();
		$user->delete();
		return "删除成功";
	}


	public function dynamicDelete($id){
		$dynamic = DynamicModel::get($id);
		$dynamic->delete();
		return "删除成功";
	}
	public function adminDelete($id){
		$admin = AdminModel::get($id);
		$admin->delete();
		return "删除成功";
	}
	public function messageDelete($id){
		$msg = MsgModel::get($id);
		$msg->delete();
		return "删除成功";
	}
	public function commentsDelete($id){
		$comments = CommentsModel::get($id);
		$comments->delete();
		return "删除成功";
	}
	public function deleteSelectComments(){
		$data = $_POST['da'];
		foreach ($data as $value) {
			$comments = CommentsModel::get($value["coid"]);
			$comments->delete();
			
		}

	}

	public function getAttentionByName(){
		$name = $_GET['da'];
		if($name=='1'||$name=='2'||$name=='3'){
			$res = Db::view('tb_User','user_id,user_name')
			->view('tb_Msg','msg_id,content,time','tb_Msg.receiver_id=tb_User.user_id')
			->where("receiver_id",$name)
			->where("topic",'=',1)
			->where('sender_id',"NULL")
			->order('time', 'desc')
			->select();

		}else{
			$res = Db::view('tb_User','user_id,user_name')
			->view('tb_Msg','msg_id,content,time','tb_Msg.receiver_id=tb_User.user_id')
			->where('sender_id',"NULL")
			->where("topic",'=',1)
			->where("user_name",$name)
			->order('time', 'desc')
			->select();
		}


		if($res){
			return $res;
		}else{
			return false;
		}
		 // dump($res);
	}

	public function getAttentionByDate($date){

		
		$res = Db::view('tb_User','user_id,user_name')
		->view('tb_Msg','msg_id,content,time','tb_Msg.receiver_id=tb_User.user_id')
		->where("topic",'=',1)
		->where("time",'like','%'.$date.'%')
		->where('sender_id',"NULL")
		->order('receiver_id', 'asc')
		->select();
		if($res){
			return $res;
		}else{
			return false;
		}
		// dump($res);
	}
	public function deleteSelectAttention(){
		$data = $_POST['da'];
		foreach ($data as $value) {
			$msg = MsgModel::get($value["atid"]);
			$msg->delete();
			
		}

	}
	public function getGroupAttentionByDate($date){

		$res = MsgModel::where('topic', 0 )
		->where("time",'like','%'.$date.'%')
		->select();
		if($res){
			return $res;
		}else{
			return false;
		}
	}
	public function getGroupAttention(){
		
		$res = MsgModel::where('topic', 0 )
		->select();
		if($res){
			return $res;
		}else{
			return false;
		}
	}
	public function addGroupMessage(){
		$content = $_GET['da'];
		$msg = new MsgModel;
		$msg->topic = 0;
		$msg->time=date("Y-m-d H:i:s");
		$msg->content= $content;
		$msg->is_read=0;
		if($msg->save()>0){
			return true;
		}else{
			return false;
		}

	}
	public function addPersonalMessage(){
		$data = $_POST['da'];
		$content = $_POST['con'];
		foreach ($data as $value) {
			$msg = new MsgModel;
			$msg->topic = 1;
			$msg->time=date("Y-m-d H:i:s");
			$msg->content= $content;
			$msg->receiver_id= $value["userid"];
			$msg->is_read=0;
			if($msg->save()<=0){
				return false;
			}
		}
		return true;
		

	}
	


}
?>