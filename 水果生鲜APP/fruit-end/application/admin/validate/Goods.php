<?php


namespace app\admin\validate;


use think\Validate;

class Goods extends Validate
{
	protected $rule=[
		'gname'=>'require',

	];
	protected $message=[
		'mprice'=>'mprice必填',

	];
	protected $scene=[
		'insert'=>['gname',]
	];
}