<?php


namespace app\admin\controller;


use think\Controller;

use think\Db;
use think\JWT;
use think\Request;

class Category extends Controller
{
//	protected function _initialize()//验证  token
//	{
//		checkToken();
//	}
//查看分类
	public function index(){
		try {
			$model = model('Category');
			$data = $model->query();
			$result=$model->select();
	if ($result > 0) {
		return json([
			'code' => config('code.success'),
			'msg' => '查看成功',
			'data'=>$data,
		]);
	} else {
		return json([
			'code' => config('code.fail'),
			'msg' => '查看失败',
		]);
	}
		}
		catch (Exception $exception) {
			return json([
				'code' => config('code.fail'),
				'msg' => '联系管理员',
			]);
        }
	}
//添加分类
	public function save(Request $request)
	{    //权限  身份
		//请求方式
		//验证参数
		//cname thumb sort
		$data=$this->request->post();
		$validate=validate('Category');
		if (!$validate->scene('insert')->check($data)){
			return json([
				'code'=>config('code.fail'),
				'msg'=>$validate->getError()
			]);

	}
		$model=model('Category');
		$result=$model->insert($data);
		$res=Db::table('category')->where($data)->find();//查询
		if ($result){
			$payload=['id'=>$res['id']];
			$token=JWT::getToken($payload,config('jwtkey'));//头部 负载  签名  config进行配置
			return json([
				'code'=>config('code.success'),
				'msg'=>'分类添加成功',
				'data'=>[
					'token'=>$token,
//					'cname'=>$result['cname']
				]

			]);
		}


	}
//删除分类
	public function delete($id)
	{
		//
		$model=model('category');
		$result=$model->del($id);
		if ($result){
			return json([
				'code'=>config('code.success'),
				'msg'=>'删除分类成功',
			]);
		}else{
			return json([
				'code'=>config('code.fail'),
				'msg'=>'删除分类失败',

			]);
		}
	}
//编辑分类
	public function read($id)
	{
		//
		$model=model('category');
		$result=$model->edit($id);

//		$data=$model->query();
		if ($result){
			return json([
				'code'=>config('code.success'),
				'msg'=>'编辑分类成功',
				'data'=>$result,
			]);
		}else{
			return json([
				'code'=>config('code.fail'),
				'msg'=>'编辑分类失败',

			]);
		}
	}
//更新分类
	public function update($id){
		try {
			$data = $this->request->put();
			array_splice($data,-2,2);
			$model = model('Category');
			$result=$model->cateupdate($data,$id);
			if ($result > 0) {
				return json([
					'code' => config('code.success'),
					'msg' => '修改成功',
					'data'=>$data,
				]);
			} else {
				return json([
					'code' => config('code.fail'),
					'msg' => '修改失败',
				]);
			}
		}
		catch (Exception $exception) {
			return json([
				'code' => config('code.fail'),
				'msg' => '联系管理员',
			]);
		}
	}


}