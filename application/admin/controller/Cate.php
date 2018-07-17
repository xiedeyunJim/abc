<?php
namespace app\admin\controller;
use co\Co;
use app\admin\model\Admin_cate;
use app\admin\model\Admin_article;
class Cate extends Co{
    protected $beforeActionList = [

        'delson'  =>  ['only'=>'del'],
    ];

	public function add()
	{	
		/*
			str_replace，切换中英文逗号
		*/
		if(input("")){
			$_data = input('');
			str_replace('，', ',', $_data['site_title']);
			str_replace('，', ',', $_data['site_keywords']);
			str_replace('，', ',', $_data['site_desc']);
			$data = db('admin_cate')->insert($_data);
			if($data){
				return $this->success('添加成功','lst');
			}else{
				return $this->error('添加失败');
			}
			return;
		};
		$cate = new Admin_cate;

		$data = $cate->catetree();	

		$this->assign('data',$data);
		return $this->fetch();
	}

	public function lst()
	{	
		$cate = new Admin_cate;
		//必须这样写法才能接受主键
		if(input('get.')){
			
			$res = input('get.');
			//这是一个一维数组
			foreach ($res as $key => $value) {
				# code...
				$res = $cate->update(['id'=>$key,'sort'=>$value]);

			}
			if($res){
				return $this->success('排序成功');
			}else{
				return $this->error('失败');
			}

			return;
		}
		$data = $cate->catetree();

		$this->assign('data',$data);
		return $this->fetch();
	}

	public function del()
	{
		$data = db('admin_cate')->delete(input('id'));
		if($data){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		};
	}

	public function  delson()
	{
		$cateid = input('id');

		$cate = new Admin_cate;

		$article = new Admin_article;

		$data = $cate->getchilrendid($cateid);
		//有先后顺序，首先插入array，变量赋值成array类型，在赋值一个字符串添加进去。
		$allid= $data;
		//一维数组；
		$allid[] = $cateid;
		//二维数组
		foreach($allid as $key=>$vo){
			$code = db('admin_article')->where('cateid',$vo)->select();
			foreach($code as $t=>$v){
				$article::destroy($v['id']);
			}
		}

		if($data){
			db('admin_cate')->delete($data);
		}
	}

	public function edit()
	{
		$cate = new Admin_cate;

		if(input('post.')){

			$data = $cate->update(input('post.'));
			if($data){
				return $this->success('更新成功');
			}else{
				return $this->error('更新失败');
			}
			return;

		}

		$cates = $cate->get(input('id'));

		$data = $cate->catetree();	

		$this->assign(array(
			'data'=>$data,
			'cates'=>$cates,
		));

		return $this->fetch();
	}
}