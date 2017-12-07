<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;
use app\phone\model\Unfamiliar as UnfamiliarModel;
//define('APP_DEBUG',True);
//use app\index\controller\Index;
//看图识字
//输入：字、字体、笔体
//输出：字形、书写视频、说文解字

class Unfamiliar extends Controller
{
	
	public function dictPage()
    {
    	return $this->fetch('flashcard_result');
        //return view('Dict');
    }
    
    public function getResult()
    {
    	return $this->fetch('unflashcard_single');
        //return view('Dict');
    }
    public function getWordController(Request $request)
    {
        $word = new UnfamiliarModel;
        $wordInfo = $word->getWord($request);
        return json($wordInfo);
        //return json($word->getWord($request));
    }
    
    
}
?>