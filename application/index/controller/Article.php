<?php
namespace app\index\controller;
use site\Site;
class Article extends Site
{
    public function index()
    { 

    	return $this->fetch();
    }
    public function like($id)
    {
    	$data = db('admin_article')->where('id',$id)->setInc('like',1);

    	$code = db('admin_article')->where('id',$id)->field('like')->find();
    	if($code){
    		return $code;
    	}
    }
}
