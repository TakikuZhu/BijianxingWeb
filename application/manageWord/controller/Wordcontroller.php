<?php
namespace app\manageWord\controller;
use think\Controller;
use think\Request;
use app\manageWord\model\Word;

class Wordcontroller extends Controller
{
	//添加字
	public function addWordController(Request $request)
	{
		$word = new Word;
		
		$status = $word->addWord($request);
		if($status == "Word add fail")
		{
			return "<script>alert(\"添加生字失败\"); window.location.href = '../../manageWord/wordcontroller/test4';</script>";
		}
		else if($status == "Word is null")
		{
			return "<script>alert(\"未输入生字\"); window.location.href = '../../manageWord/wordcontroller/test4';</script>";
		}
		else if($status == "Word doesn't exist")
		{
			return "<script>alert(\"该字不存在\"); window.location.href = '../../manageWord/wordcontroller/test4';</script>";
		}
		else if($status == "One chinese word at a time")
		{
			return "<script>alert(\"每次仅能添加一个汉字\"); window.location.href = '../../manageWord/wordcontroller/test4';</script>";
		}
		else if($status == "Booktype or wordtype incorrect")
		{
			return "<script>alert(\"笔体、书体选择不正确\"); window.location.href = '../../manageWord/wordcontroller/test4';</script>";
		}
		else if($status == "Word add successfully, but not in new word table")
		{
			return "<script>alert(\"添加生字成功，版本、年级课程选择有无，未往生字表添加数据\"); window.location.href = '../../manageWord/wordcontroller/test4';</script>";
		}
		else if($status == "Word exists, unable to add")
		{
			return "<script>alert(\"该字已存在，无法添加\"); window.location.href = '../../manageWord/wordcontroller/test4';</script>";
		}
		else if($status == "New word exists, unable to add")
		{
			return "<script>alert(\"该字已添加，但该生字已存在，无法添加\"); window.location.href = '../../manageWord/wordcontroller/test4';</script>";
		}
		else
		{
			return "<script>alert(\"添加生字成功\"); window.location.href = '../../manageWord/wordcontroller/test4';</script>";
		}
	}
	//删除字
	public function deleteWordController(Request $request)
	{
		$word = new Word;
		$status = $word->deleteWord($request);
		return json($status);
	}
	//查询字信息
	public function searchWordController(Request $request)
	{
		$word = new Word;
		$wordInfo = $word->searchWord($request);
		return json($wordInfo);
	}
	//查询生字信息
	public function searchNewWordController(Request $request)
	{
		$word = new Word;
		$wordInfo = $word->searchNewWord($request);
		return json($wordInfo);
	}
	//批量添加字
	public function multiAddNewWordController(Request $request)
	{
		$word = new Word;
		$status = $word->multiAddNewWord($request);
		if($status == "Words are null")
		{
			return "<script>alert(\"字为空\"); window.location.href = '../../manageWord/wordcontroller/test11';</script>";
		}
		else if($status == "Multiple new words add successfully")
		{
			return "<script>alert(\"批量添加生字成功\"); window.location.href = '../../manageWord/wordcontroller/test11';</script>";
		}
		else if($status == "Booktype or wordtype is incorrect")
		{
			return "<script>alert(\"书体或笔体选择有误\"); window.location.href = '../../manageWord/wordcontroller/test11';</script>";
		}
		else
		{
			return "<script>alert(\"部分字已存在，无法添加\"); window.location.href = '../../manageWord/wordcontroller/test11';</script>";
		}
	}
	//删除生字
	public function deleteNewWordController(Request $request)
	{
		$word = new Word;
		$status = $word->deleteNewWord($request);
		if($status == "Word is null")
		{
			return "<script>alert(\"输入为空\"); window.location.href = '../../manageWord/wordcontroller/test12';</script>";
		}
		else if($status == "New word delete successfully")
		{
			return "<script>alert(\"生字删除成功\"); window.location.href = '../../manageWord/wordcontroller/test12';</script>";
		}
		else if($status == "Record with such condition no longer exist")
		{
			return "<script>alert(\"该类型的记录不存在\"); window.location.href = '../../manageWord/wordcontroller/test12';</script>";
		}
		else if($status == "Version or grade or course is incorrect")
		{
			return "<script>alert(\"版本、年级或课程选择不正确\"); window.location.href = '../../manageWord/wordcontroller/test12';</script>";
		}
		else if($status == "Some words no longer exist")
		{
			return "<script>alert(\"部分字不存在\"); window.location.href = '../../manageWord/wordcontroller/test12';</script>";
		}
		else
		{
			return "<script>alert(\"生字删除失败\"); window.location.href = '../../manageWord/wordcontroller/test12';</script>";
		}
	}
	//字图上传提交
	public function uploadPhotoController(Request $request)
	{
		$word = new Word;
		$status = $word->uploadWordPhoto($request);
		if($status == "Photo upload fail")
		{
			return "<script>alert(\"上传失败\"); window.location.href = '../../manageWord/wordcontroller/test6';</script>";
		}
		else if($status == "Word doesn't exist")
		{
			return "<script>alert(\"该字不存在\"); window.location.href = '../../manageWord/wordcontroller/test6';</script>";
		}
		else
		{
			return "<script>alert(\"上传成功\"); window.location.href = '../../manageWord/wordcontroller/test6';</script>";
		}
		
	}
	//视频上传提交
	public function uploadVideoController(Request $request)
	{
		$word = new Word;
		$status = $word->uploadVideo($request);
		if($status == "Video upload fail")
		{
			return "<script>alert(\"上传失败\"); window.location.href = '../../manageWord/wordcontroller/test8';</script>";
		}
		else if($status == "Word doesn't exist")
		{
			return "<script>alert(\"该字不存在\"); window.location.href = '../../manageWord/wordcontroller/test8';</script>";
		}
		else
		{
			return "<script>alert(\"上传成功\"); window.location.href = '../../manageWord/wordcontroller/test8';</script>";
		}
	}
	//说文解字上传
	public function uploadIntrController(Request $request)
	{
		$word = new Word;
		
		
		$status = $word->uploadIntr($request);
		if($status == "Intr upload fail")
		{
			return "<script>alert(\"上传失败\"); window.location.href = '../../manageWord/wordcontroller/test9';</script>";
		}
		else if($status == "Word doesn't exist")
		{
			return "<script>alert(\"该字不存在\"); window.location.href = '../../manageWord/wordcontroller/test9';</script>";
		}
		else
		{
			return "<script>alert(\"上传成功\"); window.location.href = '../../manageWord/wordcontroller/test9';</script>";
		}
	}
	//更新生字类型
	public function uploadKindController(Request $request)
	{
		$word = new Word;
		$status = $word->updateNewWord($request);
		if($status == "New word with new parameters exists")
		{
			return "<script>alert(\"新类型的生字已存在\"); window.location.href = '../../manageWord/wordcontroller/test10';</script>";
		}
		else if($status == "Old record of new word fail to fetch")
		{
			return "<script>alert(\"原类型的生字信息获取失败\"); window.location.href = '../../manageWord/wordcontroller/test10';</script>";
		}
		else if($status == "some parameters missed")
		{
			//return "<script>alert(\"版本、年级或课程选择不正确\"); window.location.href = '../../wordcontroller/test10';</script>";
			return "<script>alert(\"版本、年级或课程选择不正确\");</script>";
		}
		else if($status == "Update successfully")
		{
			return "<script>alert(\"上传成功\"); window.location.href = '../../manageWord/wordcontroller/test10';</script>";
		}
	}
	//添加字页面
	public function test4()
	{
		return view('addWord');
	}
	//删除字页面
	public function test5()
	{
		return view('deleteWord');
	}
	//更新字图片页面
	public function test6()
	{
		return view('updateWordPhoto');
	}
	//查询字页面
	public function test7()
	{
		return view('findWord');
	}
	//更新字视频页面
	public function test8()
	{
		return view('updateWordVideo');
	}
	//更新说文解字页面
	public function test9()
	{
		return view('updateIntr');
	}
	//更新生字类型页面
	public function test10()
	{
		return view('updateNewWord');
	}
	//删除生字页面
	public function test12()
	{
		return view('deleteNewWord');
	}
	//批量添加生字页面
	public function test11()
	{
		return view('multiAddNewWord');
	}
}
?>