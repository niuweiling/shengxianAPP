<?php


namespace app\index\validate;


use think\Validate;

class Users extends Validate
{
	protected $rule = [
		'nickname' => 'require',
		'tel' => 'require',
		'password' => 'require',
	];
	protected $massage = [
		'nickname' => 'nickname字段必填',
		'tel' => 'tel字段必填',
		'password' => 'password字段必填',
	];
	protected $scene = [
		'insert' => ['nickname','tel','password']
	];
}