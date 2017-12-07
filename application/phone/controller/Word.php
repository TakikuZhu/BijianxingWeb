<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;
use app\phone\model\Word as WordModel;
//define('APP_DEBUG',True);
//use app\index\controller\Index;
//看图识字
//输入：字、字体、笔体
//输出：字形、书写视频、说文解字

class Word extends Controller
{
	
	public function dictPage()
    {
    	return $this->fetch('library');
        //return view('Dict');
    }
    
    public function getResult()
    {
    	return $this->fetch('flashcard_single');
        //return view('Dict');
    }
    public function getWordController(Request $request)
    {
        $word = new WordModel;
        $wordInfo = $word->getWord($request);
        return json($wordInfo);
        //return json($word->getWord($request));
    }
    
    
}
?>