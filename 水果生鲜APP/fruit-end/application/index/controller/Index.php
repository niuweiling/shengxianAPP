<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\image\Exception;

class Index extends Controller
{
    public function index()
    {
	    //分类 商品 嵌入 不需要连表查询  二维数组 连表查询
	    $cate=Db::table('category')->field('id,thumb,cname')->order('id','asc')->limit(0,4)->select();
	    for($i=0;$i<count($cate);$i++){
		    $cid=$cate[$i]['id'];
		    $goods= Db::table('goods')->field('id,gthumb,mprice,stock,sale,gname,description')->where('cid',$cid)->limit(0,3)->select();
		    $cate[$i]['goods']=$goods;

	    };
	    if(count($cate)>0){

		    return json([
			    'code'=>config('code.success'),
			    'msg'=>'查询分类成功',
			    'data'=>$cate

		    ]);
	    }else{
		    return json([
			    'code'=>config('code.success'),
			    'msg'=>'查询分类失败',
		    ]);
	    }

    }

    public function query(){
    	//异常处理
//    	try{
//
//	    }catch (Exception $exception){
//
//	    }


//
//    	//分页  搜索   排序
//    	$data=$this->request->get();
//    	$names=$data['names'];
//    	$page=$data['page'];
//    	$limit=$data['limit'];
//    	$sarr=[
//    		'names'=>$names,
//
//	    ];
//	    $result=Db::table('student')->where($sarr)->page($page,$limit)->select();
////    	if (){
////
////	    }?
//    	$daily=Db::table('student')->where($sarr)->select();
//    	$count=count($daily);
//    	if ($count>0){
//    		return json([
//    			'code'=>config('code.success'),
//			    'msg'=>'数据获取成功',
//			    'data'=>$daily,
//			    'count'=>$count
//		    ]);
//	    }else{
//    		return json([
//			    'code'=>config('code.success'),
//			    'msg'=>'数据获取失败',
//		    ]);
//	    }
    }

	public function read($id)
	{
		//api/goods/1
		$result=Db::table('goods')->where('id',$id)->select();
		if ($result > 0) {
			return json([
				'code' => config('code.success'),
				'msg' => '查看编辑成功',
				'data'=>$result,
			]);
		} else {
			return json([
				'code' => config('code.fail'),
				'msg' => '查看编辑失败',
			]);
		}
	}


//	public function read($id)
//	{
//		$cate=Db::table('category')->where('id',$id)->select();
//		for($i=0;$i<count($cate);$i++){
//			$cid=$cate[$i]['id'];
//			$goods= Db::table('goods')->field('id,gthumb,mprice,sale,gname,description')->where('cid',$cid)->select();
//			$cate[$i]['goods']=$goods;
//
//		};
//		if(count($cate)>0){
//
//			return json([
//				'code'=>config('code.success'),
//				'msg'=>'查询分类成功',
//				'data'=>$cate
//
//			]);
//		}else{
//			return json([
//				'code'=>config('code.success'),
//				'msg'=>'查询分类失败',
//			]);
//		}
//
//
////		$data=$model->query();
//	}

}
