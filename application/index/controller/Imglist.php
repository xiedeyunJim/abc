<?php
namespace app\index\controller;
use site\Site;
class Imglist extends Site
{
    public function index()
    {
    	return $this->fetch();
    }


}
