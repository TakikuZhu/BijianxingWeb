<?php
	
	use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\index\model\Index as UserModel;
use app\index\model\Focus as UserModel2;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

$GLOBALS['proName'] = 'BiJianXingXiangMu-XingBaZu';//工程名
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//$GLOBALS['proName'] = 'bijianxing';//工程名

function Exist($us_id)
	{
		$per_id=Session::get('user_id');
		$user = Db::name('focus')
        ->where('focus_id', $per_id)->where('foucsed_id', $us_id)
        ->select();
        if($user==null)
        {
        	
        	return 1;
        }
        else
        {
        	
        	
        	return 2;
        }

	}
	
function Same()
{
	$per_id=Session::get('user_id');
	$us_id=Session::get('author');
	if($per_id==$us_id)
        {
        	
        	return 1;
        }
        else
        {
        	
        	
        	return 2;
        }
}
