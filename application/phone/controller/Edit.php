<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\phone\model\Edit as EditModel;

class Edit extends Controller
{
	public function saveArticle(Request $request){
		$file=$_FILES['file'];
		$txt=$_REQUEST['article'];
		$theme=$_REQUEST['theme'];
//		return json($txt);
//		$txt = $request->param('article');
//		$theme = $request->param('theme');
		$id=Session::get("user_id");
//		$edit=EditModel::get(['user_id'=>$id]);
		$time=date("Y-m-d H:i:s");
		
		$edit=new EditModel();
		$edit->user_id = $id;
		$edit->content = $txt;
		$edit->theme = $theme;
		$edit->time = $time;
		$r=$this->uploadCover($file,$edit);
		if($r == 0){
				return json("3");
		}
		if(!$edit->save()){
			return json("1");
		}
		else{
			return json("2");
		}
	}
	
	//上传图片 返回值-1:没有上传图片；0:上传失败；2:上传成功
	private function uploadCover($file,$edit){
		//判断是否上传了图片
		if($file['name']!=''){
			$path=$_SERVER['DOCUMENT_ROOT'].'/static/upload/image';

			//若文件夹不存在创建文件夹
			if(!file_exists($path)){
				mkdir($path);
			}
			$string=$file['name'];
			$name=$string;
			$file2=$path.'/'.$name;
//			$p=explode('.',$edit->image);
//			return $file2;
			$result=move_uploaded_file($file['tmp_name'],$file2);
				if($result){
					$edit->image=$name;
					$edit->save();
					return 2;
				}
				else
					return 0;
		}
		return -1;
	}
//	public function saveArticle(Request $request){
//		$txt = $request->param('article');
//		$theme = $request->param('theme');
//		$id=Session::get("user_id");
//		$edit=EditModel::get(['user_id'=>$id]);
//		$time=date("Y-m-d H:i:s");
//		
//		$edit=new EditModel();
//		$edit->user_id = $id;
//		$edit->content = $txt;
//		$edit->theme = $theme;
//		$edit->time = $time;
//		if($edit->save()){
//			return json("1");
//		}
//		else{
//			return json("2");
//		}
//	}
}
?>