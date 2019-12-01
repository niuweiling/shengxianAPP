<?php


namespace app\admin\model;



use think\Model;

class Goods extends Model
{

//	protected $table='Goods';//如果没有对应模型，可以起个别名进行应用

	protected $autoWriteTimestamp=true;//自动写入时间戳---针对该模型
	//添加商品
	public function insert($data){
//		$data['create_time']=time();
//		$data['update_time']=time();
//		return $this->save($data);
		return $this->allowField(true)->save($data);//引用模型扩展允许字段
	}
	public function query(){
		return $this->select();
	}
	public function del($id)
	{
		return $this->where('id',$id)->delete();
	}
	public function edit($id)
	{
		return $this->where('id',$id)->select();
	}
	public function cateupdate($arr,$id)
	{
		return $this->allowField(['id','gname','mprice','cid','sale','stock','detail','gthumb','description','norms','brand','banner'])
			->save($arr,['id'=>$id]);
//		return $this->allowField(['id','gname','gthumb','stock'])->save($arr,['id=>$id']);
	}
}