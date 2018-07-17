<?php
namespace app\index\controller;
use site\Site;
use app\admin\model\Admin_auth_rule;
use think\facade\Cache;
class Index extends Site
{
    public function index()
    {   
        //首页列表
		$article = new \app\index\model\AdminArticle;
		$article->getNewArticleList();
		$getNewArticleList = Cache::get('getNewArticleList');
		//右侧列表
		$article->getIndexArticleHot();
		$getIndexArticleHot = Cache::get('getIndexArticleHot');
		//友情链接
		$links = db('admin_links')->order('id desc')->select();
		//轮播
		$article->getSliderArticle();
		$getSliderArticle = Cache::get('getSliderArticle');


		$this->assign(array(
			'getIndexArticleHot'=>$getIndexArticleHot,
			'getNewArticleList'=>$getNewArticleList,
			'links'=>$links,
			'getSliderArticle'=>$getSliderArticle,
		));
    	return $this->fetch();
    }



}
