<?php
/**
 * @Author: tony
 * @Date:   2018-05-07 10:35:09
 * @Last Modified by:   tony
 * @Last Modified time: 2018-05-19 14:43:13
 */

namespace app\index\controller;
use think\Db;
use think\Controller;
class Syc extends Base
{

    public function _initialize()
    {
      $uid=session('userinfo.uid');
      
      $userjob=session('userinfo.jobid');

      if($userjob){
        $userjob=$userjob;
      }else{
        $userjob=0;
      }

      $menu='';
      $menulist=Db::name('role_menu')->where('roleid',$userjob)->value('menuid');
      
      if($menulist){
        
        $map['id']=['in',json_decode($menulist)];
        $map['status']=0;
        $menu=Db::name('menu')->where($map)->order('pxsort')->select();
      }

      //管理员看所有
      if($uid==1){
        $menu=Db::name('menu')->where('status',0)->order('pxsort')->select();
      }

      if($menu){
        $this->assign('menu',$menu);
      }else{
        $this->success('管理员没有设置此职位权限，请联系管理员开通','Index/index');
      }
    }

     //人员管理
     public function management()
     {
        $departData=action('Data/getDepart');
        $this->assign('depart',$departData);
        $jobData=action('Data/getJob');
        $this->assign('job',$jobData);
        $search=$this->request->param('searchname');
        $departid=$this->request->param('depart'); 

        $map['status']=0;
        if($departid)$map['departid']=$departid;

        $list=Db::view('user','id,username,phone,departid,jobid,status')
              ->view('department','departname','department.id=user.departid','LEFT')
              ->view('job','jobname','job.id=user.jobid','LEFT')
              ->where($map)
              ->where(function($query) use($search){
                if($search){
                  $query->where('username|phone','like','%'.$search.'%');
                }else{
                  $query->where("");
                }
              })
              ->paginate(10,false,['query'=>$this->request->param()]);
        
        $this->assign('list',$list);
        $this->assign('departid',$departid);
        return $this->fetch('management');
     }
    //客户管理
    public function customser()
    {
        $uid=session('userinfo.uid');
        $search=$this->request->param('searchname');
        $list=Db::view('customer','id,name,company,phone,belonguid,addtime,status')
              ->view('user','username','user.id=customer.belonguid','LEFT')
              ->where('status',0)
              ->where('name|username','like','%'.$search.'%')
              ->where(function($query) use($uid){
                if($uid==1){
                  $query->where("");
                }else{
                  $query->where('belonguid',$uid);
                }
              })
              ->paginate(10,false,['query'=>$this->request->param()]);
        $this->assign('list',$list);
        
        return $this->fetch('customser');
    }
    //系统首页
    public function sysindex()
    {   
      $ordercount=Db::name('order')->where('status',0)->wheretime('createtime','week')->count();
      $wcordercount=Db::name('order')->where('status',0)->where('orderstatus',5)->wheretime('createtime','week')->count();
      $departlist=Db::name('department')->where('status',0)->select();
      $day1=date("Y-m-d",strtotime("0 day"));   
      $day2=date("Y-m-d",strtotime("-1 day"));   
      $day3=date("Y-m-d",strtotime("-2 day"));   
      $day4=date("Y-m-d",strtotime("-3 day"));   
      $day5=date("Y-m-d",strtotime("-4 day"));   
      $day6=date("Y-m-d",strtotime("-5 day"));   
      $day7=date("Y-m-d",strtotime("-6 day"));  
      $days=[$day7,$day6,$day5,$day4,$day3,$day2,$day1];



      $model=Db::name('order');
      foreach ($departlist as $key => $value) {
        foreach ($days as $k => $v) {
          $departlist[$key]['count'][]=$model->where('departid',$value['id'])->where('departdate','=',$v)->sum('total');
        }
      }

      $this->assign('ordercount',$ordercount);
      $this->assign('wcordercount',$wcordercount);
      $this->assign('departlist',$departlist);
      $this->assign('days',$days);
      return $this->fetch('sysindex');
    }
    //订单
    public function myorder()
    {

        $departData=action('Data/getDepart');
        $this->assign('depart',$departData);
        $search=$this->request->param('searchname');
        $stime=$this->request->param('stime');
        $etime=$this->request->param('etime');

        $departid=$this->request->param('depart'); 

        $map['status']=0;
        if($departid)$map['departid']=$departid;
        if($search)$map['name']=['like','%'.$search.'%'];
        if($stime)$map['createtime']=['>= time',$stime];
        if($etime)$map['createtime']=['<= time',$etime];

        $list=Db::view('order','id,name,createtime,uid,orderstatus,cost,total,address,phone,picture,departid,principal,remark,status,predicttime')
              ->view('department','departname','department.id=order.departid','LEFT')
              ->view('user','username','user.id=order.uid','LEFT')
              ->view(['syc_user'=>'fzuser'],['username'=>'fzname'],'fzuser.id=order.principal','LEFT')
              ->where($map)
              ->paginate(10,false,['query'=>$this->request->param()]);
        $this->assign('list',$list);
        
        $this->assign('departid',$departid);
        return $this->fetch('myorder');
    }
     //订单详细
     public function myorderdetail()
     {

        //部门
        $departData=action('Data/getDepart');
        $this->assign('depart',$departData);


        $orderid=$this->request->param('orderid');
        $imglist=Db::name('orderimg')->where('status',0)->where('orderid',$orderid)->select();
        $orderInfo=Db::name('order')->where('status',0)->where('id',$orderid)->find();
        $orderInfo['profit']=$orderInfo['total']-$orderInfo['cost'];
        $list=Db::name('orderdetail')
                ->where('status',0)
                ->where('orderid',$orderid)
                ->paginate(10,false,['query'=>$this->request->param()]);
        $this->assign('list',$list);
        $this->assign('orderid',$orderid);
        $this->assign('orderInfo',$orderInfo);
        $this->assign('imglist',$imglist);
        return $this->fetch('myorderdetail');
     }
     //部门管理
     public function department()
     {
        $list=Db::name('department')->where('status=0')->paginate(10);
        $this->assign('list',$list);
        return $this->fetch('department');
     }

     public function setAuth()
     {
        $jobid=$this->request->param('jobid');
        $list=Db::name('menu')->where('status',0)->order('pxsort')->paginate(10);
        $authlist=Db::name('role_menu')->where('roleid',$jobid)->value('menuid');
        if($authlist){
          $authlist=json_decode($authlist);
        }
        $this->assign('authlist',$authlist);
        $this->assign('list',$list);
        $this->assign('jobid',$jobid);
        return $this->fetch('setauth');
     }
      //產品
      public function product()
      {
        $list=Db::name('department')->where('status=0')->paginate(10);
        $this->assign('list',$list);
        return $this->fetch('product');
      }
     //产品详细
     public function productdetail()
     {
        $departid=$this->request->param('departid');
        $search=$this->request->param('searchname');
        $list=Db::view('goods','id,goodsname,goodsattribute,goodsunit,goodscostprice,goodsprice,truckage,departid,uid,addtime,status')
                      ->view('user','username','user.id=goods.uid','LEFT')
                      ->where('status',0)
                      ->where('departid',$departid)
                      ->where('goodsname','like','%'.$search.'%')
                      ->paginate(10,false,['query'=>$this->request->param()]);
        $this->assign('list',$list);
        $this->assign('departid',$departid);

        return $this->fetch('productdetail');
     }
     //权限设置
     public function privilege()
     {  
        $list=Db::name('job')->where('status=0')->paginate(10);
        $this->assign('list',$list);
        return $this->fetch('privilege');
     }
}
