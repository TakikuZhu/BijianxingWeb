<?php
//author:zhuting
//function:post/read/delete dynamics
//表：动态(用户id，时间，内容，得分，打分人数，阅读量)
//功能：发表动态、删除动态、敏感词过滤、插件 
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\index\model\Dynamics as Dyn;
use app\index\model\Comment as DynamicComment;
use app\index\model\Collection as Col;
use app\index\model\Index as UserModel;
use think\Db;

class Dynamics extends Controller
{
	//验证登陆
	/*function _initialize()
	{
		if( !Session::has('phone') ) {
			$this->error('请先登录！', url('admin/Login/login'));
		}
	}*/

	//渲染显示页面
	public function index($dynamic_id = "eeee"){
		
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
		$date =  $dyn->time;
		$number = $dyn->read_num;
		$score = $dyn->score;
		$txt = $dyn->content;
		
		$col = new Col;
		$collect = $col->where($condition)->count();
		
		Session::set("author",$dyn->user_id);
		
		//渲染评论区 
		$list=DynamicComment::where('dynamic_id',$dynamic_id)->order("time",'desc')->paginate(5);
		//$list=$list=DynamicComment::paginate(5);
		$this->assign('list',$list);
		$this->assign('count',count($list));
		
		//渲染帖子
		$this->assign('theme',$theme);
		$this->assign('time',$date);
		$this->assign('number',$number);
		$this->assign('score',$score);
		$this->assign('txt',$txt);
		$this->assign('collect',$collect);
		
		//渲染作者信息
		$this->fetchauthor();
		
       		Session::set("dynamic_id",$dynamic_id);
		return $this->fetch('dynamic');
	}
	
	public function fetchauthor(){
		//渲染作者信息
    	$per_id=Session::get('author');
    	
    	if($per_id == Session::get('user_id'))
		{
			Session::set('same','true');
		}
		else{
			Session::set('same','falese');
		}
    	
//  $arr = Array('one', 'two', 'three');
//   echo json_encode($arr);
    	
//  	$data = Db::name('user')->find();
         $countcollect = Db::name('collect')
	         ->where('user_id', $per_id)
	         ->count();
	         $this->assign('clcount',$countcollect);
        
        
        $countfocus = Db::name('focus')
         ->where('focus_id', $per_id)
         ->count();
         $this->assign('atten',$countfocus); 
         //获取关注数量
         $countfans = Db::name('focus')
         ->where('foucsed_id', $per_id)
         ->count();
         $this->assign('fans',$countfans); 
         //获取粉丝数量
         
         $countdynamic = Db::name('dynamic')
         ->where('user_id', $per_id)
         ->count();
         $this->assign('dycount',$countdynamic);
         //获取动态数量
         $seatright = Db::name('user')
         ->where('user_id', $per_id)
         ->value('motto');
         $photo = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_photo');
        $this->assign('photo',$photo);
//获取座右铭
         $username = Db::name('user')
         ->where('user_id', $per_id)
         ->value('user_name');
         $this->assign('name',$username);
         $this->assign('seatrt',$seatright);
         //取得关注数列表
         $focusId = Db::name('focus')
         ->where('focus_id', $per_id)
         ->column('foucsed_id');
         $dynamicId = Db::name('dynamic')
         ->where('user_id',$per_id)
         ->column('dynamic_id');
//->find();
         
		         $this->assign('fouId',$focusId);
       			$this->assign('perId',$per_id);
	}
	//发表动态页面显示
    public function post(){
    	$this->assign('theme','');//初始化控件
    	
    	$this->fetchauthor();
		 
    	return $this->fetch('new_dynamic');
    }
    
    //发表动态写入数据库
    public function add(Request $request){
		//获取表单
    	$theme =$_REQUEST["theme"];
		$txt = $_REQUEST["content"];
		$txt =$this->check($txt);
		
    	$file=$_FILES['file'];
    	
    	$date =  date('Y-m-d H:i:s', time());//当前时间
		$per_id =Session::get('user_id') ;//在session中获得当前使用者user_id
		
		//保存帖子
		$dyn = new Dyn;
		if($theme!=''){
			$dyn->theme = $theme;
		}
		else{
			$dyn->theme = "未命名";
		}
		
		$dyn->user_id =$per_id;
		$dyn->content = $txt;
		$dyn->read_num = "0";
		$dyn->score_num = "0";
		$dyn->score = "0";
		$dyn->time = $date;
		$dyn->save();
		
		
		$dynamic_id = $dyn->dynamic_id;
		Session::set('dynamic_id',$dynamic_id);//写入Session
		
		//保存封面
		if($file['name']!=''){
		
		$name=iconv("UTF-8", "gb2312", $file['name']);

		$info =move_uploaded_file($file['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/static/upload/image/'. $dynamic_id.$name);
		$image = $dynamic_id.$file['name'];
		$dyn->image = $image;
		$dyn->save();
		}
		
		return json($dynamic_id);
    	
    }
	    /**
	 * [getPic description]
	 * 获取文本中首张图片地址
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	  public function getPic($content){
	        if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
	           $str=$matches[0];
	           return $str;
	       }
			else 
			return "123";
	    }
	
	
    //删除动态
    public function test(){
    	 $file = $request->file('file');
        if (empty($file)) {
            $this->error('请选择上传文件');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            $this->success('文件上传成功：' . $info->getRealPath());
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }
    	
    }
    
    //敏感词过滤
    public function check($bb){
    	$badword = array(  'cnm','法轮功','台独','共产党' ); 
		$badword1 = array_combine($badword,array_fill(0,count($badword),'*')); 
//		$bb = '我今天开着张三丰田上班'; 
		$str = strtr($bb, $badword1); 
		return $str;
    	
    	
    }
	
	

}
?>
