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

class Word extends Model
{
   
    
     //获取字
    public function getWord(Request $request)
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
            $word_photo_url = $this->getWordPhoto($word);
            $word_video_url = $this->getWordVideo($word);
            $word_intr = explode("@@", $this->getWordIntr($word));
            $word_note = explode("@@", $this->getWordNote($word));
            //$word_score = $this->getWordScore($word);
            //$word_comment = $this->getAllComment($word_name);
            /* $word_info = array("word_photo" => $word_photo_url,
                "word_video" => $word_video_url, "word_intr" => $word_intr, 
                "word_note" => $word_note, "word_score" => $word_score, 
                "word_comment" => $word_comment); */
            $word_info = array("word_photo" => $word_photo_url,
                "word_video" => $word_video_url, "word_intr" => $word_intr,
                "word_note" => $word_note);
            return $word_info;
        }
        else
        {
            return "Word doesn't exist from getWord()";
        }
    }
    //获取字图url
    public function getWordPhoto($word)
    {
        if(count($word))
        {
            $wp_id = $word[0]["wi_wp_id"];
            //var_dump($word);
            $word_photo = Db::name('word_photo')
            ->where('wp_id', $wp_id)
            ->select();
            if(count($word_photo))
            {
                $wp_url = $word_photo[0]["wp_img_url"];
                //var_dump($word_photo);
                return $wp_url;
            }
            else
            {
                return "No photo for such word";
            }
        }
        else
        {
            return "Word doesn't exist";
        }
    }
    //获取视频url
    public function getWordVideo($word)
    {
        if(count($word))
        {
            $wv_id = $word[0]['wi_wv_id'];
            $word_video = Db::name('word_video')
            ->where('wv_id', $wv_id)
            ->select();
            if(count($word_video))
            {
                $wv_url = $word_video[0]['wv_video_url'];
                return $wv_url;
            }
            else
            {
                return "No video for such word";
            }
        }
        else
        {
            return "Word doesn't exist";
        }
    }
    //获取说文解字内容
    public function getWordIntr($word)
    {
        if(count($word))
        {
            $wi_id = $word[0]['wi_wi_id'];
            $word_intr = Db::name('word_intr')
            ->where('wi_id', $wi_id)
            ->select();
            if(count($word_intr))
            {
                $wi_dcp = $word_intr[0]['wi_dcp'];
                $wi_img_url = $word_intr[0]['wi_img_url'];
                return $wi_dcp. '@@'. $wi_img_url;
            }
            else
            {
                return "No intr for such word";
            }
        }
        else
        {
            return "Word doesn't exist";
        }
    }
    //获取书写要点
    public function getWordNote($word)
    {
        if(count($word))
        {
            $wn_id = $word[0]['wi_wn_id'];
            $word_note = Db::name('word_note')
            ->where('wn_id', $wn_id)
            ->select();
            if(count($word_note))
            {
                $wn_dcp = $word_note[0]['wn_dcp'];
                return $wn_dcp;
            }
            else
            {
                return "No dcp for such word";
            }
        }
        else
        {
            return "Word doesn't exist";
        }
        return $word_note;
    }
    
    
    
    //获取所有评论
    public function getAllComment($word_name)
    {
        $commentList = Db::name('comment')
        ->where('wc_name', $word_name)
        ->order('wc_date', 'desc')
        ->select();
        if(count($commentList))
        {
            $comments = array();
            foreach($commentList as $comment)
            {
                $commentReply = array();
                $comment_id = $comment['wc_id'];
                $reply = $this->getAllReplyByID($comment_id);
                array_push($commentReply, $comment, $reply);
                array_push($comments, $commentReply);
            }
            return $comments;
        }
        else
        {
            //var_dump("No comment on this word");
            return NULL;
        }
    }
    //添加评论
    public function addComment($word_name, $comment, $thumb_up, $user_id)
    {
        //$word_name = $request->param("wordName");
        $commentDate = date("Y-m-d H:i:s");
        Db::name('comment')
        ->insert(['wc_name' => $word_name,
            'wc_dcp' => $comment, 'wc_date' => $commentDate, 
            'wc_thumbup' => $thumb_up, 'wc_user_id' => $user_id]);
        var_dump("Add comment successfully");
    }
    //删除评论
    public function deleteComment($comment_id, $user_id)
    {
        Db::name('comment')
        ->where('wc_id', $comment_id)
        ->where('wc_user_id', $user_id)
        ->delete();
    }
    //获取该评论的所有回复
    public function getAllReplyByID($comment_id)
    {
        $replyList = Db::name('reply')
        ->where('wr_wc_id', $comment_id)
        ->order('wr_date', 'desc')
        ->select();
        if(count($replyList))
        {
            return $replyList;
        }
        else
        {
            var_dump("No reply on this comment");
        }
    }
    //添加回复
    public function addReply($word_name, $reply, $comment_id, $user_id)
    {
        $replyDate = date("Y-m-d H:i:s");
        Db::name('reply')->insert(['wr_name' => $word_name,
            'wr_dcp' => $reply, 'wr_date' => $replyDate, 
            'wr_wc_id' => $comment_id, 'wr_user_id' => $user_id]);
        var_dump("Add reply successfully");
    }
    //删除回复
    public function deleteReply($comment_id, $user_id)
    {
        Db::name('reply')
        ->where('wr_wc_id', $comment_id)
        ->where('wr_user_id', $user_id)
        ->delete();
    }
    //更新评论点赞数
    public function updateThumbUp($comment_id, $thumb_up)
    {
        $comment = Db::name('comment')
        ->where('wc_id', $comment_id)
        ->select();
        if(count($comment))
        {
            Db::name('comment')
            ->where('wc_id', $comment_id)
            ->update(['wc_thumbup' => ($comment[0]['wc_thumbup'] + $thumb_up)]);
        }
        else
        {
            var_dump("No comment to thumb up");
        }
    }
    
}
?>