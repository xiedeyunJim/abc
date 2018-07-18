<?php
namespace app\admin\controller;
use think\captcha\Captcha;
use think\captcha\Captcha;
class Captcha
{
    public function verify()
    {
		$validate = Validate::make([
			'verify|验证码'=>'require|captcha'
		]);

		$message  =[
	    	'verify.captcha'=>'验证码错误',
	    	'verify.require'=>'验证码必须填写',
	    ];		    

		$captcha = new Captcha();
		if (!$validate->check(input('verify'))) {
		    dump($validate->getError());
		}    	
        $config = [
             // 验证码字体大小
            'fontSize' => 30,
            // 验证码位数
            'length' => 4,
            // 关闭验证码杂点
            'useNoise' => true,
            // 验证码图片高度
            'imageH'   => 60,
            // 验证码图片宽度
            'imageW'   => 200,
            // 验证码过期时间（s）
            'expire'   => 1800,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
}	