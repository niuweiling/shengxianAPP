<?php


namespace app\index\model;


use think\Model;

class Cartext extends Model
{
	public $table='cart_ext';
	public function queryone($data){
		return $this->where($data)->find();
	}
	//添加
	public function insertgoods($data){
		return $this->allowField(true)->save($data);
	}
	//商品自增  谁uid   哪件gid   num
	public function goodsnumInc($where){
		return $this->where($where)->setInc('num',1);
	}
	public function goodsnumDec($data){
		return $this->where($data)->setDec('num',1);
	}
	public function querygoods($uid){
		return $this->field('gid,num,status')->where('uid',$uid)->select();
	}
	//更新
	public function updategoods($where,$value){
		return $this->where($where)->update($value);
	}


	public function queryselectgoods($where){
		return $this->field('gid,num')->where($where)->select();
	}

	public function deletegoods($where){
		return $this->where($where)->delete();
	}
}