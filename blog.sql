
drop database blog;
create database blog;

use blog;

#用户表：
CREATE TABLE `bl_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `acc` varchar(50) NOT NULL DEFAULT '' COMMENT '帐号',
  `pwd` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '昵称',
  `regtime` int unsigned DEFAULT 0 COMMENT '注册时间',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `is_admin` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '是否为后台管理员 0:否 1:是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

#博客文章表：
CREATE TABLE `bl_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '文章标题',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '文章简介',
  `content` text NOT NULL COMMENT '文章内容',
  `post_date` int(11) NOT NULL DEFAULT 0 COMMENT '发布时间',
  `user_id` int unsigned NOT NULL DEFAULT 0 COMMENT '管理员用户id',
  `user_nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员昵称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

#添加的字段
alter table bl_article add `category_id` int(11) unsigned NOT NULL COMMENT '所属分类的ID';


#博客文章分类表：
CREATE TABLE `bl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID，0表示顶级分类',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;


#评论表：
CREATE TABLE `bl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '所属文章ID',
  `article_title` varchar(100) NOT NULL DEFAULT '' COMMENT '所属文章标题',
  `user_id` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '用户ID',
  `user_nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `content` text NOT NULL COMMENT '评论内容',
  `add_time` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '评论时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

insert into bl_user (select null, acc, pwd, nickname, regtime, img, is_admin from bl_user) ;

insert into bl_comment (select null, article_id, article_title, user_id, user_nickname, content, add_time from bl_comment) ;