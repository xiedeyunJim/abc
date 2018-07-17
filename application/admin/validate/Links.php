<?php
namespace app\admin\validate;

use think\Validate;

class Links extends Validate{
    protected $rule = [
        'title'=>'require|max:25|token',
        'url' =>'url',
        'detail'=>'require|max:200',

    ];
	 protected $message  =   [ 
		'title.require'=>'网站名称必须',
		'title.max'=>'网站名称最大长度25个字符',
		'url.url'=>'url地址不正确',
		'detail.require'=>'网站摘录必须',
		'detail.max'=>'网站摘录长度不能超过200',
		'title.token'=>'请不要重复提交',
	];
    protected $scene = [
        'add'  =>  ['title','url'],
        'edit'=>['titel','url','detail'],
    ];	    	
}