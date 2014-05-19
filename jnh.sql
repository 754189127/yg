/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.0.51b-community-nt-log : Database - jnh
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jnh` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `jnh`;

/*Table structure for table `tb_company` */

DROP TABLE IF EXISTS `tb_company`;

CREATE TABLE `tb_company` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `periodicalId` mediumint(9) default NULL COMMENT '期数id',
  `companyCode` varchar(30) default NULL COMMENT '厂商编号',
  `title` varchar(50) default NULL COMMENT '厂商名称',
  `linkMan` varchar(30) default NULL COMMENT '联系人',
  `address` varchar(100) default NULL COMMENT '地址',
  `productClass` varchar(50) default NULL COMMENT '产品类别',
  `zipCode` varchar(6) default NULL COMMENT '邮编',
  `mobile1` varchar(30) default NULL COMMENT '电话1',
  `mobile2` varchar(30) default NULL COMMENT '电话2',
  `fax` varchar(15) default NULL COMMENT '传真',
  `email` varchar(30) default NULL COMMENT '邮箱',
  `needTime` datetime default NULL COMMENT '订购所需时间',
  `payMethod` tinyint(4) default NULL COMMENT '支付方式',
  `openingBank` varchar(30) default NULL COMMENT '开户行',
  `openingAccount` varchar(30) default NULL COMMENT '开户账号',
  `remark` varchar(150) default NULL COMMENT '备注',
  `addDate` datetime default NULL COMMENT '创建日期',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='厂商表';

/*Data for the table `tb_company` */

/*Table structure for table `tb_deliveryorder` */

DROP TABLE IF EXISTS `tb_deliveryorder`;

CREATE TABLE `tb_deliveryorder` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `periodicalId` mediumint(9) default NULL COMMENT '期数id',
  `orderRemittanceId` int(11) default NULL COMMENT '订购汇款id',
  `deliveryOrderCode` varchar(30) default NULL COMMENT '出货单编号',
  `packageCode` varchar(30) default NULL COMMENT '包裹编号',
  `userCode` varchar(30) default NULL COMMENT '会员编号',
  `userName` varchar(30) default NULL COMMENT '会员姓名',
  `totalSales` varchar(30) default NULL COMMENT '销货合计',
  `receivedRemittance` decimal(10,2) default NULL COMMENT '已收汇款',
  `unDiscountAmount` decimal(10,2) default NULL COMMENT '不打折金额',
  `preferentialTicket` decimal(10,2) default NULL COMMENT '抵价券',
  `discount` varchar(30) default NULL COMMENT '折扣（再输入出货单后生成）',
  `overpaidAmount` decimal(10,2) default NULL COMMENT '多付金额（多付正数，少付负数）',
  `receivableAmount` decimal(10,2) default NULL COMMENT '应收金额',
  `deliveryMethod` tinyint(4) default NULL COMMENT '寄送方式',
  `mailingDate` datetime default NULL COMMENT '邮寄日期',
  `weight` double default NULL COMMENT '重量',
  `referPostage` decimal(10,2) default NULL COMMENT '参考邮资',
  `postage` decimal(10,2) default NULL COMMENT '邮资',
  `zipCode` varchar(6) default NULL COMMENT '邮编',
  `address` varchar(100) default NULL COMMENT '地址',
  `remark` varchar(150) default NULL COMMENT '备注',
  `addDate` datetime default NULL COMMENT '创建日期',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='出货单表';

/*Data for the table `tb_deliveryorder` */

/*Table structure for table `tb_manager` */

DROP TABLE IF EXISTS `tb_manager`;

CREATE TABLE `tb_manager` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `roleId` mediumint(9) default NULL COMMENT '角色分组ID',
  `username` varchar(30) default NULL COMMENT '工号',
  `realname` varchar(30) default NULL COMMENT '姓名',
  `password` varchar(32) default NULL COMMENT '密码',
  `lastUpdateDate` date default NULL COMMENT '最后修改日期',
  `lastLoginDate` date default NULL COMMENT '最后登录日期',
  `status` mediumint(1) default '1' COMMENT '启用(0-否，1-是)',
  `remark` varchar(100) default NULL COMMENT '备注',
  `permissions` varchar(255) default NULL COMMENT '权限',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='管理员表';

/*Data for the table `tb_manager` */

insert  into `tb_manager`(`id`,`roleId`,`username`,`realname`,`password`,`lastUpdateDate`,`lastLoginDate`,`status`,`remark`,`permissions`) values (1,1,'demo','demo','fe01ce2a7fbac8fafaed7c982a04e229','2014-05-15','2014-05-15',1,NULL,'all');

/*Table structure for table `tb_member` */

DROP TABLE IF EXISTS `tb_member`;

CREATE TABLE `tb_member` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `periodicalId` smallint(6) default NULL COMMENT '期数id',
  `userCode` varchar(30) default NULL COMMENT '会员编号',
  `realName` varchar(30) default NULL COMMENT '会员姓名',
  `sex` tinyint(1) NOT NULL default '0' COMMENT '性别(1-男，2-女)',
  `source` smallint(6) default NULL COMMENT '会员来源',
  `birth` date default NULL COMMENT '生日',
  `remark` varchar(150) default NULL COMMENT '备注',
  `addDate` datetime default NULL COMMENT '加入时间',
  `lastBackPiecesDate` datetime default NULL COMMENT '最近退件时间',
  `lastLoginDate` datetime default NULL COMMENT '最近登录时间',
  `status` smallint(6) default NULL COMMENT '状态（0-临时，1-正式，2-意向）',
  `account` decimal(10,2) default NULL COMMENT '账户余额',
  `youthStuck` mediumint(9) default NULL COMMENT '青春贴',
  `isAgent` tinyint(4) default NULL COMMENT '代理（0-否，1-是）',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='会员表';

/*Data for the table `tb_member` */

insert  into `tb_member`(`id`,`periodicalId`,`userCode`,`realName`,`sex`,`source`,`birth`,`remark`,`addDate`,`lastBackPiecesDate`,`lastLoginDate`,`status`,`account`,`youthStuck`,`isAgent`) values (1,1,'00000001','name1',1,1,'1988-10-12',NULL,'2014-05-15 00:00:00','2014-05-15 00:00:00','2014-05-15 00:00:00',1,'0.00',0,0),(2,1,'00000002','name2',2,1,'1988-10-12',NULL,'2014-05-15 00:00:00','2014-05-15 00:00:00','2014-05-15 00:00:00',1,'0.00',0,0);

/*Table structure for table `tb_memberaddrlib` */

DROP TABLE IF EXISTS `tb_memberaddrlib`;

CREATE TABLE `tb_memberaddrlib` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `memberId` int(11) NOT NULL COMMENT '会员id',
  `type` tinyint(1) default NULL COMMENT '地址分类（1-家庭，2-学校）',
  `address` varchar(100) default NULL COMMENT '地址',
  `zipCode` varchar(6) default NULL COMMENT '邮编',
  `mobile` varchar(15) default NULL COMMENT '电话',
  `consignee` varchar(15) default NULL COMMENT '收货人',
  `isDefault` tinyint(1) default NULL COMMENT '默认地址（0-否，1-是）',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='会员地址库';

/*Data for the table `tb_memberaddrlib` */

insert  into `tb_memberaddrlib`(`id`,`memberId`,`type`,`address`,`zipCode`,`mobile`,`consignee`,`isDefault`) values (1,1,1,'杭州市文三西路555号','310012','1378545458','张三3',1),(2,1,2,'紫荆花路321号','310012','1358798787','李颖',0),(3,3,2,'文三西路223号','310012','1398787542','王丽',0);

/*Table structure for table `tb_orderremittance` */

DROP TABLE IF EXISTS `tb_orderremittance`;

CREATE TABLE `tb_orderremittance` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `periodicalId` mediumint(9) default NULL COMMENT '期数id',
  `memberId` int(11) default NULL COMMENT '会员id',
  `userCode` varchar(30) default NULL COMMENT '会员编号 ',
  `userName` varchar(30) default NULL COMMENT '会员姓名',
  `billNumber` varchar(50) default NULL COMMENT '汇票号码',
  `receiptProceedsOffice` varchar(50) default NULL COMMENT '收汇局',
  `remitter` varchar(30) default NULL COMMENT '汇款人',
  `remittanceAmount` decimal(10,2) default NULL COMMENT '汇款金额',
  `remittanceDate` datetime default NULL COMMENT '汇款日期',
  `preferentialTicket` decimal(10,2) default NULL COMMENT '抵价券',
  `youthStuck` mediumint(9) default NULL COMMENT '青春贴',
  `unDiscountAmount` decimal(10,2) default NULL COMMENT '不打折金额',
  `source` tinyint(4) default NULL COMMENT '订单来源',
  `postage` decimal(10,2) default NULL COMMENT '邮资',
  `zipCode` varchar(6) default NULL COMMENT '邮编',
  `address` varchar(100) default NULL COMMENT '地址',
  `remark` varchar(150) default NULL COMMENT '备注',
  `isRemittanceReceived` tinyint(1) default NULL COMMENT '是否收到汇款(0-否,1-是)',
  `remittanceReceivedDate` datetime default NULL COMMENT '收到汇款日期',
  `isOrderReceived` tinyint(1) default NULL COMMENT '是否收到订单(0-否,1-是)',
  `orderReceivedDate` datetime default NULL COMMENT '收到订单日期',
  `status` tinyint(1) default '0' COMMENT '订单状态',
  `addDate` datetime default NULL COMMENT '创建日期',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='汇款订购表(会员购买流程表) ';

/*Data for the table `tb_orderremittance` */

/*Table structure for table `tb_receipt` */

DROP TABLE IF EXISTS `tb_receipt`;

CREATE TABLE `tb_receipt` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `companyId` int(11) default NULL COMMENT '厂商id',
  `receiptCode` varchar(30) default NULL COMMENT '进货编号',
  `purchaseAmount` decimal(10,2) default NULL COMMENT '进货金额',
  `receiptDate` datetime default NULL COMMENT '进货日期',
  `remark` varchar(150) default NULL COMMENT '备注',
  `addDate` datetime default NULL COMMENT '创建日期',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='进货单表';

/*Data for the table `tb_receipt` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
