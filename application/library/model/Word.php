<?php 
namespace app\library\model;
use think\Model;
use think\Db;
use think\Request;

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
        $word_comment_id = array();
        $word = Db::name('word_info')
        ->where('wi_name', $word_name)
        ->where('wi_bt_id', $book_type)
        ->where('wi_wt_id', $word_type)
        ->select();
        if(count($word))
        {
            $word_photo_url = $this->getWordPhoto($word);
            $word_video_url = $this->getWordVideo($word);
            $word_intr = explode("@@", $this->getWordIntr($word));
            $word_note = explode("@@", $this->getWordNote($word));
            $word_score = $this->getWordScore($word);
            $word_comment = $this->getAllComment($word_name);
            /* for(int i = 0; i < $word_comment.length; i++)
            {
            	array_push($word_comment_id, $word_comment[i]['wc_id']);
            } */
            $word_reply = $this->getAllReply($word_name);
            $word_info = array("word_photo" => $word_photo_url,
                "word_video" => $word_video_url, "word_intr" => $word_intr, 
                "word_note" => $word_note, "word_score" => $word_score, 
                "word_comment" => $word_comment);
            /* $word_info = array("word_photo" => $word_photo_url,
                "word_video" => $word_video_url, "word_intr" => $word_intr,
                "word_note" => $word_note, "word_score" => $word_score); */
            return $word_info;
        }
        else
        {
            return "Word doesn't exist";
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
    //获取字的得分
    public function getWordScore($word)
    {
        if(count($word))
        {
            $ws_id = $word[0]['wi_wv_id'];
            $word_score_list = Db::name('score')
            ->where('score_wv_id', $ws_id)
            ->column('score_num');
            if(count($word_score_list))
            {
                $word_score = round(array_sum($word_score_list) / count($word_score_list));
                return $word_score;
            }
            else
            {
                return "No score for such word";
            }
        }
        else
        {
            return "Word doesn't exist";
        }
    }
    //给视频打分
    public function addScore(Request $request)
    {
    	$word_name = $request->param('wordname');
    	$book_type = $request->param('booktype');
    	$word_type = $request->param('wordtype');
    	$score = $request->param('score');
    	$user_id = $request->param('userid');
        $word = Db::name('word_info')
        ->where('wi_name', $word_name)
        ->where('wi_bt_id', $book_type)
        ->where('wi_wt_id', $word_type)
        ->select();
        if(count($word))
        {
            $wv_id = $word[0]['wi_wv_id'];
            $u_id = Db::name('score')
            ->where('score_wv_id', $wv_id)
            ->where('score_user_id', $user_id)
            ->select();
            if(count($u_id))
            {
                return "User has added score to this video";
            }
            else
            {
                $score_date = date("Y-m-d H:i:s");
                Db::name('score')
                ->insert(['score_wv_id' => $wv_id, 'score_num' => $score, 
                    'score_date' => $score_date, 'score_user_id' => $user_id]);
                return "User add score successfully";
            }
        }
        else
        {
            return "Word doesn't exist";
        }
    }
    //获取二维码
    public function getQRcode(Request $request)
    //public function getQRcode($page_url)
    {
    	$page_url = $request->param('pageurl');
    	//$qrcodeDate = date("Y-m-d H:i:s");
    	$fileName = 'qrcode.png';
    	//$path = './static/libraryResources/img/'.$fileName;
        Vendor('phpqrcode.phpqrcode');
        //容错级别
        //生成图片大小
        $errorCorrectionLevel = 3;
        $matrixPointSize = 2;
        //生成二维码图片
        ob_end_clean();
        $object = new \QRcode();
        //第二个参数false的意思是不生成图片文件，如果你写上‘picture.png’则会在根目录下生成一个png格式的图片文件
//         if(file_exists('/bijianxing/public/static/libraryResources/img/qrcode.png'))
//         {
//         	unlink('./static/libraryResources/img/qrcode.png');
//         }
$object->png($page_url, './static/libraryResources/img/qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2, true); 
return "../../static/libraryResources/img/".$fileName;

    }
    //获取所有评论（带回复）
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
                $commentUserInfo = $this->getNamePhotoById($comment['wc_user_id']);
                $comment['wc_user_name'] = $commentUserInfo[0];
                $comment['wc_user_photo'] = $commentUserInfo[1];
                $reply = $this->getAllReplyByID($comment_id);
                array_push($commentReply, $comment, $reply);
                array_push($comments, $commentReply);
            }
            return $comments;
        }
        else
        {
            //var_dump();
        	return "No comment on this word";
        }
    }
    /* //获取所有评论（不带回复）
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
    			$comment_id = $comment['wc_id'];
    			$commentUserInfo = $this->getNamePhotoById($comment['wc_user_id']);
    			$comment['wc_user_name'] = $commentUserInfo[0];
    			$comment['wc_user_photo'] = $commentUserInfo[1];
    			array_push($comments, $comment);
    		}
    		return $comments;
    	}
    	else
    	{
    		return "No comment on this word";
    	}
    } */
    //添加评论
    public function addComment(Request $request)
    {
    	$word_name = $request->param("wordname");
    	$comment = $request->param("comment");
    	$thumb_up = $request->param("thumbup");
    	$user_id = $request->param("userid");
        $commentDate = date("Y-m-d H:i:s");
        Db::name('comment')
        ->insert(['wc_name' => $word_name,
            'wc_dcp' => $comment, 'wc_date' => $commentDate, 
            'wc_thumbup' => $thumb_up, 'wc_user_id' => $user_id]);
        return "Add comment successfully";
    }
    //删除评论
    public function deleteComment($comment_id, $user_id)
    {
        Db::name('comment')
        ->where('wc_id', $comment_id)
        ->where('wc_user_id', $user_id)
        ->delete();
        return "Delete reply successfully";
    }
    //获取某评论的所有回复
    public function getAllReplyByID($comment_id)
    {
        $replyList = Db::name('reply')
        ->where('wr_wc_id', $comment_id)
        ->order('wr_date', 'desc')
        ->select();
        if(count($replyList))
        {
        	$replys = array();
        	foreach($replyList as $reply)
        	{
        		$replyUserInfo = $this->getNamePhotoById($reply['wr_user_id']);
        		$reply['wr_user_name'] = $replyUserInfo[0];
        		$reply['wr_user_photo'] = $replyUserInfo[1];
        		array_push($replys, $reply);
        	}
        	return $replys;
        }
        else
        {
            return "No reply on this comment";
        }
    }
    //获取所有回复
    public function getAllReply($word_name)
    {
    	$replyList = Db::name('reply')
    	->where('wr_name', $word_name)
    	->order('wr_date', 'desc')
    	->select();
    	if(count($replyList))
    	{
    		$replys = array();
    		foreach($replyList as $reply)
    		{
    			$replyUserInfo = $this->getNamePhotoById($reply['wr_user_id']);
    			$reply['wr_user_name'] = $replyUserInfo[0];
    			$reply['wr_user_photo'] = $replyUserInfo[1];
    			array_push($replys, $reply);
    		}
    		return $replys;
    	}
    	else
    	{
    		return "No reply on this comment";
    	}
    }
    //添加回复
    public function addReply($word_name, $reply, $comment_id, $user_id)
    {
        $replyDate = date("Y-m-d H:i:s");
        Db::name('reply')->insert(['wr_name' => $word_name,
            'wr_dcp' => $reply, 'wr_date' => $replyDate, 
            'wr_wc_id' => $comment_id, 'wr_user_id' => $user_id]);
        return "Add reply successfully";
    }
    //删除回复
    public function deleteReply($comment_id, $user_id)
    {
        Db::name('reply')
        ->where('wr_wc_id', $comment_id)
        ->where('wr_user_id', $user_id)
        ->delete();
        return "Delete reply successfully";
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
            return "Update thumbup successfully";
        }
        else
        {
            //var_dump("No comment to thumb up");
            return "Fail to update thumbup";
        }
    }
    //根据评论/回复中的user_id查询user_name和user_photo
    public function getNamePhotoById($user_id)
    {
    	$user = Db::name('user')
    	->where('user_id', $user_id)
    	->select();
    	//var_dump($user);
    	if(count($user))
    	{
    		$userName = $user[0]['user_name'];
    		$userPhoto = $user[0]['user_photo'];
    		$userInfo = array();
    		array_push($userInfo, $userName, $userPhoto);
    		return $userInfo;
    	}
    	else
    	{
    		return "Fail to find user";
    	}
    }
}
?>