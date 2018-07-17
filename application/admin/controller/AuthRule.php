<?php
namespace app\admin\controller;
use co\Co;
use app\admin\model\Admin_auth_rule;
class AuthRule extends Co{
	public function add()
	{
		if(input('')){
			$code =input('');
			$plevel = db('admin_auth_rule')->where('id',$code['pid'])->field('level')->find();
			if($plevel){
				$code['level'] = $plevel['level']+1;				
			}else{
				$code['level'] = 0;
			}
			$data = db('admin_auth_rule')->insert($code);
			if($data){
				return $this->success('添加成功','lst');
			}else{
				return $this->error('添加失败');
			}			
			return;
		}
		$auth_tree = new Admin_auth_rule;

		$data = $auth_tree->authRuleTree();

		$this->assign('data',$data);

		return $this->fetch();
	}
	public function del($id)
	{
		$auth_tree = new Admin_auth_rule;

		$data = $auth_tree->getchilrendid($id);

		array_push($data,$id);

		$res = $auth_tree::destroy($data);
		
		if($res){
			return $this->success('删除成功');
		}else{
			return $this->error('删除失败');
		}
	}
	public function edit($id)
	{
		$auth_tree = new Admin_auth_rule;
		#2.传入
		if(input('post.')){

			$code =input('');
			$plevel = db('admin_auth_rule')->where('id',$code['pid'])->field('level')->find();

			if($plevel){
				$code['level'] = $plevel['level']+1;				
			}else{
				$code['level'] = 0;
			}
			$data = $auth_tree->update($code);
			if($data){
				return $this->success('修改成功','lst');
			}else{
				return $this->error('修改失败');
			}

			return;
		}
		#1.查询

		#3.id的使用
		$code = $auth_tree->get($id);
		$data =$auth_tree->authRuleTree();
		$this->assign(array(
			'data'=>$data,
			'code'=>$code,
		));
		return $this->fetch();
	}
	public function lst()
	{
		$auth_tree = new Admin_auth_rule;
		if(input('get.')){
			$data = input('get.');
			foreach ($data as $key => $value) {
				
				$data = $auth_tree->update(['id'=>$key,'sort'=>$value]);
			}
			if($data){
				return $this->success('排序成功');
			}else{
				return $this->error('排序失败');
			}
			return;
		}
		$data = $auth_tree->authRuleTree();
		
		$this->assign('data',$data);
		
		return $this->fetch();
	}


}	