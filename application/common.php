<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function getOrderStatus($orderstatus=0,$id=0)
{
	$strstatus='';
	switch ($orderstatus) {
		case '1':
			return '<span class="layui-badge oderPops" title="设置订单状态" data-uid='.$id.'>已形成</span>';
			break;
		case '2':
			return '<span class="layui-badge layui-bg-blue oderPops"  title="设置订单状态" data-uid='.$id.'>派单中</span>';
			break;
		case '3':
			return '<span class="layui-badge layui-bg-black oderPops"  title="设置订单状态" data-uid='.$id.'>配送中</span>';
			break;
		case '4':
			return '<span class="layui-badge layui-bg-pink oderPops" title="设置订单状态" data-uid='.$id.'>待付款</span>';
			break;
		case '5':
			return '<span class="layui-badge layui-bg-green oderPops" title="设置订单状态" data-uid='.$id.'>已完成</span>';
			break;
	}
}