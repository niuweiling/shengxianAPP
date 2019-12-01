<?php


namespace app\index\model;


use think\Model;

class Ordersmodel extends Model
{

	protected $table='orders';
	public function insertOrders($data){
		return $this->allowField(true)->save($data);
	}
	public function queryone($where){
		return $this->where($where)->find();
	}
	public function updateOrders($where,$value){
		return $this->where($where)->update($value);
	}

}