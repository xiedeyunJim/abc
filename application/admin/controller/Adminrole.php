<?php
namespace app\admin\controller;
use co\Co;
use app\admin\model\Admin_role;
class Adminrole extends Co{
	public function index()
	{

		// $data = db('admin_role')->alias('role')->join('admin_auth_group_access access','access.uid=role.id')
		// ->join('admin_auth_group group','group.id=access.group_id')
		// ->select();
		$admin = new Admin_role;
		$res = $admin->select();
		$authG =new Auth();
		foreach ($res as $key => $value) {
			$_groupTitle = $authG->getGroups($value['id']);
			$groupTitle = $_groupTitle[0]['title'];
			$value['groupTitle'] =$groupTitle;

		}
		$this->assign('res',$res);
		return $this->fetch();
	}
	public function adminadd()
	{

		if(input('')){
			$admin =new Admin_role;

	 		$name = $admin->field('name')->where('name',input('name'))->find();
	 		if($name){
	 			return $this->error('管理员名称重复');
	 		}
			if($admin->add(input(''))){
				return $this->success('添加成功','index');
			}else{
				return $this->error('添加失败');
			}
			return;
		}
		$authGroupData = db('admin_auth_group')->select();
		$this->assign('authGroupData',$authGroupData);
		return $this->fetch();
	}
	public function editadmin($id)
	{
		$admin = new Admin_role;
		$delNum = $admin->del($id);
		if($delNum ==true){
			return $this->success('删除成功');
		}else{
			return $this->error('删除失败');
		};
	}
	 public function edit($id)
	 {
	 	$admin =new Admin_role;
	 	if(input('post.')){
	 		$admin->edit(input(''));

	 		if($admin){
	 			return $this->success('修改成功');
	 		}else{
	 			return $this->error('修改失败');
	 		}
	 	}
	 	$data = $admin->get($id);
		$authGroupData = db('admin_auth_group')->select();
		$authGroupDataAccess = db('admin_auth_group_access')->where('uid',$id)->find();
		$this->assign(array('authGroupData'=>$authGroupData,'data'=>$data,'authGroupDataAccess'=>$authGroupDataAccess));	 	
	 	return $this->fetch();
	 }	

}