<?php
namespace app\index\model;
use think\Model;
use think\facade\Cache;
class AdminCate extends Model{

	public function getchilrendid($cateid){
		//select(),是查询全部;
		$cateres = $this->select();
		//传递参数;
		$arr =  $this->_getchilrendid($cateres,$cateid);
		$arr[] = $cateid;
		$strId =implode(',', $arr);
		return $strId;


	}
	public function _getchilrendid($cateres,$cateid){
		static $arr = array();
		//把每一条信息循环出来，二维数组;
		//如果每一条信息的pid == 点击的ID，那么它就是属于这个ID的下级
		//使用递归，这个再一次把这个data，
		foreach($cateres as $key=>$vo){
			if($vo['pid'] == $cateid){
				//这样找到子栏目
				$arr[] = $vo['id'];
				//通过子栏目的ID，找到子栏目的子栏目
				$this->_getchilrendid($cateres,$vo['id']);
			}
		}
		return $arr;
	}
	public function getChilrendPrevious($cateid)
	{
		$cateres = $this->field('id,pid,catename')->cache(true)->select();
		$cate = $this->field('id,pid,catename')->cache(true)->find($cateid);
		// dump($cate);
		$pid =$cate['pid'];

		$arr = $this->_getChilrendPrevious($pid,$cateres);

		$arr[] = $cate;
		if(!Cache::get('cateLocation'.$cateid)){

			Cache::set('cateLocation'.$cateid,$arr);			
		}

	}
	public function _getChilrendPrevious($pid,$cateres)
	{	
		static $arr = array();
		foreach ($cateres as $key => $value) {
			if($value['id'] ==$pid){
				$arr[] = $value;
				$this->_getChilrendPrevious($value['pid'],$cateres);
			}
		}
		return $arr;
	}
	public function getIndexRecTop()
	{
		if(!Cache::get('getIndexRecTop')){
			$this->order('id desc')->where('rec_top',1)->cache("getIndexRecTop")->select();			
		}	
	}
	public function getIndexRecBottom()
	{
		if(!Cache::get('getIndexRecBottom')){
			$this->order('id desc')->where('rec_bottom',1)->cache("getIndexRecBottom")->select();	
		}
	}

}	


