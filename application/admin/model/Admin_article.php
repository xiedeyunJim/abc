<?php
namespace app\admin\model;
use think\Model;
use think\facade\Env;
class Admin_article extends Model{
 protected $autoWriteTimestamp = true;
    public static function init()
    {
        self::event('before_insert', function ($data) {
			if($_FILES['site']['name']){
				$file = request()->file('site');
				// dump(Env::get('root_path').'public'.DIRECTORY_SEPARATOR.'article');die;
				$info = $file->move(Env::get('root_path').'public'.DIRECTORY_SEPARATOR.'article','');
 				$site = '/article/'.$info->getSaveName();				
 				$data['site'] = $site;
 				dump($data['site']);			
			}
        });
        self::event('before_update', function ($data) {
			// dump($data);die;
			if($_FILES['site']['name']){

				$res = self::get($data['id']);
				if(Env::get('root_path').'public'.$res['site']){
					@unlink(Env::get('root_path').'public'.$res['site']);					
				}
				$file = request()->file('site');
				$info = $file->move('article','');
 				$site = '/article/'.$info->getSaveName();					
 				$data['site'] = $site;			
			}
        });
        self::event('before_delete', function ($data) {
        		
				$res = self::get($data['id']);
				if(Env::get('root_path').'public'.$res['site']){
					@unlink(Env::get('root_path').'public'.$res['site']);					
				}	
        });                 
    }

}	