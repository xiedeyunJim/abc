<?php
namespace co;
use think\Controller;
use think\Request;
use think\Db;
class Co extends Controller{
	public function initialize()
	{
		if(!session('id') || !session('name')){
			return $this->error('请现登录','login/index');
		}
		$auth = new \app\admin\controller\Auth;
		$con = request()->controller();
		$action = request()->action();
		$name = $con.'/'.$action;
		$notchek = array('Index/index','Admin/lst','Index/outline');

		if(session('id')!=30){
			if(!in_array($name, $notchek)){
				if(!$auth->check($name,session('id'))){
					$this->error('没有权限',url('index/index'));
				}				
			}
		}

	}
}
