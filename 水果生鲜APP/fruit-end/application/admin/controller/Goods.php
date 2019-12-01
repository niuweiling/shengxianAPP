<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\JWT;

class Goods extends Controller
{


//	protected function _initialize()//验证  token
//	{
//		checkToken();
//	}
	/**
	 * 显示资源列表
	 *
	 * @return \think\Response
	 */
	public function index()
	{
		try {
			$data = $this->request->get();
			if (isset($data['page']) && !empty($data['page'])) {
				$page = $data['page'];
			} else {
				$page = 1;
			}

			if (isset($data['limit']) && !empty($data['limit'])) {
				$limit = $data['limit'];
			} else {
				$limit = 2;
			}
			//方法2   给表起别名  防止字段，表名，重复        连表查询
//		$result=Db::table('goods')->alias('g')
//		->join('category','g.cid=category.id')
//		->page($page)->limit($limit)
//		->field("g.cid,g.id,g.gname,g.sale,g.stock,g.brand,g.mprice,g.norms,g.volume,g.description,g.gthumb,category.cname")
//		->select();
			$sarr=[];
			if (isset($data['cid']) && !empty($data['cid'])) {
				$sarr['cid'] = $data['cid'];
			}
			if (isset($data['gname']) && !empty($data['gname'])) {
				$sarr['gname'] =array( 'like','%'.$data['gname'].'%');
			}
			if (isset($data['min_price']) && !empty($data['min_price'])
				&& isset($data['max_price']) && !empty($data['max_price'])
				&&($data['min_price']<$data['max_price'])
			) {
				$sarr['sale'] = array('between',[$data['min_price'],$data['max_price']]);
			}
			else {
				$limit = 2;
			}

			$result = Db::table('goods')->alias('g')
				->join('category', 'g.cid=category.id')
			->field("g.cid,g.id,g.gname,g.sale,g.stock,g.brand,g.mprice,g.norms,g.volume,g.description,g.gthumb,category.cname")
				->where($sarr)
				->paginate($limit, false, [
					'page' => $page
				]);
			$count = $result->total();
			$goods = $result->items();
			if ($count > 0 && count($goods)>0) {
				return json([
					'code' => config('code.success'),
					'msg' => '查看商品成功',
					'data' => $goods,
					'count'=>$count

				]);
			} else {
				return json([
					'code' => config('code.fail'),
					'msg' => '暂无数据',
				]);
			}
		} catch (Exception $exception) {
			return json([
				'code'=>config('fail'),
				'msg'=>'联系管理员',
			]);
		}
	}



			//方法1
//			$model = model('Goods');
//			$data = $model->query();
//			$result=$model->select();


    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
	public function save(Request $request)
	{    //权限  身份
		//请求方式
		//验证参数
		//cname thumb sort
		$data=$this->request->post();
		$validate=validate('Goods');
		if (!$validate->scene('insert')->check($data)){
			return json([
				'code'=>config('code.fail'),
				'msg'=>$validate->getError()
			]);
		}
		$model=model('Goods');//引模型
		$result=$model->insert($data);//引方法
		$res=Db::table('goods')->where($data)->find();//查询
		if ($result){
			$payload=['id'=>$res['id']];
			$token=JWT::getToken($payload,config('jwtkey'));//头部 负载  签名  config进行配置
			return json([
				'code'=>config('code.success'),
				'msg'=>'商品添加成功',
				'data'=>[
					'token'=>$token,
				]

			]);
		}


	}

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
	public function read($id)
	{
		//
		$model=model('Goods');
		$result=$model->edit($id);

//		$data=$model->query();
		if ($result>0){
			return json([
				'code'=>config('code.success'),
				'msg'=>'编辑商品成功',
				'data'=>$result,
			]);
		}else{
			return json([
				'code'=>config('code.fail'),
				'msg'=>'编辑商品失败',

			]);
		}
	}

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
	public function update($id){
		try {
			$data = $this->request->put();
			array_splice($data,-4,4);
			$model = model('Goods');
			$result=$model->cateupdate($data,$id);
			if ($result) {
				return json([
					'code' => config('code.success'),
					'msg' => '修改成功',
					'data'=>$result,
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

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
	public function delete($id)
	{
		//
		$model=model('Goods');
		$result=$model->del($id);
		if ($result>0){
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
}
