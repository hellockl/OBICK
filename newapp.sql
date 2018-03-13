/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : newapp

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-03-13 22:20:27
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
INSERT INTO `n_admin_auth_group` VALUES ('27', '超级管理员', '1', '1', '2,61,62,63,14,21,24,25,26,27,22,28,29,30,31,23,32,33,34,35,37,39,41,43,44,45,47,48,50,52,54,55,56');
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
INSERT INTO `n_admin_auth_rule` VALUES ('37', '&amp;#xe62a;', 'News/Index', '公告管理', '2', '1', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('38', 'a', 'Banner/addBanner', '上传Banner', '36', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('39', '&amp;#xe61f;', 'News/addNews', '新增资讯', '37', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('40', '2', 'Banner/editBanner', '编缉菜单', '36', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('41', 'asdf', 'News/uploadImgForContent', '富文本图片上传', '37', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('42', '3', 'Banner/upload', '上传', '36', '2', '1', '1', '2', '');
INSERT INTO `n_admin_auth_rule` VALUES ('43', 'dd', 'News/editNews', '编辑资讯', '37', '2', '1', '1', '1', '');
INSERT INTO `n_admin_auth_rule` VALUES ('44', 'dd', 'News/deleteNews', '删除资讯', '37', '2', '1', '1', '1', '');
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
INSERT INTO `n_admin_user` VALUES ('15', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1520949445', '1');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of n_goods
-- ----------------------------
INSERT INTO `n_goods` VALUES ('1', 'test', 'adsfas', '');

-- ----------------------------
-- Table structure for n_news
-- ----------------------------
DROP TABLE IF EXISTS `n_news`;
CREATE TABLE `n_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `smeta` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `create_time` varchar(11) NOT NULL,
  `update_time` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of n_news
-- ----------------------------
INSERT INTO `n_news` VALUES ('1', '/Public/upload/newscontent/5aa7dabd9f125.jpg', 'aa', 'dddddddd', '1520949989', '1520950055');

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
  `idcard` varchar(18) DEFAULT NULL COMMENT '身份证号',
  `idcard_imga` varchar(255) DEFAULT NULL COMMENT '身份证正面照',
  `idcard_imgb` varchar(255) DEFAULT NULL COMMENT '身份证正面照',
  `status` tinyint(3) DEFAULT '0' COMMENT '状态（0：待激活；1：已激活,未审核;2：已激活,已审核；3：已禁用）',
  `phone` varchar(13) DEFAULT NULL COMMENT '手机号',
  `father_id` int(11) DEFAULT '0' COMMENT '上一级ID',
  `grand_id` int(11) DEFAULT '0' COMMENT '上上一级ID',
  `password` varchar(32) NOT NULL COMMENT '账户密码',
  `amount_password` varchar(32) NOT NULL COMMENT '资金密码',
  `create_time` varchar(11) NOT NULL COMMENT '注册时间',
  `alipay` varchar(255) NOT NULL COMMENT '支付宝账号',
  `wechat` varchar(255) NOT NULL COMMENT '微信号',
  `bank_card` varchar(255) NOT NULL COMMENT '银行卡号',
  `bank` varchar(255) NOT NULL COMMENT '银行',
  `is_forbid` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否禁用（0：否；1是）',
  `account` decimal(10,2) NOT NULL COMMENT '账户资金',
  `lead_account` decimal(10,2) NOT NULL COMMENT '领导奖',
  `token` varchar(64) NOT NULL COMMENT 'token',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='users';

-- ----------------------------
-- Records of n_users
-- ----------------------------
INSERT INTO `n_users` VALUES ('1', 'test', '曹操', '3604281878113132', '/Public/upload/2017-02-21/58abf8330e982.png', '/Public/upload/2017-02-27/58b39e7335048.jpg', '2', '18888888888', '4', '0', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '1488508274', '18888888888', 'ckl', '6222879845671234', '招商银行', '1', '0.00', '0.00', 'b91c4da92987767a8a300499db6d92c1');
INSERT INTO `n_users` VALUES ('2', 'ssssssss', 'ddd', null, null, null, '1', '18688888888', '1', '4', '96e79218965eb72c92a549dd5a330112', '96e79218965eb72c92a549dd5a330112', '1488508274', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('3', '工要', '苛', null, null, null, '2', '18866666666', '1', '4', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '1488508274', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('4', 'adfasd', '2131', null, null, null, '0', '18700001256', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '1488508274', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('5', '11111', '系统管理员', null, null, null, '0', '18701881920', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488508274', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('6', '22222', '系统管理员', null, null, null, '1', '18701881921', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488508274', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('7', '33333', '系统管理员', null, null, null, '0', '18701881920', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488508274', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('8', '44444', '系统管理员', null, null, null, '0', '13333333333', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488508274', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('9', 'asdfasdf', '系统管理员', null, null, null, '0', '13333333333', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488508274', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('10', 'ckl', '系统管理员', null, null, null, '2', '18701881920', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488528808', '12345', 'ddddd', '6222878978974785', '中国银行', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('11', 'abce', 'adfa', '360428', null, null, '2', '18745678978', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488529172', 'adsfasd', 'adsf', '666666', 'asdfas', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('12', 'asdfa', 'adfa', '', null, null, '2', 'adfasd', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488529229', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('13', 'asdfa111', 'adfa', '', null, null, '2', 'adfasd', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488529249', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('14', 'asdfa222', 'adfa', '', null, null, '2', 'adfasd', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488529371', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('15', 'asdfasd33', 'adsfa', 'asdfa', null, null, '2', 'asdf', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488529577', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('16', 'asdfas111', '1111', '111', null, null, '2', '1111', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488529704', '11', '111', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('17', 'adsfads', 'adsfas', 'adfad', null, null, '2', 'asdfas', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 'c33367701511b4f6020ec61ded352059', '1488529889', '', 'adfa', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('18', 'ckl12345', null, null, null, null, '0', '18702154784', '1', '4', '26cc651ec9f15708ca628bc518e28cd4', '', '2017-03-08 ', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('19', 'ckliang01', '曹操', null, null, null, '0', '18788888888', '0', '0', '9de49983b6a48545478ff3fe4e4c207c', 'e10adc3949ba59abbe56e057f20f883e', '1490173897', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('20', 'yangyang3632', 'fsa', null, null, null, '1', '13761761611', '0', '0', '39d49cd1ba775b75bed6e933b152b87f', 'aa5c3ea295d349fc4a7ce9dd4da17f37', '1490452096', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('21', '11223344', '123', null, null, null, '0', '15432343212', '0', '0', '4297f44b13955235245b2497399d7a93', '4297f44b13955235245b2497399d7a93', '1490452165', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('22', 'yangyang', '123', null, null, null, '1', '15324567890', '0', '0', '38ca692a3523e708bd93890330ff904d', '4297f44b13955235245b2497399d7a93', '1490452367', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('23', 'yangbaoqiang', 'yangbaoqiang', '310228189156156', '/Public/upload/2017-03-27/58d8f19473628.png', '/Public/upload/2017-03-27/58d8f19994636.png', '2', '13761761111', null, '0', '0fb95cefc680a795c1665ce41e4ac2d1', '12a6bf96792b7f10b3e4aabb4724b0f1', '1490611806', '13761761611', '13761761611', '6222021', '中国工商银行', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('24', 'test001', 'test001', null, null, null, '0', '18701881922', null, '0', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '1490756217', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('25', 'test003', '123456', null, null, null, '0', '18701881924', null, '0', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '1490757843', '', '', '', '', '0', '0.00', '0.00', '');
INSERT INTO `n_users` VALUES ('26', 'test006', '曹操', '3604281989110731', null, null, '0', '18701881900', '1', '4', '9cbf8a4dcb8e30682b927f352d6559a0', '', '2017-04-03 ', 'nb', 'qqq', '67777777777777', 'ada', '0', '0.00', '0.00', '');
