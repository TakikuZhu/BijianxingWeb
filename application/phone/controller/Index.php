<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\phone\model\Index as UserModel;

class Index extends Controller
{
    public function index()
    {
    	$model = new UserModel();
		$sql1 = 'select a.dynamic_id, a.time, a.image, a.read_num, a.theme, count(b.comment_id) as comment_num, c.user_name, c.user_photo, c.user_id
			from tb_user as c, tb_dynamic as a left join tb_dynamic_comment as b on b.dynamic_id = a.dynamic_id 
			where c.user_id = a.user_id group by a.dynamic_id order by a.time desc';
    	$list1 = $model->query($sql1);
		$this->assign('list1',$list1);
        return $this->fetch();
    }
}
?>