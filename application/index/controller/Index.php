<?php
namespace app\index\controller;
use think\Db;
use think\Cookie;
use think\Session;
use think\Controller;


class Index extends Controller
{
    public function index()
    {
        $uid=session('userinfo.uid');
        $this->assign('uid',$uid);
        return $this->fetch('index');  
    }

    /**
     * [logout 退出]
     * @return [type] [description]
     */
    public function logout()
    {
        // session(null);
        // cookie(null);
        Session::clear();
        Cookie::clear();
        $this->success('退出成功！', url('Index/index'));
    }
}

