<?php
namespace app\index\controller;
use site\Site;
class Page extends Site
{
	public function index()
	{
		$data = db('admin_cate')->find(input('id'));
		$this->assign('data',$data);
		return $this->fetch();	
	}
	
}