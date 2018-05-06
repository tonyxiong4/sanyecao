<?php
namespace app\index\controller;
use think\Db;
use think\Cookie;
use think\Session;
use think\Controller;


class Index extends Base
{
    public function index()
    {
        $uid=session('userinfo.uid');
        $this->assign('uid',$uid);
        return $this->fetch('index');  
    }

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
         return $this->fetch('management');
     }
    //客户管理
    public function customser()
    {
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
        return $this->fetch('myorder');
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
            $this->success('登录成功！', url('Index/sysindex'));

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
            $this->success('注册成功', 'Index/sysindex');
        }else{
            $this->error('注册失败');
        }
    }

    /**
     * [logout 退出]
     * @return [type] [description]
     */
    public function logout()
    {
        // session(null);
        // cookie(null);
        // foreach (cookie() as $key => $value) {
        //     cookie($key, null);
        // }
        Session::clear();
        Cookie::clear();
        $this->success('退出成功！', url('Index/index'));
    }
}

