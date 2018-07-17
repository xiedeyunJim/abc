<?php
namespace app\index\controller;
use site\Site;
use app\admin\model\Admin_auth_rule;
class Index extends Site
{
    public function index()
    {   
    	return $this->fetch();
    }
        public function test()
    {
        $ad = new Admin_auth_rule;
        $data = $ad->aaa();
        $this->assign('data',$data);
        echo $data->getLastSql();
        return $this->fetch();
    }



}
