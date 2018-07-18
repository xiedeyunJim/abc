<?php
namespace app\admin\controller;
use co\Co;
class Links extends Co{
	public function lst()
	{
		if(input('get.')){
			$data = input('get.');
			foreach ($data as $key => $vo) {
				# code...
				$res = db('admin_links')->where('id',$key)->update(['sort' => $vo]);
		
			}
			if($res){
				return $this->success('ok');
			}else{
				return $this->error('sorry');
			}
			return;
		}
		$data = db('admin_links')->order('sort','desc')->select();
		$this->assign('data',$data);
		return $this->fetch();
	}
	public function add()
	{
		if(input('')){
			$validate = new \app\admin\validate\Links;
	        if (!$validate->scene('add')->check(input(''))) {
	          	$this->error($validate->getError());
	        }else{
				$data = db('admin_links')->strict(false)->insert(input(''));

				if($data){
					return $this->success('ok','lst');
				}else{
					return $this->error('sorry');
				}				        	
	        }			
			return;
		}
		return $this->fetch();
	}
	public function del($id)
	{
		$data = db('admin_links')->where('id',$id)->delete();
		if($data){
			return $this->success('ok');
		}else{
			return $this->error('sorry');
		}
	}
	public function edit($id)
	{
		if(input('post.')){
			$validate = new \app\admin\validate\Links;
			if (!$validate->scene('edit')->check(input('post.'))) {
	          	$this->error($validate->getError());die;
	        }else{
				$data = db('admin_links')->where('id',input('id'))->strict(false)->update(input('post.'));
				if($data){
					return $this->success('ok','lst');
				}else{
					return $this->error('sorry');
				}				        	
	        }
			return;
		}
		$data = db('admin_links')->where('id',$id)->find();
		$this->assign('data',$data);
		return $this->fetch();
	}
}	