<?php


namespace app\admin\model;

use think\Model;
class Category extends Model
{
	protected $autoWriteTimestamp;//自动写入时间戳---针对该模型

	//分类添加
	public function insert($data){
//		$data['create_time']=time();
//		$data['update_time']=time();
//		return $this->save($data);
		return $this->allowField(true)->save($data);//引用模型允许字段
	}
	//分类查看
	public function query(){
		return $this->select();
//		return $this->field('id','cname','sort','thumb')->where(id,$id)->find();
	}
	//分类删除
	public function del($id)
	{
		return $this->where('id',$id)->delete();
	}
	//分类编辑
	public function edit($id)
	{
		return $this->where('id',$id)->select();
	}
	//分类更新
	public function cateupdate($arr,$id)
	{
		return $this->allowField(['id','cname','thumb','sort'])->save($arr,['id=>$id']);
	}
}