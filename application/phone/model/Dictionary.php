<?php 
namespace app\phone\model;
use think\Model;
use think\Db;
use think\Request;

//看图识字
//输入：字、字体、笔体
//输出：字形、书写视频、说文解字
/*
 * wordName:字
 * wordType:字体
 * bookType:书体
 */

class Dictionary extends Model
{
   
    
     public function getWordPhoto(Request $request)
    {
        $word_name = $request->param('wordname');
        $book_type = $request->param('booktype');
        $word_type = $request->param('wordtype');
        //$font = new WordModel;
        
        $word = Db::name('word_info')
        ->where('wi_name',$word_name)
        ->where('wi_bt_id', $book_type)
        ->where('wi_wt_id', $word_type)
        ->select();
        if(count($word))
        {
        	$wp_id = $word[0]["wi_wp_id"];
        	$word_photo = Db::name('word_photo')
            ->where('wp_url_id', $wp_id)
            ->select();
            if(count($word_photo))
            {
            	$wp_url=[];
            	$j = 0;
            	for($i=0; $i<count($word_photo); $i++){
            		$wp_url[$j] = $word_photo[$i]['wp_img_url'];
            		$j++;
            	}
            	
            	return $wp_url;
        }
        else
        {
            return "Word doesn't exist from getWord()";
        }
    }
}

public function getzjWordPhoto(Request $request)
    {
        $word_id = $request->param('photoid');
        
        
        $word = Db::name('word_zjphoto')
        ->where('zj_id',$word_id)
        ->select();
        if(count($word))
        {
        	$zj_url = $word[0]["zj_photo_url"];
        	$zj_word = $word[0]["zj_word"];
        	$zj_wordType = $word[0]["zj_wordType"];
        	$zj_belong = $word[0]["zj_belong"];
        	$zj_author = $word[0]["zj_author"];
        	$word_info = array("word_photo" => $zj_url,"zj_word" => $zj_word,
        	"zj_wordType" => $zj_wordType,"zj_belong" => $zj_belong,"zj_author" => $zj_author);
            return $word_info;
            //return $zj_url;

        	
            //$word_photo_url = $this->getWordPhoto($word);
            
            //$word_info = array("word_photo" => $word_photo_url);
            //return $word_photo_url;
        }
        else
        {
            return "Word doesn't exist from getWord()";
        }
    }
    
  
    

}
?>