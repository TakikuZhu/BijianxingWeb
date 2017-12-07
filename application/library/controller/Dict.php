<?php
namespace app\library\controller;
use think\Controller;
use think\Request;

class Dict extends Controller{
	public function index()
	    {
			return view('dict');
	    }
}
?>