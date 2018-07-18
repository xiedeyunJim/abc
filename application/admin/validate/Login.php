<?php
namespace app\admin\validate;

use think\Validate;

class Login extends Validate{
    protected $rule = [
    	'code|验证码'=>'require|captcha'
    ];
    protected $message  =[
    	'code.captcha'=>'验证码错误',
    	'code.require'=>'验证码必须填写',
    ];

}	