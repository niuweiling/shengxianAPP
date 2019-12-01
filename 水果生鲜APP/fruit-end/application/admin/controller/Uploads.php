<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Uploads extends Controller
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
	    //图片上传  接受文件
	    $file = request()->file('file');

	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->validate(['size'=>20*1024,'ext'=>'webp,jpg,png,gif'])
		    ->move(ROOT_PATH .'/'. 'public' . DS . 'uploads');
	    $savename=UPLOAD_PATH.$info->getSaveName();
	    if($info){
		    // 成功上传后 获取上传信息
		    return json([
			    'code'=>config('code.success'),
			    'msg'=>'图片上传成功',
			    'src'=>$savename,
		    ]);
	    }else{
		    // 上传失败获取错误信息
		    echo $file->getError();
	    }



//        //图片上传  接受文件
//	    $file=request()->file('file');
////	    ->validate(['size'=>20*1024,'ext'=>'webp,jpg,png,gif'])
//	    $info = $file->validate(['size'=>20*1024,'ext'=>'webp,jpg,png,gif'])
//		    ->move(ROOT_PATH .'/ '.'public' . DS . 'uploads');
//	    $savename=UPLOAD_PATH.$info->getSaveName();
//
//	    if ($info){
//
//	    	return json([
//	    		'code'=>config('code.success'),
//			    'msg'=>'图片上传成功',
//			    'src'=>$savename
//
//
//		    ]);
//	    }else{
//	    	echo $file->getError();
//	    }

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
