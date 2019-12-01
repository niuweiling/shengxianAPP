<?php


namespace app\admin\validate;



use think\Validate;

class Category extends Validate
{
  protected $rule=[
  	'cname'=>'require',
	  'thumb'=>'require',
	  'sort'=>'require|number'
  ];
	protected $message=[
		'thumb'=>'thumb必填',
		'cname'=>'cname必填',
		'sort'=>'sort必填数字'
	];
	protected $scene=[
		'insert'=>['cname','thumb','sort']
	];

}