<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\phone\model\Index as UserModel;
use app\phone\model\Dynamic as UserModel2;
use app\phone\model\Dynamics as Dyn;
use app\phone\model\Forum as ForumModel;
use app\phone\model\Collection as Col;
use app\phone\model\Comment as DynamicComment;

class Forum extends Controller
{
	public function forum()
    {
    	$user_id = Session::get("user_id");
    	$this->assign('user_id',$user_id);
		$model = new ForumModel();
		$sql1 = 'select a.dynamic_id, a.time, a.image, a.read_num, a.theme, count(b.comment_id) as comment_num, c.user_name, c.user_photo, c.user_id
			from tb_user as c, tb_dynamic as a left join tb_dynamic_comment as b on b.dynamic_id = a.dynamic_id 
			where c.user_id = a.user_id group by a.dynamic_id order by a.time desc';
    	$list1 = $model->query($sql1);
		$this->assign('list1',$list1);
		
   		$sql2 = "select a.dynamic_id, a.time, a.image, a.read_num, a.theme, count(b.comment_id) as comment_num, c.user_name, c.user_photo, c.user_id
			from tb_user as c, tb_dynamic as a left join tb_dynamic_comment as b on b.dynamic_id = a.dynamic_id 
			where c.user_id = a.user_id and a.user_id in (select foucsed_id from tb_focus where focus_id = ".Session::get("user_id")
			.") group by a.dynamic_id order by a.time desc";
		$list2 = $model->query($sql2);
		$this->assign('list2',$list2);

		$sql3 = "select a.dynamic_id, a.time, a.image, a.read_num, a.theme, count(b.comment_id) as comment_num, c.user_name, c.user_photo, c.user_id
			from tb_user as c, tb_dynamic as a left join tb_dynamic_comment as b on b.dynamic_id = a.dynamic_id 
			where c.user_id = a.user_id and a.user_id = ".Session::get("user_id")
			." group by a.dynamic_id order by a.time desc";
		$list3 = $model->query($sql3);
		$this->assign('list3',$list3);

		return $this->fetch();
    }
    
    public function forum_post($dynamic_id = "eeee")
    {
    	if($dynamic_id == "eeee")
		{
			$dynamic_id = Session::get("dynamic_id");
		}
		$dyn = new Dyn;
		$condition['dynamic_id']=['=',$dynamic_id];
		$dyn = $dyn->where($condition)->find();
		$dyn->read_num +=1;//阅读量+1
		$dyn->save();
		$theme = $dyn->theme;
		$content = $dyn->content;
		$date =  $dyn->time;
		$number = $dyn->read_num;
		$score = $dyn->score;
		$txt = $dyn->content;
		
		$col = new Col;
		$collect = $col->where($condition)->count();
		
		Session::set("author",$dyn->user_id);
		
		//渲染评论区 
		$list=DynamicComment::where('dynamic_id',$dynamic_id)->order("time",'desc')->paginate(500);
		//$list=$list=DynamicComment::paginate(5);
		$this->assign('list',$list);
		$this->assign('count',count($list));
		
		//渲染帖子
		$this->assign('theme',$theme);
		$this->assign('content', $content);
		$this->assign('time',$date);
		$this->assign('number',$number);
		$this->assign('score',$score);
		$this->assign('txt',$txt);
		$this->assign('collect',$collect);
		
       	Session::set("dynamic_id",$dynamic_id);
		return $this->fetch('forum/forum_post');
    }
    
    public function collectPage($user_id)
    {
    	$this->assign('user_id', Session::get('user_id'));
    	
    	$model = new ForumModel();
    	$sql = "select a.dynamic_id, a.time, a.image, a.read_num, a.theme, count(b.comment_id) as comment_num, c.user_name, c.user_photo, c.user_id
			from tb_user as c, tb_dynamic as a left join tb_dynamic_comment as b on b.dynamic_id = a.dynamic_id 
			where c.user_id = a.user_id and a.dynamic_id in (select dynamic_id from tb_collect where user_id = ".Session::get("user_id")
			.") group by a.dynamic_id order by a.time desc";
    	$list = $model->query($sql);
		$this->assign('list',$list);
		
		return $this->fetch('forum/collect');
    }
    	
	
	public function search_forum($user_id)
    { 	
    	$this->assign('rtn', "");
    	if ($user_id == 0)
    	{
    		$this->assign('rtn', "没有查询到该书法家");
    	}
    	$this->assign('user_id', Session::get('user_id'));
		$model = new ForumModel();
    	$sql1 = "select a.dynamic_id, a.time, a.image, a.read_num, a.theme, count(b.comment_id) as comment_num, c.user_name, c.user_photo, c.user_id
			from tb_user as c, tb_dynamic as a left join tb_dynamic_comment as b on b.dynamic_id = a.dynamic_id 
			where c.user_id = a.user_id and a.user_id = ".$user_id
			." group by a.dynamic_id order by a.time desc";
    	$list1 = $model->query($sql1);
		$this->assign('list1',$list1);
    	return $this->fetch('forum/search_forum');
    }
	
	public function edit()
    {
    	return $this->fetch('forum/edit');
    }
	
    public function searchforum(Request $request) {
    	$user_name = $request->param("user_name");
    	$user_id = Db::name('user')
    	->where('user_name', $user_name)
    	->value('user_id');
		if ($user_id == '')
		{
			return json('0');
		}else {
			return json($user_id);
		}
    }
	
    public function deleteDynamic(Request $request) {
    	$dynamic_id = $request->param("dynamic_id");
    	
    	$deleteDyn = new Dyn;
    	$deleteDyn = $deleteDyn 
    	->where('dynamic_id', $dynamic_id)
    	->find();
    	
    	$deleteCom = new DynamicComment;
    	$deleteCom = $deleteCom
    	->where('dynamic_id', $dynamic_id)
    	->find();
    	
    	if ($deleteCom)
    	{
    		if ($deleteDyn->delete() && $deleteCom->delete()) {
	    		return json("1");
	    	}
	    	else {
	    		return json("0");
	    	}
    	}
    	else 
    	{
    		if ($deleteDyn->delete()) {
	    		return json("1");
	    	}
	    	else {
	    		return json("0");
	    	}
    	}
    }
}

?>