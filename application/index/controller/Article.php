<?php
namespace app\index\controller;
use site\Site;
class Article extends Site
{
    public function index()
    {   	
    	return $this->fetch();
    }
}
