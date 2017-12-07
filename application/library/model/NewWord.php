<?php
namespace app\library\model;
use think\Model;
use think\Request;
use think\Db;
use app\library\Model\Word;

/*
 * version:版本如人教版
 * grade:年级
 * course:课程
 * newWord:生字
 */

class NewWord extends Model
{
    //获取生字
    public function getNewWord(Request $request)
    {
    	$version = $request->param('version');
    	$grade = $request->param('grade');
    	$course = $request->param('course');
        $wordList = Db::name('new_word')
        ->where('nw_material_type', $version)
        ->where('nw_grade', $grade)
        ->where('nw_course', $course)
        ->select();
        if(count($wordList))
        {
            $word = explode("@@", $wordList[0]['nw_text']);
            return $word;
        }
        else
        {
            return "Word doesn't exist";
        }
    }
    //获取生字信息
    public function getNewWordInfo($word_name, $book_type, $word_type)
    {
        $word = new Word;
        $word_info = $word->getWord($word_name, $book_type, $word_type);
        return $word_info;
    }
    //给视频打分
    public function newWordAddScore($word_name, $book_type, $word_type)
    {
        $word = new Word;
        $word->addScore($word_name, $book_type, $word_type);
    }
    //获取二维码
    public function newWordGetQRcode($page_url)
    {
        $word = new Word;
        $qrcode = $word->getQRcode($page_url);
        return $qrcode;
    }
    //添加评论
    public function newWordAddComment($word_name, $comment, $thumb_up, $user_id)
    {
        $word = new Word;
        $word->addComment($word_name, $comment, $thumb_up, $user_id);
    }
    //删除评论
    public function newWordDeleteComment($comment_id, $user_id)
    {
        $word = new Word;
        $word->deleteComment($comment_id, $user_id);
    }
    //添加回复
    public function newWordAddReply($word_name, $reply, $comment_id, $user_id)
    {
        $word = new Word;
        $word->addReply($word_name, $reply, $comment_id, $user_id);
    }
    //删除回复
    public function newWordDeleteReply($comment_id, $user_id)
    {
        $word = new Word;
        $word->deleteReply($comment_id, $user_id);
    }
    //更新评论点赞数
    public function newWordUpdateThumbUp($comment_id, $thumbup)
    {
        $word = new Word;
        $word->updateThumbUp($comment_id, $thumb_up);
    }
}
?>