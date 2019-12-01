<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Category extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

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
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
//    public function read($id)
//    {
	    //
//	    $model=model('category');
//	    $result=$model->edit($id);

//	    $cate=Db::table('category')->where('id',$id)->select();
//	    for($i=0;$i<count($cate);$i++){
//		    $cid=$cate[$i]['id'];
//		    $goods= Db::table('goods')->field('id,gthumb,mprice,sale,gname,description')->where('cid',$cid)->limit(0,3)->select();
//		    $cate[$i]['goods']=$goods;
//
//	    };
//	    if(count($cate)>0){
//
//		    return json([
//			    'code'=>config('code.success'),
//			    'msg'=>'查询分类成功',
//			    'data'=>$cate
//
//		    ]);
//	    }else{
//		    return json([
//			    'code'=>config('code.success'),
//			    'msg'=>'查询分类失败',
//		    ]);
//	    }


//		$data=$model->query();
//    }



	public function read($id)
	{
		$cate=Db::table('category')->where('id',$id)->select();
		for($i=0;$i<count($cate);$i++){
			$cid=$cate[$i]['id'];
			$goods= Db::table('goods')->field('id,gthumb,mprice,sale,gname,description')->where('cid',$cid)->select();
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


//		$data=$model->query();
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
    public function update(Request $request, $id)
    {
        //
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
    }
}
