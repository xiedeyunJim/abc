<?php
namespace app\index\controller;
use app\index\model\AdminArticle;
use site\Site;
use think\facade\Cache;
use think\Db;
use app\index\model\AdminCate;
/*
模型查询的最佳实践原则是：
在模型外部使用静态方法进行查询，
内部使用动态方法查询，
包括使用数据库的查询构造器。模型的查询始终返回对象实例，但可以和数组一样使用。
*/
class Articlelst extends Site
{
    public function index($id)
    {


        $article = new AdminArticle;
        /*
            @articles, list列表(缓存)

            @articleHot 右侧列表(缓存)

            @
        */
        $articleRes = $article->getArticleId(input('id'));
        $articles = Cache::get('articles'.input('id'));
        $hot = $article->getArticleHot(input('id'));
        $articleHot  = Cache::get('articleHot'.input('id'));
    	$this->assign(
    		array(

                'articles' => $articles,

                'articleHot'=>$articleHot,

    		)
    	);
    
    	return $this->fetch();
    }



}

