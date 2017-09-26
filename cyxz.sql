/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : cyxz

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-09-26 12:56:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cyxz_address
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_address`;
CREATE TABLE `cyxz_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号',
  `province` varchar(255) DEFAULT NULL COMMENT '省',
  `city` varchar(255) DEFAULT NULL COMMENT '市',
  `area` varchar(255) DEFAULT NULL COMMENT '区',
  `detail_address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `is_send` int(11) NOT NULL DEFAULT '0' COMMENT '是否寄件地址，1是，0否',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cyxz_address
-- ----------------------------
INSERT INTO `cyxz_address` VALUES ('1', '1', '张三', '110', '福建省', '泉州市', '晋江市', '磁灶镇张林村', '0', '2017-09-10 14:48:43', '2017-09-10 15:37:05');

-- ----------------------------
-- Table structure for cyxz_admin_users
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_admin_users`;
CREATE TABLE `cyxz_admin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(100) NOT NULL DEFAULT '' COMMENT '密码',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `phone` char(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常,-1删除',
  `forbidden` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1禁用,0默认',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cyxz_admin_users
-- ----------------------------
INSERT INTO `cyxz_admin_users` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '超级管理员', '', '1', '0', '', '2017-04-26 21:11:04', '2017-07-25 10:39:14');
INSERT INTO `cyxz_admin_users` VALUES ('2', 'zxd', 'e10adc3949ba59abbe56e057f20f883e', '张晓东', '13285979235', '1', '0', '', '2017-07-24 23:40:34', '2017-07-25 09:50:18');
INSERT INTO `cyxz_admin_users` VALUES ('3', 'zzx', 'e10adc3949ba59abbe56e057f20f883e', '张泽旋', '', '1', '0', '', '2017-07-25 09:50:47', '2017-07-25 09:50:47');
INSERT INTO `cyxz_admin_users` VALUES ('4', 'pgz', 'e10adc3949ba59abbe56e057f20f883e', '潘贵州', '', '1', '0', '', '2017-07-25 09:51:11', '2017-07-25 09:51:11');

-- ----------------------------
-- Table structure for cyxz_admin_users_role
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_admin_users_role`;
CREATE TABLE `cyxz_admin_users_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_users_id` int(11) NOT NULL COMMENT '管理员ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常,-1删除',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cyxz_admin_users_role
-- ----------------------------
INSERT INTO `cyxz_admin_users_role` VALUES ('2', '21', '1', '1', '2017-07-25 09:50:19', '2017-07-25 09:50:19');
INSERT INTO `cyxz_admin_users_role` VALUES ('3', '22', '1', '1', '2017-07-25 09:50:47', '2017-07-25 09:50:47');
INSERT INTO `cyxz_admin_users_role` VALUES ('4', '23', '1', '1', '2017-07-25 09:51:11', '2017-07-25 09:51:11');

-- ----------------------------
-- Table structure for cyxz_express
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_express`;
CREATE TABLE `cyxz_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) NOT NULL COMMENT '物品名称',
  `weight_type` int(11) NOT NULL DEFAULT '0' COMMENT '重量类型,0:<3,1:3-10,2:>10',
  `sender_address_id` int(11) DEFAULT NULL COMMENT '关联的寄件地址',
  `sender_name` varchar(255) DEFAULT NULL COMMENT '寄件人姓名',
  `sender_phone` varchar(255) DEFAULT NULL COMMENT '寄件人手机',
  `sender_address` varchar(255) DEFAULT NULL COMMENT '寄件人地址',
  `receiver_address_id` int(11) DEFAULT NULL COMMENT '关联的收件地址',
  `receiver_name` varchar(255) DEFAULT NULL COMMENT '收件人姓名',
  `receiver_phone` varchar(255) DEFAULT NULL COMMENT '收件人手机',
  `receiver_address` varchar(255) DEFAULT NULL COMMENT '收件人地址',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cyxz_express
-- ----------------------------
INSERT INTO `cyxz_express` VALUES ('1', '1', 'iphone8', '2', null, '张三', '110', '福建泉州', null, '李四', '119', '福建厦门', '2017-09-10 16:18:01', '2017-09-10 16:48:58');

-- ----------------------------
-- Table structure for cyxz_express_replace
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_express_replace`;
CREATE TABLE `cyxz_express_replace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `take_user_id` int(11) DEFAULT NULL COMMENT '代取用户id',
  `receiver_name` varchar(20) DEFAULT NULL COMMENT '收件人姓名',
  `receiver_phone` varchar(20) DEFAULT NULL COMMENT '收件人手机',
  `receiver_address` varchar(50) DEFAULT NULL COMMENT '收件人地址',
  `express_name` varchar(255) DEFAULT NULL COMMENT '快递名称',
  `take_code` varchar(255) DEFAULT NULL COMMENT '取货码',
  `take_time` int(11) DEFAULT NULL COMMENT '0-当天送，1-9~13:30,2-17:30~22:30',
  `weight_type` int(11) NOT NULL DEFAULT '0' COMMENT '重量类型,0:<3,1:3-10,2:>10',
  `reward` decimal(10,0) DEFAULT NULL COMMENT '报酬',
  `status` tinyint(4) DEFAULT NULL COMMENT '0未送，1已送',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cyxz_express_replace
-- ----------------------------
INSERT INTO `cyxz_express_replace` VALUES ('2', '1', '2', '张三1', '110', '福建泉州丰泽区', '苹果81', '262623623626', '2', '2', '10', '0', '2017-09-26 09:41:43', '2017-09-26 10:58:58');

-- ----------------------------
-- Table structure for cyxz_menu
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_menu`;
CREATE TABLE `cyxz_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT 'path',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `controller` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器,一级菜单,号分隔',
  `action` varchar(100) NOT NULL DEFAULT '' COMMENT '方法，逗号分隔',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '图标',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT 'url',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常,-1删除',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cyxz_menu
-- ----------------------------
INSERT INTO `cyxz_menu` VALUES ('1', '0', '0,', '系统管理', 'adminusers,auth,menu,role', '', 'fa fa-cog', '', '1', '1', '2017-06-13 21:44:26', '2017-06-13 22:01:00');
INSERT INTO `cyxz_menu` VALUES ('2', '1', '0,1,', '系统用户', 'adminusers', 'index,create,edit,read', 'fa fa-chevron-right', 'admin/AdminUsers/index', '1', '2', '2017-06-13 21:48:41', '2017-06-13 21:52:19');
INSERT INTO `cyxz_menu` VALUES ('3', '1', '0,1,', '角色管理', 'role', 'index,create,edit,read', 'fa fa-chevron-right', 'admin/role/index', '1', '3', '2017-06-13 21:49:44', '2017-06-13 21:49:44');
INSERT INTO `cyxz_menu` VALUES ('4', '1', '0,1,', '权限管理', 'auth', 'index,create,edit,read', 'fa fa-chevron-right', 'admin/auth/index', '1', '4', '2017-06-13 21:50:37', '2017-07-24 18:09:38');
INSERT INTO `cyxz_menu` VALUES ('5', '1', '0,1,', '菜单管理', 'menu', 'index,create,edit,read', 'fa fa-chevron-right', 'admin/menu/index', '1', '5', '2017-06-13 21:51:14', '2017-06-13 21:51:14');
INSERT INTO `cyxz_menu` VALUES ('6', '0', '0,', '用户管理', 'user', '', 'fa fa-cog', '', '1', '2', '2017-09-10 11:34:06', '2017-09-10 11:34:06');
INSERT INTO `cyxz_menu` VALUES ('7', '6', '0,6,', '微信用户', 'user', 'index,create,edit,read', 'fa fa-chevron-right', 'admin/user/index', '1', '1', '2017-09-10 11:35:18', '2017-09-10 11:59:47');
INSERT INTO `cyxz_menu` VALUES ('8', '0', '0,', '快递管理', 'address,express,expressreplace', '', 'fa fa-cog', '', '1', '3', '2017-09-10 14:44:31', '2017-09-26 10:15:50');
INSERT INTO `cyxz_menu` VALUES ('9', '8', '0,8,', '地址管理', 'address', 'index,create,edit,read', 'fa fa-chevron-right', 'admin/address/index', '1', '1', '2017-09-10 14:45:35', '2017-09-10 14:45:35');
INSERT INTO `cyxz_menu` VALUES ('10', '8', '0,8,', '寄件管理', 'express', 'index,create,edit,read', 'fa fa-chevron-right', 'admin/express/index', '1', '2', '2017-09-10 16:11:23', '2017-09-10 16:11:23');
INSERT INTO `cyxz_menu` VALUES ('11', '8', '0,8,', '代取管理', 'expressreplace', 'index,create,edit,read', 'fa fa-chevron-right', 'admin/ExpressReplace/index', '1', '3', '2017-09-26 09:39:20', '2017-09-26 10:15:29');

-- ----------------------------
-- Table structure for cyxz_permissions
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_permissions`;
CREATE TABLE `cyxz_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '父级ID',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT 'path',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '权限名称',
  `slug` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常,-1删除',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cyxz_permissions
-- ----------------------------
INSERT INTO `cyxz_permissions` VALUES ('1', '0', '0,', '系统管理', 'admin/system', '系统管理', '1', '2017-06-13 22:08:43', '2017-06-13 22:08:43');
INSERT INTO `cyxz_permissions` VALUES ('2', '1', '0,1,', '系统用户', 'admin/adminusers/index', '', '1', '2017-06-21 11:14:33', '2017-06-21 14:36:59');
INSERT INTO `cyxz_permissions` VALUES ('3', '1', '0,1,', '角色管理', 'admin/role/index', '', '1', '2017-06-21 11:14:07', '2017-06-21 11:14:07');
INSERT INTO `cyxz_permissions` VALUES ('4', '1', '0,1,', '权限管理', 'admin/auth/index', '', '1', '2017-06-21 11:14:53', '2017-06-21 11:14:53');
INSERT INTO `cyxz_permissions` VALUES ('5', '1', '0,1,', '菜单管理', 'admin/menu/index', '', '1', '2017-06-21 11:15:08', '2017-06-21 11:15:08');

-- ----------------------------
-- Table structure for cyxz_permissions_role
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_permissions_role`;
CREATE TABLE `cyxz_permissions_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `permissions` varchar(255) NOT NULL DEFAULT '' COMMENT '权限ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cyxz_permissions_role
-- ----------------------------
INSERT INTO `cyxz_permissions_role` VALUES ('1', '1', '2,3,4,5', '2017-06-13 22:09:35', '2017-07-25 09:49:45');

-- ----------------------------
-- Table structure for cyxz_role
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_role`;
CREATE TABLE `cyxz_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '角色名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常,-1删除',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cyxz_role
-- ----------------------------
INSERT INTO `cyxz_role` VALUES ('1', '高级管理员', '高级管理员', '1', '2017-06-13 22:09:35', '2017-07-25 09:49:44');

-- ----------------------------
-- Table structure for cyxz_user
-- ----------------------------
DROP TABLE IF EXISTS `cyxz_user`;
CREATE TABLE `cyxz_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cyxz_user
-- ----------------------------
INSERT INTO `cyxz_user` VALUES ('1', 'omd_JwwtG3grxOLxCiEaG8CL2R6U', 'nicmic', 'http://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eofC36S74lC749WlVqnxiaeqqcgbjR3wTY7GxVibZInd3wylJOSrsmygozbbDpiaHsNeFCWGpvWjecHg/0', '2017-09-10 10:30:53', '2017-09-10 11:54:04');
INSERT INTO `cyxz_user` VALUES ('4', 'omd_Jw1NET7z4BUQrm78okXS40aQ', '朝歌', 'http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJ0qh7jNE3JNOx9lbz6SWLq7wE6vHRiaveqBB2iaKgK7XIFjD2ibgsF03AxZ970k5ztFJLfBib2OyTIEg/0', '2017-09-10 11:17:24', '2017-09-10 11:17:24');
INSERT INTO `cyxz_user` VALUES ('2', 'omd_Jw2uqC9Gs_6LEF_GDwWHmIE0', '＊pgz＊', 'http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIA6mtmLmsESVpL0MCU5shhicuswmZR9tZScyQAdlx3KgHyuVYebVZQ3OB6xzDlOtNcyXmiaKKAYYmg/0', '2017-09-10 10:34:26', '2017-09-10 10:34:26');
INSERT INTO `cyxz_user` VALUES ('5', 'omd_Jw2ok2JfmkcJFddrVGVeD1-A', '九日', 'http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTK6PibiaxEI1EIibIHGYhSJakCRHlHUkO4bpEoBUyJ2mQeTBOMx34hiaricRiaOqLNxjI1b54ricqncibpTSA/0', '2017-09-21 11:58:42', '2017-09-21 11:58:42');
