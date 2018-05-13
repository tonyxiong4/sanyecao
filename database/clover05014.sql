/*
SQLyog Ultimate v11.25 (64 bit)
MySQL - 5.5.53 : Database - clover
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`clover` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `clover`;

/*Table structure for table `syc_customer` */

DROP TABLE IF EXISTS `syc_customer`;

CREATE TABLE `syc_customer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '客户姓名',
  `company` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `phone` char(15) NOT NULL DEFAULT '' COMMENT '客户手机',
  `belonguid` int(11) NOT NULL DEFAULT '0' COMMENT '所属销售',
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='客户管理';

/*Data for the table `syc_customer` */

insert  into `syc_customer`(`id`,`name`,`company`,`phone`,`belonguid`,`addtime`,`status`) values (1,'唐门','剑三','18761653009',2,'2018-05-07 20:15:14',0),(2,'五毒','剑三','18761653009',2,'2018-05-07 20:15:21',0),(3,'纯阳','剑三','18761653006',2,'2018-05-07 20:15:23',0),(4,'七秀','剑三','18761653009',2,'2018-05-07 20:15:24',0),(5,'少林','剑三','18761653009',1,'2018-05-07 20:15:28',0),(6,'丐帮','剑三','18761653009',1,'2018-05-07 20:15:32',0),(7,'万花','剑三','18761653009',1,'2018-05-07 20:15:30',0),(8,'仓云','剑三','18761653009',1,'2018-05-07 20:15:33',0),(9,'长歌','剑三','18761653009',1,'2018-05-07 20:15:36',0),(12,'霸刀','剑三','18761653008',2,'2018-05-08 00:36:23',0),(13,'天水','剑三','18761653099',2,'2018-05-08 00:38:46',0),(14,'天水0','剑三','18761653099',1,'2018-05-08 00:38:46',0),(15,'天水1','剑三','18761653099',1,'2018-05-08 00:38:46',9);

/*Table structure for table `syc_department` */

DROP TABLE IF EXISTS `syc_department`;

CREATE TABLE `syc_department` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `departname` varchar(30) NOT NULL DEFAULT '' COMMENT '部门名称',
  `intro` text NOT NULL COMMENT '简介',
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='部门管理';

/*Data for the table `syc_department` */

insert  into `syc_department`(`id`,`departname`,`intro`,`addtime`,`status`) values (1,'瓦工部','瓦工','2018-05-13 01:05:38',0),(2,'水电部','水电','2018-05-13 01:05:41',0),(3,'油漆部','油漆','2018-05-13 13:28:15',0),(4,'板材部','板材','2018-05-13 13:31:38',0);

/*Table structure for table `syc_goods` */

DROP TABLE IF EXISTS `syc_goods`;

CREATE TABLE `syc_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goodsname` varchar(30) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goodsattribute` varchar(50) NOT NULL DEFAULT '' COMMENT '商品属性',
  `goodsunit` char(10) NOT NULL DEFAULT '' COMMENT '商品单位',
  `goodscostprice` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本价',
  `goodsprice` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '商品市场价',
  `departid` int(11) NOT NULL DEFAULT '0' COMMENT '部门id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '添加人',
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='部门商品';

/*Data for the table `syc_goods` */

insert  into `syc_goods`(`id`,`goodsname`,`goodsattribute`,`goodsunit`,`goodscostprice`,`goodsprice`,`departid`,`uid`,`addtime`,`status`) values (1,'325水泥','32mm','克','39.00','0.00',1,1,'2018-05-03 01:50:04',0),(2,'斯蒂芬','是地方1','是','3.30','3.30',1,2,'2018-05-13 02:19:57',0),(3,'色粉','斯蒂芬森','55','3.30','9.60',1,1,'2018-05-13 02:22:38',0),(4,'阿斯頓是df','啊第三方 范德萨','啊s斯蒂芬','6.60','5.60',1,2,'2018-05-13 02:41:52',0),(5,'阿斯頓','啊收到',' 啊s','0.00','0.00',1,1,'2018-05-13 02:44:04',0),(6,'士大夫','是f','發','0.00','0.00',1,1,'2018-05-13 02:45:45',0),(7,'红楼','单丝','爱你','3.60','5.60',1,2,'2018-05-13 14:03:52',0);

/*Table structure for table `syc_job` */

DROP TABLE IF EXISTS `syc_job`;

CREATE TABLE `syc_job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `jobname` varchar(30) NOT NULL DEFAULT '' COMMENT '职位名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='职位表';

/*Data for the table `syc_job` */

insert  into `syc_job`(`id`,`jobname`,`status`) values (1,'总经理',0),(2,'总监',0),(3,'经理',0),(4,'主管',0),(5,'人事',0),(6,'前台',0),(7,'助理',0),(8,'顾问',0),(9,'员工',0),(10,'测试员',9);

/*Table structure for table `syc_menu` */

DROP TABLE IF EXISTS `syc_menu`;

CREATE TABLE `syc_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `pxsort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `class` varchar(255) NOT NULL DEFAULT '' COMMENT '类',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='菜单表';

/*Data for the table `syc_menu` */

insert  into `syc_menu`(`id`,`name`,`url`,`pid`,`pxsort`,`class`,`status`) values (1,'我的订单','syc/myorder',0,2,'layui-icon layui-icon-template-1 layui-iconright',0),(2,'人员管理','syc/management',0,3,'layui-icon layui-icon-user layui-iconright',0),(3,'客户管理','syc/customser',0,4,'layui-icon layui-icon-component layui-iconright',0),(4,'部门管理','syc/department',0,5,'layui-icon layui-icon-chat layui-iconright',0),(5,'产品管理','syc/product',0,6,'layui-icon layui-icon-cellphone layui-iconright',0),(6,'功能权限','syc/privilege',0,7,'layui-icon layui-icon-set layui-iconright',0),(7,'首页','syc/sysindex',0,1,'layui-icon layui-icon-home layui-iconright',0);

/*Table structure for table `syc_order` */

DROP TABLE IF EXISTS `syc_order`;

CREATE TABLE `syc_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '订单名称',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '下单时间',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '订单添加人',
  `orderstatus` tinyint(2) NOT NULL DEFAULT '1' COMMENT '订单状态1进行中，2待付款，3待处理，4已完成',
  `cost` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '成本',
  `total` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `address` varchar(150) NOT NULL DEFAULT '' COMMENT '地址',
  `phone` char(15) NOT NULL DEFAULT '' COMMENT '电话',
  `predicttime` datetime NOT NULL COMMENT '预计送达时间',
  `picture` text NOT NULL COMMENT '订单图片json',
  `departid` int(11) NOT NULL DEFAULT '0' COMMENT '部门',
  `principal` int(11) NOT NULL DEFAULT '0' COMMENT '负责人',
  `remark` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

/*Data for the table `syc_order` */

/*Table structure for table `syc_orderdetail` */

DROP TABLE IF EXISTS `syc_orderdetail`;

CREATE TABLE `syc_orderdetail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goodsid` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `count` int(4) NOT NULL DEFAULT '0' COMMENT '数量',
  `total` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `orderid` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单明细';

/*Data for the table `syc_orderdetail` */

/*Table structure for table `syc_role` */

DROP TABLE IF EXISTS `syc_role`;

CREATE TABLE `syc_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';

/*Data for the table `syc_role` */

/*Table structure for table `syc_role_menu` */

DROP TABLE IF EXISTS `syc_role_menu`;

CREATE TABLE `syc_role_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `roleid` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `menuid` text NOT NULL COMMENT '菜单id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='角色菜单表';

/*Data for the table `syc_role_menu` */

insert  into `syc_role_menu`(`id`,`roleid`,`menuid`,`status`) values (1,4,'[\"3\",\"4\",\"5\"]',0),(2,5,'[\"2\",\"3\",\"4\",\"5\"]',0),(3,9,'[\"1\"]',0),(4,7,'[\"1\",\"2\",\"5\"]',0),(5,6,'[\"3\"]',0),(6,1,'[\"7\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]',0),(7,3,'[\"1\"]',0),(8,2,'[\"1\",\"3\",\"5\"]',0);

/*Table structure for table `syc_test` */

DROP TABLE IF EXISTS `syc_test`;

CREATE TABLE `syc_test` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `remark` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `syc_test` */

insert  into `syc_test`(`id`,`name`,`remark`) values (1,'素颜','苏烟'),(2,'素颜','苏烟'),(3,'素颜','苏烟'),(4,'素颜','苏烟'),(5,'素颜','苏烟'),(6,'素颜','苏烟'),(7,'素颜','苏烟'),(8,'素颜','苏烟'),(9,'素颜','苏烟'),(10,'素颜','苏烟'),(11,'素颜','苏烟');

/*Table structure for table `syc_use_role` */

DROP TABLE IF EXISTS `syc_use_role`;

CREATE TABLE `syc_use_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `roleid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色表';

/*Data for the table `syc_use_role` */

/*Table structure for table `syc_user` */

DROP TABLE IF EXISTS `syc_user`;

CREATE TABLE `syc_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `phone` char(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `departid` int(11) NOT NULL DEFAULT '0' COMMENT '部门id',
  `jobid` int(11) NOT NULL DEFAULT '0' COMMENT '职位id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `syc_user` */

insert  into `syc_user`(`id`,`username`,`phone`,`password`,`departid`,`jobid`,`status`) values (1,'admin','18761653009','beca4c822a33a4ee451ce470a359337d',0,0,0),(2,'漫河','18761653009','beca4c822a33a4ee451ce470a359337d',1,5,0),(3,'凡凡','18761652009','48128588c2af2cea05e5a48195ca1c76',2,7,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
