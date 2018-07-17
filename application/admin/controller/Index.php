<?php
namespace app\admin\controller;
use think\Controller;
use co\Co;

class Index extends Co{
	public function index()
	{
		return $this->fetch();
	}
	public function outLine()
	{
		session(null);
		return $this->success('退出成功','login/index');
	}

}