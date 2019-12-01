<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\Request;

class Cart extends Controller
{
	protected function _initialize()
	{
		parent::_initialize(); // TODO: Change the autogenerated stub
		checkToken();
	}
	//购物车添加商品
	//sale--商品价格    gid---商品id
	public function save()
	{
		$uid = $this->request->id;
		$data = $this->request->post();//获取数据
		$gid = $data['gid'];
		$sale = $data['sale'];
//		$sale=$this->request->sale;

		$model = model('Cart');
		$cart = $model->queryone($uid);//判断购物车有无
		if ($cart) {
			Db::startTrans();//启动事务
			$cid = $cart['cid'];
			$ext = model('Cartext');
			$goodsInfo = $ext->queryone(['uid' => $uid, 'gid' => $gid]);
			$insertResult = 0;
			$Incresult = 0;
			if ($goodsInfo) {
				$Incresult = $ext->goodsnumInc(['uid' => $uid, 'gid' => $gid]);
			} else {
				$insertResult = $ext->insertgoods(['cid' => $cid, 'gid' => $data['gid'],
					'num' => 1, 'status' => 1, 'uid' => $uid]);
			}
			$numberInc = $model->cartInc($uid, 'total');
			$priceInc = $model->cartInc($uid, 'price', $sale);
			if (($Incresult && $numberInc && $priceInc) || ($insertResult && $numberInc && $priceInc)) {
				Db::commit();//提交事务
				return json([
					'code' => config('code.success'),
					'msg' => "购物车添加成功",
					'data' => ['cid' => $cid, 'uid' => $uid]
				]);
			} else {
				Db::rollback();//事务回滚
				return json([
					'code' => config('code.fail'),
					'msg' => "购物车添加失败"

				]);
			}

		} else {
			Db::startTrans();
			$arr = ['id' => $uid, 'total' => 1, 'price' => $data['sale']];
			$rows = $model->insertCart($arr);
			$lastId = $model->getLastInsID();
			$goods = ['cid' => $lastId, 'gid' => $gid,
				'num' => 1, 'status' => 1, 'uid' => $uid
			];//插入到商品
			$result = Db::table('cart_ext')->insert($goods);
			if ($rows && $result) {
				Db::commit();//提交事务
				return json([
					'code' => config('code.success'),
					'msg' => "购物车添加成功",
					'data' => ['cid' => $lastId, 'uid' => $uid]
				]);
			} else {
				Db::rollback();//事务回滚
			}
		}


	}

	//读取购物车信息  api/cart/id---1(token解析id)
	public function read($id)
	{
		$uid = $this->request->id;
		$cart1 = model('Cart');
		$cart = $cart1->queryone($uid);
//		$cart2=model('Cartext');
//		$goods=$cart2->querygoods($uid);
		//购物车信息----连表查询
		$goods = Db::table('cart_ext')->alias('c')
			->field('c.gid,c.num,c.status,goods.gname,goods.sale,goods.gthumb')
			->where('uid',$uid)
			->join('goods', 'c.gid=goods.id')
			->select();


		if ($cart) {
			$cart['goods'] = $goods;
			return json([
				'code' => config('code.success'),
				'msg' => "购物车获取成功",
				'data' => $cart
			]);
		} else {
			return json([
				'code' => config('code.fail'),
				'msg' => "购物车空空空"
			]);
		}

	}
/*
 * 购物车商品状态更新
 * 1、status
 * 2、读取数据库--改
 * cart表：
 *      total---num
 *      price-num*sale
 * /api/cart/23
 * params:
 *    gid--
 *    sale
 * */
	public function update(Request $request,$id)
	{
		$data = $this->request->put();//获取数据
		$gid = $data['gid'];
		$sale = $data['sale'];
		$uid = $this->request->id;
		$sarr=['uid'=>$uid,'gid'=>$gid];//购物车当前商品
		$cart2=model('Cartext');
		$goods=$cart2->queryone($sarr);
		$status=$goods['status'] ? 0:1;//选中---未选中/附表
		$num=$goods['num'];
		Db::startTrans();//启动事务
		$goodsresult=$cart2->updategoods($sarr,['status'=>$status]);//更新附表

		$cart1=model('Cart');
		$cart=$cart1->queryone($uid);//
		$total=$cart['total'];
		$price=$cart['price'];
		if ($status){//根据状态进行加减
			$total += $num;
			$price += $num*$sale;
		}else{
			$total -= $num;
			$price -= $num*$sale;
		}
		$cartresult=$cart1->cartUpdate(['id'=>$uid],['total'=>$total,'price'=>$price]);//主表更新

		$totalresult=$cart1->cartDec($uid,'total',$num);
		$priceresult=$cart1->cartDec($uid,'price',$num*$sale);
		if ($goodsresult && $cartresult){
				Db::commit();//提交事务
				return json([
					'code' => config('code.success'),
					'msg' => "商品状态修改成功"
				]);

			} else {
				Db::rollback();//事务回滚
				return json([
					'code' => config('code.fail'),
					'msg' => "商品状态修改失败"

				]);
			}
	}
//	public function delete()
//	{
//		$uid = $this->request->id;
//		$data = $this->request->delete();//获取数据
//		$gid = $data['gid'];
//		$sale = $data['sale'];
////		$total=$data['total'];
//
//		$model = model('Cart');
//		$cart = $model->queryone($uid);//判断购物车有无
//		if ($cart) {
//			Db::startTrans();//启动事务
//			$cid = $cart['cid'];
//			$ext = model('Cartext');
//
//
//			if ('total'>=0){
//				$Decresult = $ext->goodsnumDec(['uid' => $uid, 'gid' => $gid]);
//			}
//
//			$numberDec = $cart->cartDec($uid, 'total');
//			$priceDec = $cart->cartDec($uid, 'price', $sale);
//			if ($Decresult && $numberDec && $priceDec)  {
//				Db::commit();//提交事务
//				return json([
//					'code' => config('code.success'),
//					'msg' => "购物车减少成功",
//					'data' => ['cid' => $cid, 'uid' => $uid]
//				]);
//			} else {
//				Db::rollback();//事务回滚
//				return json([
//					'code' => config('code.fail'),
//					'msg' => "购物车减少失败"
//
//				]);
//			}
//
//		}
//
//		}
}

