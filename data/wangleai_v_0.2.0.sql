/*
Navicat MySQL Data Transfer

Source Server         : wangleai
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : wangleai

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2015-12-01 20:56:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wla_active_record`
-- ----------------------------
DROP TABLE IF EXISTS `wla_active_record`;
CREATE TABLE `wla_active_record` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `dateline` int(11) NOT NULL COMMENT '操作时间',
  `ip` char(255) NOT NULL COMMENT '操作IP',
  `module` varchar(255) NOT NULL COMMENT '操作模块',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户操作记录表';

-- ----------------------------
-- Records of wla_active_record
-- ----------------------------

-- ----------------------------
-- Table structure for `wla_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `wla_auth_group`;
CREATE TABLE `wla_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `title` char(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `rules` varchar(255) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id,多个规则","隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of wla_auth_group
-- ----------------------------
INSERT INTO `wla_auth_group` VALUES ('1', '管理员', '1', '62,61,60,59,58,57,56,55,54,53,52,51,50,49,48,47,46,45,44,43,42,41,40,39,38,37,36,35,34,33,32,31,30,29,28,27,26,25,24,23,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1');
INSERT INTO `wla_auth_group` VALUES ('2', '作者', '1', '62,50,49,46,11,7,6,5,4,3,2,1');

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
INSERT INTO `wla_auth_group_access` VALUES ('10', '1');
INSERT INTO `wla_auth_group_access` VALUES ('11', '2');

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
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of wla_auth_rule
-- ----------------------------
INSERT INTO `wla_auth_rule` VALUES ('1', 'Admin/Articles/index', '文章列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('2', 'Admin/Articles/addArticle', '添加文章', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('3', 'Admin/Articles/getTags', '异步获取相似标签', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('4', 'Admin/Articles/addArticleForm', '添加文章表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('5', 'Admin/Articles/updateArticle', '修改文章', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('6', 'Admin/Articles/updateArticleForm', '修改文章表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('7', 'Admin/Articles/getArticlesByTerm', '根据分类/标签获取文章列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('8', 'Admin/Articles/trash', '文章回收站', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('9', 'Admin/Articles/addtrash', '将文章扔到垃圾箱', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('10', 'Admin/Articles/repeal', '撤销垃圾文章', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('11', 'Admin/Articles/release', '发布文章', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('12', 'Admin/Articles/deleteArticle', '删除文章', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('13', 'Admin/Category/index', '分类列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('14', 'Admin/Category/addCategory', '添加分类', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('15', 'Admin/Category/addCategoryForm', '添加分类表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('16', 'Admin/Category/updateCategory', '修改分类', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('17', 'Admin/Category/updateCategoryForm', '修改分类表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('18', 'Admin/Category/deleteCategory', '删除分类', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('19', 'Admin/Category/tags', '标签列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('20', 'Admin/Category/addTag', '添加标签', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('21', 'Admin/Category/addTagForm', '添加标签表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('22', 'Admin/Category/updateTag', '修改标签', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('23', 'Admin/Category/updateTagForm', '修改标签表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('24', 'Admin/Category/deleteTag', '删除标签', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('25', 'Admin/Category/sort', '分类排序', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('26', 'Admin/Comments/index', '评论列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('27', 'Admin/Comments/audit', '评论(批准/驳回/垃圾/扔到回收站)', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('28', 'Admin/Comments/copending', '待审评论列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('29', 'Admin/Comments/junk', '垃圾评论列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('30', 'Admin/Comments/trash', '评论回收站', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('31', 'Admin/Comments/getCommentsByArticle', '通过文章查看所有已通过审核评论', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('32', 'Admin/Comments/reply', '回复评论', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('33', 'Admin/Comments/delete', '删除评论', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('34', 'Admin/Comments/update', '编辑评论', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('35', 'Admin/System/index', '系统基本设置', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('36', 'Admin/System/updateBasic', '基本设置提交表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('37', 'Admin/System/comment', '评论设置', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('38', 'Admin/System/updateComment', '评论设置提交表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('39', 'Admin/System/page', '分页设置', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('40', 'Admin/System/updatePage', '分页设置提交表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('41', 'Admin/System/upload', '上传设置', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('42', 'Admin/System/updateUpload', '上传设置提交表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('43', 'Admin/System/verify', '验证码设置', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('44', 'Admin/System/updateVerify', '验证码设置提交表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('45', 'Admin/User/index', '用户列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('46', 'Admin/User/details', '用户详情', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('47', 'Admin/User/addUser', '添加用户', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('48', 'Admin/User/addUserForm', '添加用户表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('49', 'Admin/User/updateUser', '修改用户', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('50', 'Admin/User/updateUserForm', '修改用户表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('51', 'Admin/User/deleteUser', '删除用户', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('52', 'Admin/User/group', '角色列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('53', 'Admin/User/addGroup', '添加角色', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('54', 'Admin/User/addGroupForm', '添加角色表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('55', 'Admin/User/updateGroup', '修改角色', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('56', 'Admin/User/updateGroupForm', '修改角色表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('57', 'Admin/User/rule', '权限列表', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('58', 'Admin/User/addRule', '添加权限', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('59', 'Admin/User/addRuleForm', '添加权限表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('60', 'Admin/User/updateRule', '修改权限', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('61', 'Admin/User/updateRuleForm', '修改权限表单', '1', '1', '');
INSERT INTO `wla_auth_rule` VALUES ('62', 'Admin/User/upload', '上传头像', '1', '1', '');

-- ----------------------------
-- Table structure for `wla_comments`
-- ----------------------------
DROP TABLE IF EXISTS `wla_comments`;
CREATE TABLE `wla_comments` (
  `comment_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `comment_post_id` bigint(20) NOT NULL COMMENT '所属文章ID',
  `comment_author` varchar(255) NOT NULL COMMENT '评论者',
  `comment_author_email` varchar(100) NOT NULL COMMENT '评论者email',
  `comment_author_url` varchar(200) NOT NULL COMMENT '评论者URL',
  `comment_author_ip` varchar(15) NOT NULL COMMENT '评论者IP',
  `created_at` int(11) NOT NULL COMMENT '评论时间',
  `comment_content` text NOT NULL COMMENT '评论内容',
  `comment_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评论状态(0:审核;1:正常;2:垃圾;3:回收站)',
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
  `post_author` varchar(255) NOT NULL COMMENT '文章作者',
  `created_at` int(11) NOT NULL COMMENT '发布时间',
  `post_title` text NOT NULL COMMENT '文章标题',
  `post_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文章类型(0:普通;1:心情;2:音乐;3:图片;4:视频;)',
  `post_description` text NOT NULL COMMENT '文章描述',
  `post_content` longtext NOT NULL COMMENT '文章内容',
  `post_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文章状态(0:发布;1:草稿;2:垃圾箱)',
  `comment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评论状态(0:可以评论;1:不能评论)',
  `comment_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '评论总数',
  `click_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `post_author` (`post_author`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of wla_posts
-- ----------------------------

-- ----------------------------
-- Table structure for `wla_post_term`
-- ----------------------------
DROP TABLE IF EXISTS `wla_post_term`;
CREATE TABLE `wla_post_term` (
  `post_id` bigint(20) NOT NULL COMMENT '博客ID',
  `term_id` bigint(20) NOT NULL COMMENT '对应term_taxonomy表中的term_taxonomy_id',
  KEY `term_id` (`term_id`) USING BTREE,
  KEY `post_id` (`post_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='关系表，多对多的，object_id是与不同的对象关联。\r\n从这个表可以获得一篇文章与标签、分类之间的关系，object_id为博文的ID，term_taxonomy_id为wp_term_taxonomy表中相应的标签、分类的ID。';

-- ----------------------------
-- Records of wla_post_term
-- ----------------------------

-- ----------------------------
-- Table structure for `wla_terms`
-- ----------------------------
DROP TABLE IF EXISTS `wla_terms`;
CREATE TABLE `wla_terms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(200) NOT NULL COMMENT '链接名',
  `slug` varchar(200) NOT NULL COMMENT '分类、标签缩写',
  `sort` smallint(6) NOT NULL DEFAULT '100' COMMENT '排序',
  `taxonomy` smallint(6) NOT NULL COMMENT '类型(0:category;1:tag;)',
  `description` longtext COMMENT '分类图片描述、标签描述',
  `parent` bigint(20) NOT NULL DEFAULT '0' COMMENT '父类ID',
  `term_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类下文章数量、当前标签所拥有文章数量',
  PRIMARY KEY (`id`),
  UNIQUE KEY `term_id` (`id`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `slug` (`slug`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='记录分类、标签的一些简要信息，包括名称，缩写。\r\n从这个表可以获得：分类、标签对应的ID，这个ID将在"wla_term_taxonomy"表中使用';

-- ----------------------------
-- Records of wla_terms
-- ----------------------------
INSERT INTO `wla_terms` VALUES ('1', 'PHP', 'php', '100', '0', '', '0', '0');
INSERT INTO `wla_terms` VALUES ('2', 'HTML', 'html', '100', '0', '', '0', '0');
INSERT INTO `wla_terms` VALUES ('3', 'JS', 'javascript', '100', '0', '', '0', '0');
INSERT INTO `wla_terms` VALUES ('4', 'MySQL', 'mysql', '100', '0', '', '0', '0');
INSERT INTO `wla_terms` VALUES ('5', 'Linux', 'linux', '100', '0', '', '0', '0');
INSERT INTO `wla_terms` VALUES ('6', '其他', 'other', '100', '0', '', '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of wla_user
-- ----------------------------
INSERT INTO `wla_user` VALUES ('10', 'adminlqm', 'resinchem@qq.com', '0ae9ca2f9ea60818f498fd6f04f603b9', '刘芊茉', '/Public/Uploads/avatar/2015-12-01-17-56-53/565d6ee5c946f.jpg', '这是一个非常可爱的宝宝', '10', null, '1448953976', '1448971841', '127.0.0.1');
INSERT INTO `wla_user` VALUES ('11', 'test001', 'test001@qq.com', 'fa820cc1ad39a4e99283e9fa555035ec', '测试账号', '', '这是一个测试账号', '10', null, '1448962108', '1448962234', '127.0.0.1');
