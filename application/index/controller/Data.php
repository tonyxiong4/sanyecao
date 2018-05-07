<?php
/**
 * @Author: tony
 * @Date:   2018-05-05 22:54:09
 * @Last Modified by:   tony
 * @Last Modified time: 2018-05-08 00:59:45
 */

namespace app\index\controller;
use think\Db;
use think\Controller;
/**
* 
*/
class Data extends Controller
{
	
	public function getDepart()
	{
		$list=Db::name('department')->where('status=0')->select();
		if($list){
			return $list;
		}
		return [];
	}


	public function getJob()
	{
		$list=Db::name('Job')->where('status=0')->select();
		if($list){
			return $list;
		}
		return [];
	}

	/**
	 * [addCustomser 添加客户]
	 */
	public function addCustomser()
	{
		$param=$this->request->param();
		$data=[];

		if($param){
			$data['name']=$param['custname'];
			$data['phone']=$param['custphone'];
			$data['company']=$param['custcompany'];
			$data['belonguid']=session('userinfo.uid');
		}
		$result=Db::name('customer')->insert($data);
		if($result){
			$mes['code']=200;
			$mes['msg']="添加成功";
		}else{
			$mes['code']=-1;
			$mes['msg']="添加失败";
		}
		return json($mes);
	}

	/**
	 * [delCustomser 删除客户]
	 * @return [type] [description]
	 */
	public function delCustomser()
	{
		$param=$this->request->param();
		$id=$param['id'];
		$where['id']=$id;
		$result=Db::name('customer')->where($where)->setField('status',9);
		if($result>0){
			$mes['code']=200;
			$mes['msg']="删除成功";
		}else{
			$mes['code']=-1;
			$mes['msg']="删除失败";
		}
		return json($mes);
	}
}