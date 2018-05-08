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
	
	/**
	 * [getDepart 获取部门]
	 */
	public function getDepart()
	{
		$list=Db::name('department')->where('status=0')->select();
		if($list){
			return $list;
		}
		return [];
	}

	/**
	 * [getJob 获取职位]
	 */
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
	 * [commonDel 通用删除]
	 * @return [type] [description]
	 */
	public function commonDel()
	{
		$param=$this->request->param();
		$id=$param['id'];//id
		$tablename=$param['tablename'];
		$where['id']=$id;
		$result=Db::name($tablename)->where($where)->setField('status',9);
		if($result>0){
			$mes['code']=200;
			$mes['msg']="删除成功";
		}else{
			$mes['code']=-1;
			$mes['msg']="删除失败";
		}
		return json($mes);
	}



	/**
	 * [resetPassword 重置密码]
	 * @return [type] [description]
	 */
	public function resetPassword()
	{
		$param=$this->request->param();
		$uid=$param['uid'];
		$password=$param['password'];
		$password=md5(md5($password).config('passwordext'));
		$result=Db::name('user')->where('id',$uid)->setField('passwrod',$password);
		if($result>0){
			$mes['code']=200;
			$mes['msg']="重置成功";
		}else{
			$mes['code']=-1;
			$mes['msg']="重置失败";
		}
		return json($mes);
	}
	
	/**
	 * 转移客户
	 */
	public function transferCustomer()
	{
		$username=$this->request->param('username');
		$isExist=Db::name('user')->where('status',0)->where('username')->find();
		if(!empty($isExist)){
			//TODO 转移客户
			
		}else{
			$mes['code']=-2;
			$mes['msg']="此客户不存在请确认";
		}
		return json($mes);
	}

}