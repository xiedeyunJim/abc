<?php
namespace app\admin\controller;
use co\Co;
class AuthGroup extends Co{
	public function lst()
	{
		$data = db('admin_auth_group')->select();
		$this->assign('data',$data);
		return $this->fetch();

	}
	public function add()
	{
		if(input('')){
			$code = input('get.');
			
			if($code['rules']){
				$code['rules'] = implode(',',$code['rules']);

			}			

			$data = db('admin_auth_group')->insert($code);
			if($data){
				return $this->success('用户组添加成功','lst');
			}else{
				return $this->error('用户组添加失败');
			}
			return;
		}
		$auth_rule = new \app\admin\model\Admin_auth_rule;

		$data = $auth_rule->authRuleTree();
		$this->assign('data',$data);
		return $this->fetch();
	}
	public function edit($id)
	{
		if(input('post.')){
			$code = input('post.');
			if($code['rules']){
				$code['rules'] = implode(',',$code['rules']);
			}			
			$_code = array();
			foreach ($code as $key => $value) {
				$_code[] = $key;
			}
			if(!in_array('status', $_code)){
				$code['status'] = 0;
			}
			$data = db('admin_auth_group')->where('id',$id)->update($code);
			if($data){
				return $this->success('用户组更新成功','lst');
			}else{
				return $this->error('用户组更新失败');
			}				
			return;
		}
		$auth_rule = new \app\admin\model\Admin_auth_rule;

		$code = $auth_rule->authRuleTree();	
			
		$data = db('admin_auth_group')->where('id',$id)->find();
		$this->assign(array('data'=>$data,'code'=>$code));
		return $this->fetch();
	}
	public function del($id)
	{
		$data = db('admin_auth_group')->where('id',$id)->delete();
		if($data){
			return $this->success('用户组删除成功');
		}else{
			return $this->error('用户组删除失败');
		}

	}
}	