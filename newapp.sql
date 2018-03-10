/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : newapp

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2018-02-05 17:22:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for n_admin
-- ----------------------------
DROP TABLE IF EXISTS `n_admin`;
CREATE TABLE `n_admin` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `role_ids` varchar(100) NOT NULL DEFAULT '0' COMMENT '用户角色',
  `name` varchar(50) NOT NULL COMMENT '用户姓名',
  `password` char(32) NOT NULL COMMENT '用户密码',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `email` varchar(50) NOT NULL COMMENT '用户邮箱',
  `telephone` varchar(20) NOT NULL COMMENT '用户手机号码',
  `residence` varchar(1000) NOT NULL COMMENT '户籍',
  `address` varchar(100) NOT NULL COMMENT '用户联系地址',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户最后一次登录时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户注册时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态 1:正常，2:停用',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of n_admin
-- ----------------------------

-- ----------------------------
-- Table structure for n_admin_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `n_admin_auth_group`;
CREATE TABLE `n_admin_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '组别名称',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_manage` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1需要验证权限 2 不需要验证权限',
  `rules` char(200) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of n_admin_auth_group
-- ----------------------------
INSERT INTO `n_admin_auth_group` VALUES ('27', '超级管理员', '1', '1', '2,61,62,63,14,21,24,25,26,27,22,28,29,30,31,23,32,33,34,35,45,47,48,50,52,54,55,56');
INSERT INTO `n_admin_auth_group` VALUES ('28', '编辑', '2', '1', '2,36,38,40,42,37,39,41,43,44,60');

-- ----------------------------
-- Table structure for n_admin_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `n_admin_auth_group_access`;
CREATE TABLE `n_admin_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of n_admin_auth_group_access
-- ----------------------------
INSERT INTO `n_admin_auth_group_access` VALUES ('15', '27');
INSERT INTO `n_admin_auth_group_access` VALUES ('16', '28');
INSERT INTO `n_admin_auth_group_access` VALUES ('18', '27');

-- ----------------------------
-- Table structure for n_admin_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `n_admin_auth_rule`;
CREATE TABLE `n_admin_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '图标',
  `menu_name` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '规则唯一标识Controller/action',
  `title` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '菜单名称',
  `pid` tinyint(5) NOT NULL DEFAULT '0' COMMENT '菜单ID ',
  `is_menu` tinyint(1) DEFAULT '1' COMMENT '1:是主菜单 2 否',
  `is_race_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:是 2:不是',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of n_admin_auth_rule
-- ----------------------------
INSERT INTO `n_admin_auth_rule` VALUES ('2', '', '', '订单管理', '0', '1', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('61', '&amp;#xe62a;', 'Order/index', '订单列表', '2', '1', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('62', '&amp;#xe61b;', 'Goods/index', '商品管理', '2', '1', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('14', '', '', '权限管理', '0', '1', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('63', '1', 'Goods/myChild', '价格列表', '62', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('21', '&amp;#xe624;', 'Menu/index', '菜单管理', '14', '1', '2', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('22', '&amp;#xe612;', 'AuthGroup/authGroupList', '角色管理', '14', '1', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('23', '&amp;#xe613;', 'User/index', '用户管理', '14', '1', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('24', '13', 'Menu/addMenu', '添加菜单', '21', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('25', '213', 'Menu/editMenu', '编辑菜单', '21', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('26', '435', 'Menu/deleteMenu', '删除菜单', '21', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('27', '13', 'Menu/viewOpt', '查看三级菜单', '21', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('28', '123', 'AuthGroup/addGroup', '添加角色', '22', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('29', '35', 'AuthGroup/editGroup', '编辑角色', '22', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('30', '345', 'AuthGroup/deleteGroup', '删除角色', '22', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('31', 'asd', 'AuthGroup/ruleGroup', '分配权限', '22', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('32', '13', 'User/addUser', '添加用户', '23', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('33', '324', 'User/editUser', '编辑用户', '23', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('34', '435', 'User/deleterUser', '删除用户', '23', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('35', '234', 'AuthGroup/giveRole', '分配角色', '23', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('36', '&amp;#xe634;', 'Banner/index', 'Banner管理', '2', '1', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('37', '&amp;#xe62a;', 'News/Index', '公告管理', '2', '1', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('38', 'a', 'Banner/addBanner', '上传Banner', '36', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('39', '&amp;#xe61f;', 'News/addNews', '新增资讯', '37', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('40', '2', 'Banner/editBanner', '编缉菜单', '36', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('41', 'asdf', 'News/uploadImgForContent', '富文本图片上传', '37', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('42', '3', 'Banner/upload', '上传', '36', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('43', 'dd', 'News/editNews', '编辑资讯', '37', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('44', 'dd', 'News/deleteNews', '删除资讯', '37', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('45', '', '', '会员系统', '0', '1', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('48', '1', 'Users/addUsers', '添加会员', '47', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('47', '&amp;#xe613;', 'Users/index', '会员管理', '45', '1', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('50', '11', 'Users/checkUsers', '审核', '47', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('52', '1', 'Users/editUsers', '编缉会员', '47', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('54', '4', 'Users/myChild', '我的推荐', '47', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('55', '5', 'Users/activateUser', '激活会员', '47', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('56', '6', 'Users/forbidUser', '禁用会员', '47', '2', '1', '1', '1', '');

-- ----------------------------
-- Table structure for n_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `n_admin_user`;
CREATE TABLE `n_admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '数据编号',
  `user_name` varchar(20) CHARACTER SET utf8mb4 NOT NULL COMMENT '登录名',
  `password` varchar(32) CHARACTER SET utf8mb4 NOT NULL COMMENT '登录密码',
  `lastlogin_time` int(11) unsigned DEFAULT NULL COMMENT '最后一次登录时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许用户登录(1是  2否)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台用户表';

-- ----------------------------
-- Records of n_admin_user
-- ----------------------------
INSERT INTO `n_admin_user` VALUES ('11', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1480572245', '2');
INSERT INTO `n_admin_user` VALUES ('15', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1517715432', '1');
INSERT INTO `n_admin_user` VALUES ('16', 'test', '098f6bcd4621d373cade4e832627b4f6', '1480667348', '1');
INSERT INTO `n_admin_user` VALUES ('17', 'wuyawnen', '90b18287d7aab11bb2caee3e0c39fd08', '1480668214', '1');
INSERT INTO `n_admin_user` VALUES ('18', 'test001', 'e10adc3949ba59abbe56e057f20f883e', '1517637544', '1');

-- ----------------------------
-- Table structure for n_goods
-- ----------------------------
DROP TABLE IF EXISTS `n_goods`;
CREATE TABLE `n_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) NOT NULL COMMENT '商品名称',
  `details` text NOT NULL COMMENT '详情',
  `create_time` varchar(11) NOT NULL COMMENT '不加时间',
  `image` varchar(255) NOT NULL COMMENT '商口图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of n_goods
-- ----------------------------
INSERT INTO `n_goods` VALUES ('1', 'test', 'adsfas', '', '');

-- ----------------------------
-- Table structure for n_mscode
-- ----------------------------
DROP TABLE IF EXISTS `n_mscode`;
CREATE TABLE `n_mscode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `create_time` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='短信验证码表';

-- ----------------------------
-- Records of n_mscode
-- ----------------------------
INSERT INTO `n_mscode` VALUES ('1', '18701881920', '506243', '1517808703');
INSERT INTO `n_mscode` VALUES ('2', '18701881921', '123456', '1517808712');

-- ----------------------------
-- Table structure for n_order
-- ----------------------------
DROP TABLE IF EXISTS `n_order`;
CREATE TABLE `n_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(64) NOT NULL COMMENT '订单编号',
  `pay_type` varchar(32) NOT NULL COMMENT '支付方式',
  `pay_account` varchar(64) NOT NULL COMMENT '支付账号',
  `first_pay` decimal(10,2) NOT NULL COMMENT '第一次支付金额',
  `second_pay` decimal(10,2) NOT NULL COMMENT '第二次支付金额',
  `status` tinyint(2) NOT NULL COMMENT '订单状态',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `total` decimal(10,0) NOT NULL COMMENT '总金额',
  `create_time` varchar(11) NOT NULL COMMENT '下单时间',
  `name` varchar(32) NOT NULL COMMENT '手件人姓名',
  `phone` varchar(11) NOT NULL COMMENT '收件人手机号',
  `address` varchar(255) NOT NULL COMMENT '收人人地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of n_order
-- ----------------------------
INSERT INTO `n_order` VALUES ('1', '201802031234', '1', '12345678', '16.00', '4.00', '4', '1', '20', '', '', '', '');

-- ----------------------------
-- Table structure for n_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `n_order_goods`;
CREATE TABLE `n_order_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `create_time` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单商品列表';

-- ----------------------------
-- Records of n_order_goods
-- ----------------------------

-- ----------------------------
-- Table structure for n_package
-- ----------------------------
DROP TABLE IF EXISTS `n_package`;
CREATE TABLE `n_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `bird_price` decimal(10,2) NOT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `discount_rate` decimal(10,2) NOT NULL COMMENT '折扣率',
  `details` text NOT NULL COMMENT '描述',
  `create_time` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of n_package
-- ----------------------------
INSERT INTO `n_package` VALUES ('1', '1', 'test1', '10.00', '20.00', '50.00', 'test', '');

-- ----------------------------
-- Table structure for n_users
-- ----------------------------
DROP TABLE IF EXISTS `n_users`;
CREATE TABLE `n_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `name` varchar(255) DEFAULT NULL COMMENT '用户真实姓名',
  `status` tinyint(3) DEFAULT '0' COMMENT '状态（0：待激活；1：已激活,未审核;2：已激活,已审核；3：已禁用）',
  `phone` varchar(13) DEFAULT NULL COMMENT '手机号',
  `password` varchar(32) NOT NULL COMMENT '账户密码',
  `create_time` varchar(11) NOT NULL COMMENT '注册时间',
  `token` varchar(64) NOT NULL COMMENT 'token',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='users';

-- ----------------------------
-- Records of n_users
-- ----------------------------
INSERT INTO `n_users` VALUES ('1', 'test', '曹操', '2', '18888888888', 'e10adc3949ba59abbe56e057f20f883e', '1488508274', 'f07b571ba2a7b94212e9c821cc14c8b4');
INSERT INTO `n_users` VALUES ('2', 'ssssssss', 'ddd', '1', '18688888888', '96e79218965eb72c92a549dd5a330112', '1488508274', '');
INSERT INTO `n_users` VALUES ('3', '工要', '苛', '2', '18866666666', 'e10adc3949ba59abbe56e057f20f883e', '1488508274', '');
INSERT INTO `n_users` VALUES ('4', 'adfasd', '2131', '0', '18700001256', 'e10adc3949ba59abbe56e057f20f883e', '1488508274', '');
INSERT INTO `n_users` VALUES ('5', '11111', '系统管理员', '0', '18701881920', 'e10adc3949ba59abbe56e057f20f883e', '1488508274', '');
INSERT INTO `n_users` VALUES ('30', 'ckl', null, '0', '18701881921', 'e10adc3949ba59abbe56e057f20f883e', '1517810008', '');
