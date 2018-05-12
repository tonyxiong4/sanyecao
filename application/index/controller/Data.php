<?php
/**
 * @Author: tony
 * @Date:   2018-05-05 22:54:09
 * @Last Modified by:   tony
 * @Last Modified time: 2018-05-13 02:22:13
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
			$data['name']=trim($param['custname']);
			$data['phone']=trim($param['custphone']);
			$data['company']=trim($param['custcompany']);
			$data['belonguid']=session('userinfo.uid');
		}
		$isExist=$this->isExist('name',$data['name'],'customer');
		if($isExist){
			$mes['code']=100;
			$mes['msg']="该客户已经存在";
		}else{
			$result=Db::name('customer')->insert($data);
			if($result){
				$mes['code']=200;
				$mes['msg']="添加成功";
			}else{
				$mes['code']=-1;
				$mes['msg']="添加失败";
			}
		}
		
		return json($mes);
	}

	/**
	 * [isExist 查询数据是否存在]
	 * @param  string  $fieldname [字段名称]
	 * @param  string  $username  [字段值]
	 * @param  string  $tablename [表名]
	 * @return boolean            [description]
	 */
	public function isExist($fieldname="",$username="",$tablename="")
	{

		$isExist=Db::name($tablename)->where('status',0)->where($fieldname,$username)->find();
		if($isExist){
			return $isExist;
		}else{
			return false;
		}
	}


	/**
	 * [getData 通用获取数据]
	 * @param  int  $id [id]
	 * @param  string  $tablename [表名]
	 * @return boolean            [description]
	 */
	public function getData($id=0,$tablename="")
	{
		$data=Db::name($tablename)->where('status',0)->where('id',$id)->find();
		if($data){
			$mes['code']=200;
			$mes['data']=$data;
		}else{
			$mes['code']=-1;
			$mes['msg']="No Data";
		}
		return josn($mes);
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
		$result=Db::name('user')->where('id',$uid)->setField('password',$password);
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
		$uid=$this->request->param('uid');//原拥有者id
		$isExist=$this->isExist('username',$username,'user');
		
		if(!empty($isExist)){
			$newuid=$isExist['id'];
			$result=Db::name('customer')->where('belonguid',$uid)->setField('belonguid',$newuid);
			if($result>0){
				$mes['code']=200;
				$mes['msg']='转移成功';
			}else{
				$mes['code']=-1;
				$mes['msg']='转移失败';
			}
		}else{
			$mes['code']=100;
			$mes['msg']="此客户不存在请确认";
		}
		return json($mes);
	}

	/**
	 * [addGoods 添加客户]
	 */
	public function addGoods()
	{
		$param=$this->request->param();
		dump($param);

		// $data=[];

		// if($param){
		// 	$data['name']=trim($param['custname']);
		// 	$data['phone']=trim($param['custphone']);
		// 	$data['company']=trim($param['custcompany']);
		// 	$data['belonguid']=session('userinfo.uid');
		// }
		$goodsname=$param['goodsname'];
		$goodsattribute=$param['goodsattribute'];
		$param['uid']=session('userinfo.uid');
		
		$isExist=Db::name('goods')->where('status',0)->where('goodsname',$goodsname)->where('goodsattribute',$goodsattribute)->find();
		if($isExist){
			$mes['code']=100;
			$mes['msg']="该产品已经存在";
		}else{
			$result=Db::name('goods')->insert($param);
			if($result){
				$mes['code']=200;
				$mes['msg']="添加成功";
			}else{
				$mes['code']=-1;
				$mes['msg']="添加失败";
			}
		}
		return json($mes);
	}
}