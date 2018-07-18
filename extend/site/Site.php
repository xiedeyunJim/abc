<?php
namespace site;
use think\Controller;
use think\Request;
use think\Db;
use think\facade\Cache;
class Site extends Controller{
    protected function initialize()
    {
    	if(input('id')){
    		$this->getPosition(input('id'));
   		
    	}
    	if(input('articleid')){
    		$this->getArticleid(input('articleid'));

    	}
    	if(!Cache::get('nav')){
    		$this->getnav();
    	}
    	if(!Cache::get('site')){
 			$this->getSite();   		
    	}
    	$nav = Cache::get('nav');
    	$site = Cache::get('site');
    	
    	$this->assign(array(
    		'nav'=>$nav,
    		'site'=>$site,
    	));
		$this->getIndexRecBottom();    	
      
    }
function getSite()
{
	$_site = db('admin_conf')->field('enname,cnname,value')->cache(true)->select();
	$site = array();
	foreach ($_site as $key => $vo) {
		# code...
		$site[$vo['enname']] = $vo['value'];
	}
	switch ($site['cache']) {
		case '3小时':
			# code...
			Cache::set('site',$site,10800);
			break;
		case '2小时':
				# code...
			Cache::set('site',$site,7200);	
				break;
		case '1小时':
				# code...
			Cache::set('site',$site,3600);		
				break;			
		
		default:
			# code...
			break;
	}


}

function getnav()
{
	$data = db('admin_cate')->where('pid',0)->cache(true)->select();

	foreach ($data as $key => $value) {
		# code...
		$childen = db('admin_cate')->where('pid',$value['id'])->select();
		if($childen){
			$data[$key]['childen'] = $childen;
		}else{

			$data[$key]['childen'] =Null;
		}
	}
	Cache::set('nav',$data);		
}
function getPosition($id)
{
	$cate =new \app\index\model\AdminCate;
	$cate->getChilrendPrevious($id);
    $cateLocation = Cache::get('cateLocation'.$id); 	
	$this->assign(array(
		'cateLocation'=>$cateLocation,
	));


}
function getArticleid($articleid)

{
	$article = db('admin_article')->cache(true)->find($articleid);
	$cateid = $article['cateid'];
	$this->getPosition($cateid);
	$this->getRightHotArticle($cateid);
	$this->assign(array(
		'article'=>$article,
		
	));

}
function getRightHotArticle($cateid)
{
	$articleLst = new \app\index\model\AdminArticle;

	$a = $articleLst->getArticleHot($cateid);

	$articleHot  = Cache::get('articleHot'.$cateid);

	$this->assign(array('articleHot'=>$articleHot,));
}
function getIndexRecBottom()
{		
		$cate = new \app\index\model\AdminCate;
		$cate->getIndexRecBottom();
		$getIndexRecBottom = Cache::get('getIndexRecBottom');
		$this->assign(array('getIndexRecBottom'=>$getIndexRecBottom,));		
}



}	