<?php

/**
 * @Author: tony
 * @Date:   2018-05-06 17:17:05
 * @Last Modified by:   tony
 * @Last Modified time: 2018-05-06 18:52:19
 */
namespace app\index\controller;
use think\Db;
use think\Controller;

/**
* 
*/
class Base extends Controller
{
	/**
	 * 初始化
	 */
	public function _initialize() {
		header(config('coding'));
		if (!session("userinfo.uid")) {
			$this->quickLog();
		}
	}

	/**
	 * 快速登录
	 */
	public function quickLog() {
		$userid = $this->getCookieUid();
		if ($userid) {
			$list = Db::name('user')->where("id=$userid and status=0")->select();
			if (count($list)>1) {
				$this->error('用户信息不明确，请与管理员联系！');
			}
			if (count($list)) {
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
			else {
				header("location:". url('Index/logout'));
			}
		}
	}

	/**
	 * 取COOKIES用户ID
	 */
	private function getCookieUid() {
		$cookie_uid = null;
		if (isset($cookie_uid) && $cookie_uid !== null) {
			return $cookie_uid;
		}
		$cookie = cookie(config('cookie_key'));
		$cookie = explode(".", $cookie);
		$cookie_uid = ($cookie[0] != config('secure_code')) ? false : $cookie[1];
		return $cookie_uid;
	}
}