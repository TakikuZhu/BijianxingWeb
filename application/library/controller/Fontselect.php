<?php
namespace app\library\controller;
use think\Controller;
use think\Request;

class Fontselect extends Controller{
	public function index()
	    {
			return view('fontSelect');
	    }
}
?>