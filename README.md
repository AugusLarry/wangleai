忘了爱博客系统
==================
目录介绍
------------------
* wangleai [根目录]<br>
    * data [数据文件目录]<br>
    * Public [资源]<br>
        * static-admin [后台资源]<br>
        * static-index [前台资源]<br>
        * Uploads [上传目录]<br>
    * ThinkPHP [TP核心框架]<br>
    * Web [应用目录]<br>
        * Admin [后台模块]<br>
            * Conf [配置文件]<br>
            * Controller [控制器]<br>
            * Model [模型]<br>
            * TagLib [自定义标签]<br>
            * View [视图]<br>
        * Common [公共模块]<br>
            * Common [公共函数]<br>
            * Conf [公共配置]<br>
            * Model [公共模型]<br>
        * Index [前台模块]<br>
            * Conf [配置文件]<br>
            * Controller [控制器]<br>
            * TagLib [自定义标签]<br>
            * View [视图]<br>
        * Runtime [运行缓存文件目录]<br>
    * .gitignore<br>
    * .htaccess [apache rewrite文件]<br>
    * index.php [入口文件]<br>
    * README.md

数据库介绍
------------------
* wla_active_record [用户活动记录表]
    * id [主键ID]
    * uid [用户ID]
    * dateline [活动时间]
    * ip [活动IP]
    * module [操作模块]
* wla_auth_group [角色表]
    * id [主键ID]
    * title [角色中文名称]
    * status [状态：1正常，0禁用]
    * rules [角色拥有的权限id,多个权限","隔开]
* wla_auth_group_access [用户与角色中间表]
    * uid [用户ID]
    * group_id [角色ID]
* wla_auth_rule [权限表]
    * id [主键ID]
    * name [权限唯一英文标识]
    * title [权限中文标识]
    * type [权限类型,如果type为1,condition字段就可以定义规则表达式.如定义{score}>5 and {score}<100  表示用户的分数在5-100之间时这条规则才会通过。
    * status [状态：1正常，0禁用]
    * condition [规则附件条件,满足附加条件的规则,才认为是有效的规则]
* wla_comments [评论表]
    * comment_id [主键ID]
    * comment_post_id [评论所属文章ID]
    * comment_author [评论作者]
    * comment_author_email [评论者邮箱]
    * comment_author_url [评论者站点]
    * comment_author_ip [评论者IP]
    * created_at [评论时间]
    * comment_content [评论内容]
    * comment_type [评论状态(0:审核;1:正常;2:垃圾;3:回收站),默认为0]
    * comment_agent [评论者浏览器信息]
    * comment_parent [父评论ID]
    * user_id [评论者用户ID,默认为0,表示游客评论]
* wla_post_term [文章与链接中间表]
    * post_id [文章ID]
    * term_id [链接ID]
* wla_posts [文章表]
    * id [主键ID]
    * post_author [文章作者]
    * created_at [文章创建时间]
    * post_title [文章标题]
    * post_type [文章类型(0:普通;1:心情;2:音乐;3:图片;4:视频;),默认为0]
    * post_description [文章描述]
    * post_content [文章内容]
    * post_status [文章状态(0:发布;1:草稿;2:垃圾箱),默认为0]
    * comment_status [评论状态(0:可以评论;1:不能评论),默认为0]
    * comment_count [评论总数]
    * click_count [点击数]
* wla_terms [链接表]
    * id [主键ID]
    * name [链接名称]
    * slug [链接缩写]
    * sort [排序]
    * taxonomy [类型(0:category;1:tag;)]
    * description [链接图片描述]
    * parent [父分类ID]
    * term_count [分类下文章数量、当前标签所拥有文章数量]
* wla_user [用户表]
    * id [主键ID]
    * username [用户账号]
    * email [用户邮箱]
    * password [用户密码]
    * desplay_name [用户昵称]
    * avatar [用户头像]
    * description [用户描述]
    * status [帐号状态(0-10),默认为10]
    * password_reset_key [密码重置令牌]
    * created_at [用户创建时间]
    * updated_at [更新时间]
    * login_ip [登录IP]