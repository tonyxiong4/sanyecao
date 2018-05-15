<?php
/**
 * @Author: tony
 * @Date:   2018-05-07 10:35:09
 * @Last Modified by:   tony
 * @Last Modified time: 2018-05-15 21:47:12
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

        $orderid=$this->request->param('orderid');
        $orderInfo=Db::name('order')->where('status',0)->where('id',$orderid)->find();
        $orderInfo['profit']=$orderInfo['total']-$orderInfo['cost'];
        $list=Db::view('orderdetail','id,goodsid,count,total,orderid,status')
                      ->view('user','username','user.id=goods.uid','LEFT')
                      ->where('status',0)
                      ->where('departid',$orderid)
                      ->paginate(10,false,['query'=>$this->request->param()]);
        $this->assign('list',$list);
        $this->assign('orderid',$orderid);
        $this->assign('orderInfo',$orderInfo);
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
        $list=Db::view('goods','id,goodsname,goodsattribute,goodsunit,goodscostprice,goodsprice,departid,uid,addtime,status')
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
    // login
    // public function login()
    // {   
    //     $departData=action('Data/getDepart');
    //     $this->assign('depart',$departData);
    //     $jobData=action('Data/getJob');
    //     $this->assign('job',$jobData);
    //     return $this->fetch('login');   
    // }

    /**
     * [doLogin 处理登录]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    // public function doLogin()
    // {
    //     $param=$this->request->param();
    //     $account=$param['account'];
    //     $userpassword=$param['password'];
    //     $md5userpassword=md5(md5($userpassword).config('passwordext'));
    //     $list=Db::name('user')->field('*')->where('username|phone',$account)->where('password',$md5userpassword)->where('status',0)->select();
    //     if(count($list)>1){
    //         $this->error('用户信息不明确，请与管理员联系！');
    //     }
    //     if($list){
    //         $info=$list[0];
    //         $userinfo=[
    //             'uid'           =>      $info['id'],
    //             'username'      =>      $info['username'],
    //             'phone'         =>      $info['phone'],
    //             'departid'      =>      $info['departid'],
    //             'jobid'         =>      $info['jobid']

    //         ];
    //         session('userinfo', $userinfo);
    //         //设置7天自动登录
    //         $expire = 3600 * 24 * 7;
    //         //本站COOKIE
    //         cookie(config('cookie_key'), config('secure_code').".{$info['id']}", $expire);
    //         $this->success('登录成功！', url('Syc/sysindex'));

    //     }else {
    //         $this->error('用户名或者密码错误！');
    //     }
    // }

    /**
     * [doRegister 处理注册]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    // public function doRegister()
    // {
    //     $param=$this->request->param();
    //     $data=[];
    //     if($param){
    //         $data['username']=$param['username'];
    //         $account=$param['username'];
    //         $data['phone']=$param['phone'];
    //         $userpassword=$param['password'];
    //         $userpass = md5(md5($userpassword).config('passwordext'));
    //         $data['password']=$userpass;
    //         $data['departid']=$param['depart'];
    //         $data['jobid']=$param['job'];
    //     }
    //     $result=Db::name('user')->insert($data);
    //     if($result){
    //         $list=Db::name('user')->field('*')->where('username|phone',$account)->where('password',$userpass)->where('status',0)->select();
    //         if(count($list)>1){
    //             $this->error('用户信息不明确，请与管理员联系！');
    //         }
    //         if($list){
    //             $info=$list[0];
    //             $userinfo=[
    //                 'uid'           =>      $info['id'],
    //                 'username'      =>      $info['username'],
    //                 'phone'         =>      $info['phone'],
    //                 'departid'      =>      $info['departid'],
    //                 'jobid'         =>      $info['jobid']

    //             ];
    //             session('userinfo', $userinfo);
    //             //设置7天自动登录
    //             $expire = 3600 * 24 * 7;
    //             //本站COOKIE
    //             cookie(config('cookie_key'), config('secure_code').".{$info['id']}", $expire);
    //         }
    //         $this->success('注册成功', 'Syc/sysindex');
    //     }else{
    //         $this->error('注册失败');
    //     }
    // }
}
