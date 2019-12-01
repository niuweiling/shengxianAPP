<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\JWT;

class Login extends Controller
{
	public function index(){
		$data=$this->request->post();//请求
		$salt=config('salt');//加盐
		$password=$data['password'];//密码
		$data['password']=md5(crypt($password,md5($salt)));//加密
//		$data['password']=md5($password);//加密
		$result=Db::table('manage')->where($data)->find();//查询
		if ($result){
			$payload=['id'=>$result['id'],'nicknames'=>$result['names']];
			$token=JWT::getToken($payload,config('jwtkey'));//头部 负载  签名  config进行配置

			return json([
				'code'=>config('code.success'),
				'msg'=>'登录成功',
				'data'=>[
					'token'=>$token,
					'names'=>$result['names']
				]
			]);
			}else{
			return json([
				'code'=>config('code.success'),
			    'msg'=>'登录失败'
			]);
		}
//		dump($data);
//		dump($password);
	}
}