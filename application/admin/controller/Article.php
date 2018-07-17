<?php
namespace app\admin\controller;
use co\Co;
use app\admin\model\Admin_article;
use app\admin\model\Admin_cate;
class Article extends Co{

	public function add()
	{
		$article = new Admin_article;
		$cate = new Admin_cate;	
		if(input('')){
			$data = input('');
			$code = $article->save($data);
			if($code){
				return $this->success('添加文章成功','article/lst');
			}else{
				return $this->error('添加文章失败','article/lst');
			}
			return;
		}
		$data = $cate->catetree();
		$this->assign('data',$data);		
		return $this->fetch();
	}
	public function lst()
	{
		$article = new Admin_article;
		$data = $article->field('a.*,b.catename')->alias('a')->join('admin_cate b','a.cateid=b.id')->paginate(3);
		$this->assign('data',$data);
		return $this->fetch();		
	}
	public function edit($id)
	{
		$cate = new Admin_cate;
		$article = new Admin_article;				
		if(input('post.')){
			
			$res = $article->update(input('post.'));
			
			if($res){
				return $this->success("已经成功了",'lst');
			}else{
				return $this->error('错误了哦');
			}
			return;
		}

		$data = $cate->catetree();
		$article = Admin_article::get($id);
		$this->assign(array(
			'data'=>$data,

			'article'=>$article,
		));						
		return $this->fetch();
	}
	public function del($id)
	{
		$article = new Admin_article;
		if($article::destroy($id)){
			$this->success('成功');
		}else{
			$this->error('失败');
		}


	}
	public function add2()
	{
		$article = new Admin_article;
		$cate = new Admin_cate;	
		if(input('')){
			$data = input('');
			$code = $article->save($data);
			if($code){
				return $this->success('添加文章成功','article/lst');
			}else{
				return $this->error('添加文章失败','article/lst');
			}
			return;
		}
		$data = $cate->catetree();
		$this->assign('data',$data);		
		return $this->fetch();

	}




}	