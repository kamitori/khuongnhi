<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {
	public static function create_log($user_id,$module_type,$content){
		$log = new Log;
		$log->user_id = $user_id;
		$log->module_type = $module_type;
		$log->content = $content;
		$log->save();
	}
}
