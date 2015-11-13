/*
Navicat MySQL Data Transfer

Source Server         : wangleai
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : wangleai

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-11-13 16:50:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wla_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `wla_auth_group`;
CREATE TABLE `wla_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `title` char(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `rules` char(80) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id,多个规则","隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of wla_auth_group
-- ----------------------------
INSERT INTO `wla_auth_group` VALUES ('1', '作者', '1', '1,2');
INSERT INTO `wla_auth_group` VALUES ('2', '管理员', '1', '1,2');

-- ----------------------------
-- Table structure for `wla_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `wla_auth_group_access`;
CREATE TABLE `wla_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

-- ----------------------------
-- Records of wla_auth_group_access
-- ----------------------------
INSERT INTO `wla_auth_group_access` VALUES ('13', '2');
INSERT INTO `wla_auth_group_access` VALUES ('14', '1');

-- ----------------------------
-- Table structure for `wla_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `wla_auth_rule`;
CREATE TABLE `wla_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则ID',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '规则类型，如果type为1，condition字段就可以定义规则表达式。 如定义{score}>5  and {score}<100  表示用户的分数在5-100之间时这条规则才会通过。',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则附件条件,满足附加条件的规则,才认为是有效的规则',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of wla_auth_rule
-- ----------------------------
INSERT INTO `wla_auth_rule` VALUES ('1', 'Admin/User/index', '查看用户列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('2', 'Admin/User/rule', '查看规则列表', '1', '1', '');

-- ----------------------------
-- Table structure for `wla_comments`
-- ----------------------------
DROP TABLE IF EXISTS `wla_comments`;
CREATE TABLE `wla_comments` (
  `comment_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `comment_post_id` bigint(20) NOT NULL COMMENT '所属文章ID',
  `comment_author` tinytext NOT NULL COMMENT '评论者',
  `comment_author_email` varchar(100) NOT NULL COMMENT '评论者email',
  `comment_author_url` varchar(200) NOT NULL COMMENT '评论者URL',
  `comment_author_ip` varchar(15) NOT NULL COMMENT '评论者IP',
  `comment_date` int(11) NOT NULL COMMENT '评论时间',
  `comment_content` text NOT NULL COMMENT '评论内容',
  `comment_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评论状态(0:审核;1:正常;2:垃圾;)',
  `comment_agent` varchar(255) NOT NULL COMMENT '评论者浏览器信息',
  `comment_parent` bigint(20) NOT NULL DEFAULT '0' COMMENT '父评论ID',
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '评论用户ID',
  PRIMARY KEY (`comment_id`),
  KEY `comment_author_email` (`comment_author_email`) USING BTREE,
  KEY `comment_parent` (`comment_parent`) USING BTREE,
  KEY `comment_post_id` (`comment_post_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='评论表';

-- ----------------------------
-- Records of wla_comments
-- ----------------------------

-- ----------------------------
-- Table structure for `wla_posts`
-- ----------------------------
DROP TABLE IF EXISTS `wla_posts`;
CREATE TABLE `wla_posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `post_author` int(20) NOT NULL COMMENT '文章作者',
  `post_date` int(11) NOT NULL COMMENT '发布时间',
  `post_title` text NOT NULL COMMENT '文章标题',
  `post_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文章类型(0:普通;1:心情;2:音乐;3:图片;4:视频;)',
  `post_description` text NOT NULL COMMENT '文章描述',
  `post_content` longtext NOT NULL COMMENT '文章内容',
  `post_category` int(20) NOT NULL COMMENT '所属分类',
  `post_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文章状态(0:发布;1:草稿;2:锁定;3:垃圾箱)',
  `comment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评论状态(0:可以评论;1:不能评论)',
  `comment_count` bigint(20) NOT NULL DEFAULT '0' COMMENT '评论总数',
  `click_count` bigint(20) NOT NULL DEFAULT '0' COMMENT '点击数',
  PRIMARY KEY (`id`),
  KEY `post_author` (`post_author`) USING BTREE,
  KEY `type_status_date` (`id`,`post_date`,`post_type`,`post_status`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of wla_posts
-- ----------------------------

-- ----------------------------
-- Table structure for `wla_property`
-- ----------------------------
DROP TABLE IF EXISTS `wla_property`;
CREATE TABLE `wla_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` varchar(255) NOT NULL COMMENT '属性名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章属性表';

-- ----------------------------
-- Records of wla_property
-- ----------------------------

-- ----------------------------
-- Table structure for `wla_terms`
-- ----------------------------
DROP TABLE IF EXISTS `wla_terms`;
CREATE TABLE `wla_terms` (
  `term_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(200) NOT NULL COMMENT '链接名',
  `slug` varchar(200) NOT NULL COMMENT '分类、标签缩写',
  PRIMARY KEY (`term_id`),
  KEY `name` (`name`) USING BTREE,
  KEY `slug` (`slug`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='记录分类、标签的一些简要信息，包括名称，缩写。\r\n从这个表可以获得：分类、标签对应的ID，这个ID将在"wla_term_taxonomy"表中使用';

-- ----------------------------
-- Records of wla_terms
-- ----------------------------

-- ----------------------------
-- Table structure for `wla_term_relationships`
-- ----------------------------
DROP TABLE IF EXISTS `wla_term_relationships`;
CREATE TABLE `wla_term_relationships` (
  `object_id` bigint(20) NOT NULL COMMENT '博客ID',
  `term_taxonomy_id` bigint(20) NOT NULL COMMENT '对应term_taxonomy表中的term_taxonomy_id',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='关系表，多对多的，object_id是与不同的对象关联。\r\n从这个表可以获得一篇文章与标签、分类之间的关系，object_id为博文的ID，term_taxonomy_id为wp_term_taxonomy表中相应的标签、分类的ID。';

-- ----------------------------
-- Records of wla_term_relationships
-- ----------------------------

-- ----------------------------
-- Table structure for `wla_term_taxonomy`
-- ----------------------------
DROP TABLE IF EXISTS `wla_term_taxonomy`;
CREATE TABLE `wla_term_taxonomy` (
  `term_taxonomy_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '表自增ID,对应term_relationships表中的term_taxonomy_id',
  `term_id` bigint(20) NOT NULL COMMENT 'terms表中对应的term_id',
  `taxonomy` varchar(32) NOT NULL COMMENT '类型(0:category;1:tag;)',
  `description` longtext COMMENT '分类图片描述、标签描述',
  `parent` bigint(20) NOT NULL DEFAULT '0' COMMENT '父类ID',
  `count` bigint(20) NOT NULL DEFAULT '0' COMMENT '分类下文章数量、当前标签所拥有文章数量',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`) USING BTREE,
  KEY `taxonomy` (`taxonomy`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='对wp_terms中的信息的关系信息补充，有所属类型（category,tag），详细描述，父类，所拥有文章（标签）数量。';

-- ----------------------------
-- Records of wla_term_taxonomy
-- ----------------------------

-- ----------------------------
-- Table structure for `wla_user`
-- ----------------------------
DROP TABLE IF EXISTS `wla_user`;
CREATE TABLE `wla_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识',
  `username` varchar(255) NOT NULL COMMENT '登录帐号',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `display_name` varchar(255) DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `description` varchar(255) DEFAULT NULL COMMENT '简介',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '帐号状态(0-10)',
  `password_reset_key` varchar(255) DEFAULT NULL COMMENT '密码重置令牌',
  `created_at` int(11) NOT NULL COMMENT '创建于',
  `updated_at` int(11) NOT NULL COMMENT '更新于',
  `login_ip` char(20) NOT NULL COMMENT '登录ip',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  UNIQUE KEY `password_reset_key` (`password_reset_key`) USING BTREE,
  UNIQUE KEY `display_name` (`display_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of wla_user
-- ----------------------------
INSERT INTO `wla_user` VALUES ('13', 'test001', 'test001@qq.com', 'fa820cc1ad39a4e99283e9fa555035ec', null, null, null, '10', null, '1447243913', '1447403935', '127.0.0.1');
INSERT INTO `wla_user` VALUES ('14', 'test002', 'test002@qq.com', '351523b8e6eb36ae5115205886f36f86', null, null, null, '10', null, '1447249369', '1447249369', '127.0.0.1');
