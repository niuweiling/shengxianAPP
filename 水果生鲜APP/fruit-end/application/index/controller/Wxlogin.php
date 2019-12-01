<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\JWT;
use think\Request;

class Wxlogin extends Controller
{
	public function index(){
		$code=$this->request->get('code');
		$url="https://api.weixin.qq.com/sns/jscode2session?appid=wx03eee173221240d2&secret=8f36e11cb133d5a1112aa018cf222b8f&js_code=$code&grant_type=authorization_code";
		$data=json_decode(file_get_contents($url));
		if ($data->openid){

			return json([
				'code'=>200,
				'openid'=>$data->openid,
				'msg'=>'openid获取成功'
//			'data'=>$url
			]);

		}else{
			return json([
				'code'=>400,
				'openid'=>$data->openid,
				'msg'=>$data->errmsg,
//			'data'=>$url
			]);
		}

	}


	public function save(Request $request)
	{
		//
		$arr=[];
		$data=$this->request->post();
//		var_dump($data);
		$arr['nickname']=$data['nickName'];
//		var_dump($arr['nickname']);
//		exit();
		$arr['sex']=$data['gender'];
		$arr['avatar']=$data['avatarUrl'];
		$arr['tel']=time();
		$arr['password']=$data['openid'];
		$arr['update_time']=time();
		$arr['create_time']=time();
		$res=Db::table('users')->where('password',$data['openid'])->find();
		if ($res){
			$token=JWT::getToken(['id'=>$res['id'],'nickname'=>$data['nickName']],config('jwtkey'));
			return json([
				'code'=>200,
				'msg'=>'用户登录成功',
				'token'=>$token
			]);
			return;
		}
		$result=Db::table('users')->insertGetId($arr);
		if ($result){
			$token=JWT::getToken(['id'=>$result,'nickname'=>$data['nickName']],config('jwtkey'));
			return json([
				'code'=>200,
				'msg'=>'用户注册成功',
				'token'=>$token
			]);
		}else {
			return json([
				'code' => 200,
				'msg' => '用户注册失败'
			]);
		}

	}

}