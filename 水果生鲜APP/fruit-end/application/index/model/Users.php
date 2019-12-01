<?php


namespace app\index\model;



use think\Model;

class Users extends Model
{

//	protected $table='Goods';//如果没有对应模型，可以起个别名进行应用

	protected $autoWriteTimestamp=true;//自动写入时间戳---针对该模型

	//添加商品
	public function insert($data){
		return $this->allowField(true)->save($data);//引用模型扩展允许字段---插入数据
	}

	public function queryusers($where=[]){
		return $this->where($where)->select();
	}
	public function queryone($uid)
	{
		return $this->where('id', $uid)->find();
	}

	}