<?php
/**
 * @Author: tony
 * @Date:   2018-05-07 10:35:09
 * @Last Modified by:   tony
 * @Last Modified time: 2018-05-08 00:57:12
 */

namespace app\index\controller;
use think\Db;
use think\Controller;
class Syc extends Base
{
    public function hello(Request $request, $name='linke')
    {
        echo 'url'.$request->url()."<br>";
        echo '请求参数：';
        // 获取URL地址中的PATH_INFO信息
        echo 'pathinfo: ' . $request->pathinfo() . '<br/>';
        // 获取URL地址中的PATH_INFO信息 不含后缀
        echo 'pathinfo: ' . $request->path() . '<br/>';
        echo '模块：'.$request->module();
        echo '<br/>控制器：'.$request->controller();
        echo '<br/>操作：'.$request->action()."<br>";
        $this->assign('name',$name);
        
        return $this->fetch('hello');
    }
     //人员管理
     public function management()
     {
        $departData=action('Data/getDepart');
        $this->assign('depart',$departData);
        $search=$this->request->param('searchname');
        $departid=$this->request->param('depart');        
        $list=Db::view('user','id,username,phone,departid,jobid,status')
              ->view('department','departname','department.id=user.departid','LEFT')
              ->view('job','jobname','job.id=user.jobid','LEFT')
              ->where('status',0)
            //   ->where('username|phone','like','%'.$search.'%')
            //   ->where('departid',$departid)
              ->paginate(10,false,['query'=>$this->request->param()]);
        $this->assign('list',$list);
        return $this->fetch('management');
     }
    //客户管理
    public function customser()
    {
        $search=$this->request->param('searchname');
        $list=Db::view('customer','id,name,company,phone,belonguid,addtime,status')
              ->view('user','username','user.id=customer.belonguid','LEFT')
              ->where('status',0)
              ->where('name|username','like','%'.$search.'%')
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
        $data=[];
        return $this->fetch('myorder');
    }
     //订单详细
     public function myorderdetail()
     {
         return $this->fetch('myorderdetail');
     }
     //部门管理
     public function department()
     {
         return $this->fetch('department');
     }
      //產品
      public function product()
      {
          return $this->fetch('product');
      }
     //产品详细
     public function productdetail()
     {
         return $this->fetch('productdetail');
     }
    // login
    public function login()
    {   
        $departData=action('Data/getDepart');
        $this->assign('depart',$departData);
        $jobData=action('Data/getJob');
        $this->assign('job',$jobData);
        return $this->fetch('login');   
    }

    /**
     * [doLogin 处理登录]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doLogin()
    {
        $param=$this->request->param();
        $account=$param['account'];
        $userpassword=$param['password'];
        $md5userpassword=md5(md5($userpassword).config('passwordext'));
        $list=Db::name('user')->field('*')->where('username|phone',$account)->where('password',$md5userpassword)->where('status',0)->select();
        if(count($list)>1){
            $this->error('用户信息不明确，请与管理员联系！');
        }
        if($list){
            $info=$list[0];
            $userinfo=[
                'uid'           =>      $info['id'],
                'username'      =>      $info['username'],
                'phone'         =>      $info['phone'],
                'departid'      =>      $info['departid'],
                'jobid'         =>      $info['jobid']

            ];
            session('userinfo', $userinfo);
            //设置7天自动登录
            $expire = 3600 * 24 * 7;
            //本站COOKIE
            cookie(config('cookie_key'), config('secure_code').".{$info['id']}", $expire);
            $this->success('登录成功！', url('Syc/sysindex'));

        }else {
            $this->error('用户名或者密码错误！');
        }
    }

    /**
     * [doRegister 处理注册]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function doRegister()
    {
        $param=$this->request->param();
        $data=[];
        if($param){
            $data['username']=$param['username'];
            $account=$param['username'];
            $data['phone']=$param['phone'];
            $userpassword=$param['password'];
            $userpass = md5(md5($userpassword).config('passwordext'));
            $data['password']=$userpass;
            $data['departid']=$param['depart'];
            $data['jobid']=$param['job'];
        }
        $result=Db::name('user')->insert($data);
        if($result){
            $list=Db::name('user')->field('*')->where('username|phone',$account)->where('password',$userpass)->where('status',0)->select();
            if(count($list)>1){
                $this->error('用户信息不明确，请与管理员联系！');
            }
            if($list){
                $info=$list[0];
                $userinfo=[
                    'uid'           =>      $info['id'],
                    'username'      =>      $info['username'],
                    'phone'         =>      $info['phone'],
                    'departid'      =>      $info['departid'],
                    'jobid'         =>      $info['jobid']

                ];
                session('userinfo', $userinfo);
                //设置7天自动登录
                $expire = 3600 * 24 * 7;
                //本站COOKIE
                cookie(config('cookie_key'), config('secure_code').".{$info['id']}", $expire);
            }
            $this->success('注册成功', 'Syc/sysindex');
        }else{
            $this->error('注册失败');
        }
    }
}
