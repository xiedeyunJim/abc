<?php
namespace app\admin\controller;
use co\Co;
class Conf extends Co{
	public function add()
	{

		if(input('')){
			$data = input('');
			if($data['values']){
				$data['values'] = str_replace('，',',', $data['values']);
			}
			$res = db('admin_conf')->insert($data);
			if($res){
				return $this->success('添加配置成功','lst');
			}else{
				return $this->error('添加配置失败');
			}
			return;
		}
		return $this->fetch();
	}
	public function edit($id)
	{	
		if(input('post.')){
			$data = input('post.');
			if($data['values']){
				$data['values'] = str_replace('，',',', $data['values']);
				
			}
			$res = db('admin_conf')->where('id',input('id'))->update($data);
			if($data){
				return $this->success('修改成功','lst');
			}else{
				return $this->error('修改失败');
			}			
			return;
		}
		$data = db('admin_conf')->where('id',$id)->find();
		$this->assign('data',$data);
		return $this->fetch();
	}
	public function lst()
	{
		if(input('get.')){
			$data = input('get.');
			foreach ($data as $key => $value) {
				# code...
				$res = db('admin_conf')->where('id',$key)->update(['sort'=>$value]);
			}
			if($res){
				return $this->success('排序成功','lst');
			}else{
				return $this->error('排序失败');
			}
			return;
		}
		$data = db('admin_conf')->order('sort','desc')->select();
		$this->assign('data',$data);
		return $this->fetch();
	}
	public function del($id)
	{
		$data = db('admin_conf')->where('id',$id)->delete();
		if($data){
			return $this->success('删除成功','lst');
		}else{
			return $this->error('删除失败');
		}
	}
	public function conf()
	{		#批量更新
			#多选框的判断
		if(input('')){
			#1.查询数据
			$code = db('admin_conf')->field('enname')->select();
			#2.二位数组转换一维数组,与一位数组相一致；
			$_code = array();
			foreach ($code as $key => $value) {
				# 为查询数组
				$_code[]= $value['enname'];
			}
			$_data = array();
			#接受数据
			$data = input('');
			foreach ($data as $key => $value) {
				# 为input接受数组,组装它的键名为一维数组
				$_data[]=$key; 
			}
			#3.对比数组(查询数组循环对比接受数组，查询到没有这个$value就把它提出来组装成数组)
			foreach ($_code as $key => $value) {
				# code...
				if(!in_array($value, $_data)){
					$arr[] = $value;
					#4.新建数组
				}
			}
			if(!empty($arr)){
				//再一次循环数组，使用关联数组赋值健名
				foreach ($arr as $key => $value) {
					# code...
					$chek = array($value=>NULL);
				}
				#5.组装数组
				$formdata = array_merge_recursive($data,$chek);

				foreach ($formdata as $key => $value){
					# code...

					$res = db('admin_conf')->where('enname',$key)->find();
				}

				if($res){
					return $this->success('成功');
				}else{
					return $this->error('失败');
				}										
			}		
											
			return;
		}
		$data = db('admin_conf')->order('sort','desc')->select();
		$this->assign('data',$data);
		return $this->fetch();
	}
}	
