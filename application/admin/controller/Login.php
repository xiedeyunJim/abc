<?php
namespace app\admin\controller;
use think\Controller;
use think\captcha\Captcha;
use app\admin\model\Admin_role;
class Login extends Controller{
	public function index()
	{
		if(input('')){
			$admin = new Admin_role;
			$auth = new Auth();

			if(!captcha_check(input('code'))){
				return $this->error('验证码错误');
			};
			switch ($admin->login(input(''))) {
				case '1':
					# code...
					return $this->error('用户名不存在','index');

					break;
				case '2':
					$adminT=$auth->getGroups(session('id'));
					$title = array();
					foreach ($adminT as $key => $value) {
						$title[] = $value['title'];
					}
					session('title',$title[0]);
					return $this->success('登录成功','index/index');

					break;	
				case '3':
					return $this->error('用户密码错误','index');

					break;
				default:
					# code...
					return $this->error('快滚','index');
					break;
			}

			return;
		}
		return $this->fetch();
	}
	
}