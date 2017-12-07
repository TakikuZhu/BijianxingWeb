<?php
namespace app\library\controller;
use think\Db;
use think\Controller;
use think\Request;
use think\Session;
use app\library\model\UserSave as User;

class UserSave extends Controller{
	
	public function index(){
		
	}
	
	public function GetSession(Request $request){
		if( !Session::has('user_id') ) {
			return "False";
		}else{
			return "True";
		}
	}

	/**
	 * state : 区分模块一(0)和模块二(2) 
	 * uid : 用户id
	 * return : 当前用户符合条件的全部存储
	 */
	
	public function GetSave(Request $request){
		
			$state = $request->param('state');
			$user_id = Session::get('user_id');
			$User= new User; 
	    	$User=$User::where('save_state',$state) 
	    		->where('user_id',$user_id)
	    		->order('save_date','desc') 
	    		->select(); 
	    	
	    return json($User);
	}
	
	/**
	 * 
	 * 
	 */
	public function GetSaveById(Request $request){
		$save_id = $request->param("oid");
		$User = new User;
		$User = $User::where('save_id',$save_id) ->select();
		return json($User);
	}
	
	
	
	/**
	 * state : 区分模块一0和模块二1
	 * uid ： 用户id 
	 * name : 用户名
	 * 
	 */
	public function AddSave(Request $request){
		
		$state = $_POST['state'];
		$save_name = $_POST['name'];
		$save_url = $_POST['img'];
		$user_id = Session::get('user_id');
		$save_date = date('Y/m/d');
		$data = [
			'user_id' => $user_id,
			'save_name' => $save_name,
			'save_url' => $save_url,
			'save_date' => $save_date,
			'save_state' => $state
		];
		
		$row = Db::table('tb_user_save')
				->insert($data);
		
		return json($state);
//		return $save_url;
		
	}

	/**
	 * param oid :  字贴id
	 */
	
	public function DeleteSave(Request $request){
		
		$save_id = $request->param('oid');
		
		$row = Db::table('tb_user_save')
				->where('save_id',$save_id)
				->delete();
		return json($row);
	}
}
?>