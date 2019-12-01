<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\JWT;
use think\Request;

class Login extends Controller
{
	public function save(Request $request)
	{    //权限  身份
		//请求方式
		//验证参数
		//[ nickname  password ]
		$data = $this->request->post();
		$nickname=$data['nickname'];
		$password=$data['password'];
		$salt=config('salt');//加盐
		$data['password']=md5(crypt($password,md5($salt)));//加密
//		$arr=[
//			'nickname'=>$username,
//		    'password'=>$password
//			];
//		$arr1=[
//			'tel'=>$username,
//			'password'=>$password
//		];
		$res=Db::table('users')->where('nickname|tel',$nickname)->select();
		if(count($res)<0){
			return json([
				'code'=>config('code.fail'),
				'msg'=>'该用户不存在！请先注册。'
			]);
		}
		$result=Db::table('users')->where("nickname|tel",$nickname)
			->where('password',$data['password'])->find();
		if ($result) {
			$token=JWT::getToken([
				'id'=>$result['id'],
				'nickname'=>$result['nickname']
			],config(
				'jwtkey'
			));
			return json([
				'code' => config('code.success'),
				'msg' => '登录成功',
				'token'=>$token,
				'data'=>$result,

			]);
		}else{
			return json([
				'code' => config('code.fail'),
				'msg' => '登录失败'

			]);
		}
	}

}