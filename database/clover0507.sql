/*
SQLyog Ultimate v11.25 (64 bit)
MySQL - 5.5.47 : Database - clover
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='客户管理';

/*Data for the table `syc_customer` */

insert  into `syc_customer`(`id`,`name`,`company`,`phone`,`belonguid`,`addtime`,`status`) values (1,'唐门','剑三','18761653009',2,'2018-05-07 20:15:14',0),(2,'五毒','剑三','18761653009',2,'2018-05-07 20:15:21',0),(3,'纯阳','剑三','18761653009',2,'2018-05-07 20:15:23',0),(4,'七秀','剑三','18761653009',2,'2018-05-07 20:15:24',0),(5,'少林','剑三','18761653009',1,'2018-05-07 20:15:28',0),(6,'丐帮','剑三','18761653009',1,'2018-05-07 20:15:32',0),(7,'万花','剑三','18761653009',1,'2018-05-07 20:15:30',0),(8,'仓云','剑三','18761653009',1,'2018-05-07 20:15:33',0),(9,'长歌','剑三','18761653009',1,'2018-05-07 20:15:36',0);

/*Table structure for table `syc_department` */

DROP TABLE IF EXISTS `syc_department`;

CREATE TABLE `syc_department` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `departname` varchar(30) NOT NULL DEFAULT '' COMMENT '部门名称',
  `intro` varchar(300) NOT NULL DEFAULT '' COMMENT '简介',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='部门管理';

/*Data for the table `syc_department` */

insert  into `syc_department`(`id`,`departname`,`intro`,`status`) values (1,'瓦工部','瓦工',0),(2,'设计部','设计',0);

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
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='部门商品';

/*Data for the table `syc_goods` */

insert  into `syc_goods`(`id`,`goodsname`,`goodsattribute`,`goodsunit`,`goodscostprice`,`goodsprice`,`departid`,`status`) values (1,'325水泥','32mm','','39.00','0.00',1,0);

/*Table structure for table `syc_job` */

DROP TABLE IF EXISTS `syc_job`;

CREATE TABLE `syc_job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `jobname` varchar(30) NOT NULL DEFAULT '' COMMENT '职位名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='职位表';

/*Data for the table `syc_job` */

insert  into `syc_job`(`id`,`jobname`,`status`) values (1,'总经理',0),(2,'总监',0),(3,'经理',0),(4,'主管',0),(5,'人事',0),(6,'前台',0),(7,'助理',0),(8,'顾问',0),(9,'员工',0);

/*Table structure for table `syc_menu` */

DROP TABLE IF EXISTS `syc_menu`;

CREATE TABLE `syc_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

/*Data for the table `syc_menu` */

/*Table structure for table `syc_order` */

DROP TABLE IF EXISTS `syc_order`;

CREATE TABLE `syc_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '订单名称',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '下单时间',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `condition` tinyint(2) NOT NULL DEFAULT '1' COMMENT '订单状态1进行中，2待付款，3待处理，4已完成',
  `cost` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '成本',
  `total` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `address` varchar(150) NOT NULL DEFAULT '' COMMENT '地址',
  `phone` char(15) NOT NULL DEFAULT '' COMMENT '电话',
  `predicttime` datetime NOT NULL COMMENT '预计送达时间',
  `picture` text NOT NULL COMMENT '订单图片json',
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
  `menuid` int(11) NOT NULL DEFAULT '0' COMMENT '菜单id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，9删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色菜单表';

/*Data for the table `syc_role_menu` */

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

insert  into `syc_user`(`id`,`username`,`phone`,`password`,`departid`,`jobid`,`status`) values (1,'admin','18761653009','beca4c822a33a4ee451ce470a359337d',0,0,0),(2,'漫河','18761653009','beca4c822a33a4ee451ce470a359337d',1,5,0),(3,'凡凡','18761652009','beca4c822a33a4ee451ce470a359337d',2,7,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
