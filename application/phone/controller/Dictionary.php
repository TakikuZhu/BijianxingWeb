<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;
use app\phone\model\Dictionary as DictionaryModel;
//define('APP_DEBUG',True);
//use app\index\controller\Index;
//看图识字
//输入：字、字体、笔体
//输出：字形、书写视频、说文解字

class Dictionary extends Controller
{
	
	public function dictPage()
    {
    	return $this->fetch('library_searchResult');
    	
        //return view('Dict');
    }
    
    public function getResult()
    {
    	return $this->fetch('character_library_singleWord');
    	
        //return view('Dict');
    }
    public function getWordController(Request $request)
    {
        $word = new DictionaryModel;
        $wordInfo = $word->getWordPhoto($request);
        return json($wordInfo);
        //return json($word->getWord($request));
    }
    
      public function getzjWordController(Request $request)
    {
        $word = new DictionaryModel;
        $wordInfo = $word->getzjWordPhoto($request);
        return json($wordInfo);
        
        //return json($word->getWord($request));
    }
    
    
}
?>