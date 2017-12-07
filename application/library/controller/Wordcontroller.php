<?php
namespace app\library\controller;
use think\Controller;
use think\Request;
use app\library\model\Word;
use app\library\model\NewWord;

class Wordcontroller extends Controller
{
	//获取字信息
    public function getWordController(Request $request)
    {
        $word = new Word;
        $wordInfo = $word->getWord($request);
        return json($wordInfo);
    }
    //生字同步页面
    public function test5()
    {
    	return view('dict2');
    }
    //获取生字信息
    public function getNewWordController(Request $request)
    {
    	$word = new NewWord;
    	$newWord = $word->getNewWord($request);
    	return json($newWord);
    }
    public function test()
    {
        return view('demo1');
    }
    
    public function test4()
    {
        return view('dict1');
    }
    
    public function test10()
    {
    	$word = new Word;
    	$wordInfo = $word->getAllComment('啊');
    	return json($wordInfo);
    }
    public function test7()
    {
    	$word = new Word;
    	$reply = $word->getAllReply('啊');
    	return json($reply);
    }
    //添加分数
    public function addScoreController(Request $request)
    {
    	$word = new Word;
    	$scoreInfo = $word->addScore($request);
    	return $scoreInfo;
    }
    //获取二维码
    public function getQRCodeController(Request $request)
    {
    	$word = new Word;
    	$qrcode = $word->getQRcode($request);
    	return json($qrcode);
    }
    public function test8()
    {
    	return view('demo');
    }
    //添加评论
    public function addCommentController(Request $request)
    {
    	$word = new Word;
    	$commentInfo = $word->addComment($request);
    	return json($commentInfo);
    }
    //显示评论
    public function displayCommentController()
    {
    	$comment = new Comment;
    	$view = $comment->displaycomment("啊");
    	return $view;
    }
}
?>