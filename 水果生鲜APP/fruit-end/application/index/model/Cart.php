<?php


namespace app\index\model;


use think\Model;

class Cart extends Model
{
//  protected $table='cart';
    //获取
	public function queryone($uid){
		return $this->field('cid,total,price')->where('id',$uid)->find();
	}
	//插入
	public function insertCart($data){
		return $this->allowField(true)->save($data);
	}
	//自增
	public function cartInc($uid,$field,$value=1){
		return $this->where('id',$uid)->setInc($field,$value);
	}
	//自减
	public function cartDec($uid,$field,$value=1){
		return $this->where('id',$uid)->setDec($field,$value);
	}
	//更新
	public function cartUpdate($where,$value){
		return $this->where($where)->update($value);
	}

	public function cartDelete($where){
		return $this->where($where)->delete();
	}


}