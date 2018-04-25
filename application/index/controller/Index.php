<?php
namespace app\index\controller;
use app\index\model\User as UserModel;
use think\Db;
use think\Request;
use think\Controller;


class Index extends Controller
{
    public function index()
    {
        echo "file:". __FILE__."<br>";
        echo "dir:".dirname(__FILE__)."<br>";
        echo "this is ".__LINE__."hang"."<br>";
        echo "__DIR__:".__DIR__."<br>";
        echo "fucntion:".__FUNCTION__."<br>";
        echo "class:".__CLASS__."<br>";
        // $list=UserModel::all();
        $list=Db::name('user')->where('status',0)->select();
        dump($list);
        $this->assign('list',$list);
        $this->assign('count',count($list));    
        
        return $this->fetch('index');  
    }

    public function hello(Request $request, $name='linke')
    {
        echo 'url'.$request->url()."<br>";
        echo '请求参数：';
        dump($request->param());
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
}
