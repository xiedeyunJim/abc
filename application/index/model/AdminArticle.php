<?php
namespace app\index\model;
use think\Model;
use app\index\model\AdminCate;
use think\facade\Cache;
use think\Db;
class AdminArticle extends Model
{
	//查库
/*
cache可以用于select、find、value和column方法，以及其衍生方法，使用cache方法后，在缓存有效期之内不会再次进行数据库查询操作，而是直接获取缓存中的数据，关于数据缓存的类型和设置可以参考缓存部分。
*/	
	public function getArticleId($id)
	{
		if (!Cache::get('article'.$id)) {
			$cate = new AdminCate;
			$allCateId = $cate->getchilrendid($id);
			$article=db('admin_article')->order('id desc')->where('cateid',$allCateId)->paginate(2);
			$this->cacheSetArticle($id,$article);
			
		}


	}
	/*
	* @param $id: input('id')
	* @param $article 查库数据
	* @param $name Cache名称
	*/
	public function cacheSetArticle($id,$article)
	{
		Cache::set('articles'.$id,$article);
	}
/*
第一次查询结果会被缓存，第二次查询相同的数据的时候就会直接返回缓存中的内容，而不需要再次进行数据库查询操作。
*/
	public function getArticleHot($id)
	{	
		// dump($id);die;
		if (!Cache::get('articleHot'.$id)) {
			$cate = new AdminCate;
			$allCateId = $cate->getchilrendid($id);
			$article=db('admin_article')->order('look desc')->where('cateid',$allCateId)->cache('articleHot'.$id)->limit(5)->select();						
		}

	}
	public function getNewArticleList()
	{
		if(!Cache::get('getNewArticleList')){
			$data = $this->alias('article')->field('article.id,article.title,article.site,article.look,article.like,article.create_time,article.cateid,article.detail,cate.catename,cate.site_keywords')->join('admin_cate cate','cate.id = article.cateid')->limit(10)->order('article.id desc')->cache('getNewArticleList')->select();			
		}

	}
	public function getIndexArticleHot()
	{
		if(!Cache::get('getIndexArticleHot')){			
			$this->order('like desc')->limit(5)->cache('getIndexArticleHot')->select();			
		}
	}
	public function getSliderArticle()
	{
		if(!Cache::get('getSliderArticle')){
			$this->where('res',1)->limit(4)->cache('getSliderArticle')->select();
		}
	}

}	


