<?php
namespace app\index\controller;
use site\Site;
use think\facade\Cache;
use think\Db;
class Search extends Site
{
	public function index()
	{

		$keywords = input('keywords');

		$data = db('admin_article')->order('id desc')->where('title','like',$keywords)->paginate(1,false,$options = ['query'=>arraY('keywords'=>$keywords)]);
	
		
		$article = new \app\index\model\AdminArticle;
		$article->getIndexArticleHot();
		$getIndexArticleHot = Cache::get('getIndexArticleHot');		
		$this->assign(array('data'=>$data,'getIndexArticleHot'=>$getIndexArticleHot,'keywords'=>$keywords));
		return $this->fetch();
	}
}