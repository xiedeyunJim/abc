<?php
namespace app\admin\model;
use think\Model;
class Admin_auth_rule extends Model{

	public function authRuleTree()
	{
		$authRuleTree = $this->order('sort desc')->select();

		$data = $this->sort($authRuleTree);

		foreach ($data as $key => $value) {
			$value['title'] = str_repeat('!......', $value['level']).$value['title'];
		}
		return $data;
	}
	public function sort($data,$pid=0)
	{
		static $arr = array();

		foreach ($data as $key => $value) {
			if($value['pid'] ==$pid){
				$value['dataid'] =$this->getparentid($value['id']);
				$arr[] = $value;
				$this->sort($data,$value['id']);
			}
		}
		return $arr;
	}
	public function getchilrendid($id)
	{

		$authRuleChilrend = $this->select();

		return $this->_getchilrendid($authRuleChilrend,$id);


	}
	public function _getchilrendid($data,$id)
	{	

		static $arr = array();

		foreach($data as $key => $vo){
			if($vo['pid']== $id){
				
				$arr[] = $vo['id'];

				$this->_getchilrendid($data,$vo['id']); 
			}
		}
		return $arr;

	}
	public function getparentid($id)
	{
		$authRuleChilrend =$this->select();

		return $this->_getparentid($authRuleChilrend,$id,true);
	}
	public function _getparentid($data,$id,$clear=false)
	{
		static $arr = array();
		if($clear){
			$arr = array();
		}
		foreach($data as $key=>$vo){
			if($vo['id']==$id){
				$arr[] = $vo['id'];
				$this->_getparentid($data,$vo['pid'],false);
			}
		}
		asort($arr);
		$arrStr =implode('-', $arr);
		
		return $arrStr;
	}
	public function aaa()
	{
		return $this->paginate(5);
	}

}
