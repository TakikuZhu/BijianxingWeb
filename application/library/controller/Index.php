<?php
namespace app\library\controller;
use think\Controller;
use think\Request;

class Index extends Controller
{
    public function index()
    {
//      return $this->fetch();
		return view('index');
    }

}
?>

