<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function getSite()
{
	$_site = db('admin_conf')->field('enname,cnname,value')->select();
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
	//导航分类
	$data = db('admin_cate')->where('pid',0)->select();
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
