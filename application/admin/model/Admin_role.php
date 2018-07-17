<?php
namespace app\admin\model;
use think\Model;
class Admin_role extends Model{
	 public function add($data)
	 {
	 	if(empty($data)||!is_array($data)){
	 		return false;
	 	}
	 	if($data['password']){
	 		$data['password'] = md5($data['password']);
	 	}
	 	// 根据name字段查询用户
	 	if($this->save($data)){
	 		$authGroupAccess['uid'] = $this->id;
	 		$authGroupAccess['group_id'] = $this->group_id;
	 		db('admin_auth_group_access')->insert($authGroupAccess);
	 		return true;
	 	}else{
	 		return false;
	 	}	


	 }

	 public function del($id)
	 {
	 	$data = $this->destroy($id);
	 	if($data){
	 		return true;
	 	}else{
	 		return false;
	 	}
	 	
	 }
	 public function login($data)
	 {
	 	$admin=$this::getByName($data['name']);
	 	if($admin){
	 		if(md5($data['password']) == $admin['password']){
	 			session('id',$admin['id']);
	 			session('name',$admin['name']);
	 			return 2;
	 		}else{
	 			return 3;
	 		}
	 	}else{
	 		return 1;
	 	}

	 }
	 //$data 是input('');
	 public function edit($data)
	 {

	 	$code = $this->get($data['id']);
	 	if($data['password']){

	 		$data['password'] = md5($data['password']);
	 	}else{
	 		$data['password'] = $code['password'];
	 	}

	 	db('admin_auth_group_access')->where('uid',$data['id'])->update(['group_id'=>$data['group_id']]);

		return $this->update(['id'=>$data['id'],'name'=>$data['name'],'password'=>$data['password']]);	 	 	
	 	
	 


	 }

}
