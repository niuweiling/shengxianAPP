<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\JWT;
use think\Request;

class User extends Controller
{
	public function save(Request $request)
	{
		//nickname  password  tel
		$data = $this->request->post();
		$validate=validate('Users');
		if (!$validate->scene('insert')->check($data)){
			return json([
				'code'=>config('code.fail'),
				'msg'=>$validate->getError()
			]);
		}

		$model=model('Users');//引模型
		$result=$model->queryusers(['tel'=>$data['tel']]);

		if (count($result)>0) {
			return json([
				'code' => config('code.fail'),
				'msg' => '已注册'

			]);
		}
		$password=$data['password'];
		$salt=config('salt');//加盐
		$data['password']=md5(crypt($password,md5($salt)));//加密
		$res = $model->insert($data);//引方法
//		$res = Db::table('users')->where($data)->find();//查询


		if ($res) {
			return json([
				'code' => config('code.success'),
				'msg' => '注册成功',

			]);
		}else{
			return json([
				'code' => config('code.fail'),
				'msg' => '注册失败',

			]);
		}

	}
	public function read($id)
	{
		//
		checkToken();
		$uid=$this->request->id;
		$nickname=$this->request->header('nickname');
		$model=model('Users');
		$user=$model->queryone($uid);
		$user['sexname']=SexCodeTOKen($user->sex);
		echo $uid,$nickname;
		if($user){
			return json([
				'code'=>config('code.success'),
				'msg'=>'用户信息获取成功',
				'data'=>$user

			]);
		}
		else{
			return json([
				'code'=>config('code.fail'),
				'msg'=>'用户信息获取失败',
			]);
		}

	}

}