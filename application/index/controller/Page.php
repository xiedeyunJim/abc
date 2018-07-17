<?php
namespace app\index\controller;
use site\Site;
class Page extends Site
{
	public function index()
	{
		return $this->fetch();	
	}
	
}