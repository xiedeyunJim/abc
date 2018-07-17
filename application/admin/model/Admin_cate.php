<?php
namespace app\admin\model;
use think\Model;
class Admin_cate extends Model{
	public function catetree()
	{
		$cateres = $this->order("sort desc")->select();

		$data = $this->sort($cateres);
		foreach ($data as $key=>$vo) {
			# code...
			//str_repeat() 函数把字符串重复指定的次数。
			//str_repeat("Shanghai",5);
			$vo['catename'] = str_repeat('|---',$vo['level']).$vo['catename'];

		}
		return $data;		
	}
	public function sort($data,$pid=0,$level=0)
	{
		//静态数组
		static $arr = array();

		foreach($data as $key=>$vo){
			//获取到顶级栏目
			if($vo['pid'] == $pid){
				$vo['level'] = $level;
				$arr[] =$vo;
			//接下来是子栏目,使用递归方式,子ID肯定等于上级的ID,下级栏目等级加一
				$this->sort($data,$vo['id'],$level+1);				
			}
		}
		
		return $arr;
	}
	public function getchilrendid($cateid){
		//select(),是查询全部;
		$cateres = $this->select();
		//传递参数;
		return $this->_getchilrendid($cateres,$cateid);

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

}	


